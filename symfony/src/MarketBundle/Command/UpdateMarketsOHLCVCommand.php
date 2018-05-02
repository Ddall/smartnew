<?php

namespace MarketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateMarketsOHLCVCommand extends ContainerAwareCommand {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('markets:update:ohlcv')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
//        $updateService = $this->getContainer()->get('markets.update.ohlc');
        $exchange = $this->getContainer()->get('exchange.manager')->getExchange('kraken');
        $symbol = 'BTC/EUR';

        $output->writeln('Fetching OHLCV');
        $since = new \DateTime('today');
        $data = $exchange->fetchOHLCV($symbol, '1m', $since->getTimestamp());

        $output->writeln('Size of data: ' . count($data));

        $averages = array();
        foreach ($data as $index => $datum){
            $averages[$index] = ($datum['1'] + $datum['2'] + $datum['3'] + $datum['4'])/4;
        }

        $output->writeln('MA 60:');
        print_r(trader_ma($averages, 60));
        $output->writeln('averages:');
        print_r($averages);

    }
}
