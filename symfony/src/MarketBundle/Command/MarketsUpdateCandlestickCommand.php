<?php

namespace MarketBundle\Command;

use AppBundle\Exception\InvalidParameter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MarketsUpdateCandlestickCommand extends ContainerAwareCommand {

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('markets:update:candlestick')
            ->setDescription('Updates Candlestick data on enabled markets')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        // Fetching all markets
        $exchangeManager = $this->getContainer()->get('exchange.manager');

        $exchanges = $exchangeManager->getAvailableExchanges();

        foreach ($exchanges as $name => $exchange){

            try{
                $markets = $exchangeManager->getExchangeMarkets($name);
            }catch (InvalidParameter $exception){
                $output->writeln('Error: Could not fetch markets for ' . $name);
                continue;
            }

            if(is_array($markets)){
                $output->writeln('Starting on ' . $name);

                foreach ($markets as $market){
                }

            }else{
                $output->writeln('Skipping ' . $name . ' (no markets in parameters.yml)');
            }



        }
    }
}
