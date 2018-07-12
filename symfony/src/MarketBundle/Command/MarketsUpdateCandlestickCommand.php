<?php

namespace MarketBundle\Command;

use AppBundle\Exception\InvalidParameter;
use MarketBundle\Entity\Candlestick;
use MarketBundle\Entity\Market;
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

        $em = $this->getContainer()->get('doctrine')->getManager();

        // Fetching all markets
        $exchangeManager = $this->getContainer()->get('exchange.manager');

        $exchanges = $exchangeManager->getAvailableExchanges();
        $availableMarkets = $em->getRepository(Market::class)->findAll();

        /**
         * @var $market Market
         */
        foreach ($availableMarkets as $market){
            $output->write('Working on ' . $market->getSymbol() . ' on ' . $market->getExchange());

            $exchangeConfig = $exchangeManager->getExchangeConfig($market->getExchange());
            $marketConfig = $this->getConfigFor($exchangeConfig, $market->getSymbol());

            if(array_key_exists($market->getExchange(), $exchanges)){
                $exchange = $exchanges[$market->getExchange()];
            }else{
                $output->writeln(' ERROR FETCHING EXCHANGE ' . $market->getExchange());
                continue;
            }

            // Find last call
            $lastCandle = $em->getRepository(Candlestick::class)->getLastCandleFor($market);


            $output->write('. Last known candle: ' );
            if($lastCandle instanceof Candlestick === false){ // FIRST RUN MODE
                $lastCall = null;
                $output->writeln('None');

            }else{ // REGULAR RUN MODE
                $lastCall = $lastCandle->getTimestamp();

                $output->writeln($lastCandle->getDate()->format(DATE_ATOM));
            }


            $candleData = $exchange->fetchOHLCV($market->getSymbol(), $marketConfig['timeframe'], $lastCall);

            $output->write('Saving ' . count($candleData) . ' candles');

            foreach ($candleData as $candleDatum){
                $tmpCandle = new Candlestick($candleDatum, $marketConfig['timeframe'], $market);
                $em->persist($tmpCandle);
            }

            $em->flush();
            $output->writeln('Done');


        }

    }

    /**
     * @param $config
     * @param $market
     * @return null
     */
    protected function getConfigFor($config, $market){
        foreach ($config as $key => $values){
            if($values['name'] = $market){
                return $values;
            }
        }
        return null;
    }
}
