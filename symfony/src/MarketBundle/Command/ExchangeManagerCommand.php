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
            ->setDescription('Show markets config from DB')
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
            $output->writeln('Market '. $name);
            $output->writeln(' hax ' .count($exchangeManager->getEnabledMarketsFor($name)) . ' enabled markets');
            $output->writeln(' has ' .count($markets) . ' available markets' );
            $output->writeln(null);
        }


    }
}
