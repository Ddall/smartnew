<?php

namespace MarketBundle\Command;

use MarketBundle\Entity\Market;
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

//        $output->writeln('')
        $markets = array();
        foreach ($exchanges as $name => $exchange){

            $marketsData = $exchange->fetchMarkets();

            foreach ($marketsData as $market){
                $i = new Market($market);
                $i->setExchange($name);
                $markets[] = $i;
            }
        }

        $existing = $this->getContainer()->get('doctrine')->getRepository(Market::class)->findAll();
        $output->write('Removing ' . count($existing) . ' markets ');
        $em = $this->getContainer()->get('doctrine')->getManager();
        foreach ($existing as $e){
            $em->remove($e);
        }
        $em->flush();
        $output->writeln('done');

        // save all
        $output->write('Saving ' . count($markets) . ' markets ');
        foreach ($markets as $name => $marketEntity){
            $em->persist($marketEntity);
        }

        $em->flush();
        $output->writeln('done');

    }
}