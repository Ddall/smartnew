<?php

namespace AppBundle\Command;

use ccxt\Exchange;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchTickersCommand extends ContainerAwareCommand {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('ccxt:tickers')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        // Create exchanges
        $exchanges = array();
        foreach (Exchange::$exchanges as $className){
            $t = 'ccxt\\' . $className;
            $exchange = new $t;
            $exchange->enableRateLimit = true;
            $exchanges[$className] = $exchange;
        }


        /**
         * @var $exchange Exchange
         */
        foreach ($exchanges as $exchangeName => $exchange){

            if($exchange->has('fetchMarkets')){

                if(!in_array($exchangeName, array(
//                    'kraken',
//                    'gdax',
//                    'cex',
                    'paymium',
                ))) {
                    continue;
                }

                $output->writeln('<info>'.$exchange->name.' markets</info>');

                try{
                    foreach ($exchange->fetchMarkets() as $key => $market) {

                        $tickers = $exchange->fetchTicker('BTC/EUR');
                        $output->writeln(print_r($tickers, true));
                    }
                }catch (\Exception $exception){
                    $output->writeln($exchange->name . ' ' .gettype($exception) . ' '. $exception->getMessage());

                }





            }else{
                $output->writeln($exchange->name . ' IS A PARTY POOPER');
            }
        }

    }
}
