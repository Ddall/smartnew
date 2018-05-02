<?php

namespace MarketBundle\Command;

use ccxt\Exchange;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExchangeManagerCommand extends ContainerAwareCommand {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('manager:exchanges')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $exchangeManager = $this->getContainer()->get('exchange.manager');

        /**
         * @var $exchanges Exchange[]
         */
        $exchanges = $exchangeManager->getAvailableExchanges();

        foreach ($exchanges as $name => $exchange){
            $markets = $exchange->fetchMarkets();
            $output->writeln($name . ' has ' .count($markets) . ' available markets' );
        }




    }
}
