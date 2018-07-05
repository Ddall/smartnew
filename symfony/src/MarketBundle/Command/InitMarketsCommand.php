<?php

namespace MarketBundle\Command;

use MarketBundle\Entity\Market;
use MarketBundle\Exception\MarketException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InitMarketsCommand
 *
 * @todo this functionality should not be required, move to a service to automate
 *
 * @package MarketBundle\Command
 */
class InitMarketsCommand extends ContainerAwareCommand {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('markets:init')
            ->setDescription('Persist markets parameters from .yml to DB')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $exchangesManager = $this->getContainer()->get('exchange.manager');
        $exchanges = $exchangesManager->getAvailableExchanges();
        $markets = array();

        foreach ($exchanges as $name => $exchange){
            $output->write('Exchange ' . $name . ' has ');
            $config = $exchangesManager->getExchangeConfig($name);
            $output->writeln(count($config) . ' markets enabled in parameters.yml');

            $allMarkets = $exchange->fetchMarkets();

            foreach ($config as $id => $values){
                $rawMarket = $this->findMarketBySymbol($allMarkets, $values['name']);

                if(is_array($rawMarket) === false){
                    throw new MarketException('Could not load market from parameters.yml:'. $id);
                }

                $newMarket = new Market($rawMarket);
                $newMarket->setExchange($name);
                $markets[] = $newMarket;

            }
        }

        // persist
        $em = $this->getContainer()->get('doctrine')->getManager();
        foreach ($markets as $market){

            // check if it exists
            $persistedMarket = $em->getRepository(Market::class)->findOneBy(array(
                'symbol' => $market->getSymbol(),
                'exchange' => $market->getExchange(),
            ));

            if($persistedMarket instanceof Market === false){
                $output->writeln('    ' . $market->getSymbol() . ' on ' . $market->getExchange() . ' will be created');
                $em->persist($market);
            }else{
                $output->writeln('    ' . $market->getSymbol() . ' on ' . $market->getExchange() . ' already exists');
            }
        }
        $em->flush();
    }


    /**
     * @param array $markets
     * @param       $symbol
     * @return array|null
     */
    protected function findMarketBySymbol(array $markets, $symbol){
        foreach ($markets as $key => $market){
            if($market['symbol'] == $symbol){
                return $market;
            }
        }
        return null;
    }
}
