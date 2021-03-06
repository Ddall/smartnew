<?php

namespace MarketBundle\Command;


use ccxt\bit2c;
use ccxt\Exchange;
use ccxt\kraken;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TmpCcxtListMarketsCommand extends ContainerAwareCommand {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('markets:list:remote')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        // Create exchanges
        $exchanges = $this->getContainer()->get('exchange.manager')->getAvailableExchanges();

        /**
         * @var $exchange Exchange
         */
        foreach ($exchanges as $exchangeName => $exchange){
            if($exchange->has('fetchMarkets')){


                $output->writeln('<info>'.$exchange->name.' markets</info>');
                $table = new Table($output);
                $table->setHeaders(array(
                    '#',
                    'Symbol',
                    'Base',
                    'Quote',
                ));
                try{
                    foreach ($exchange->fetchMarkets() as $key => $market){
                        $table->addRow(array(
                            $key,
                            $market['symbol'],
                            $market['base'],
                            $market['quote'],
                        ));
                    }
                    $table->render();

                    $output->writeln(print_r($market, true));

                }catch (\Exception $exception){
                    $output->writeln($exchange->name . ' ' .gettype($exception) . ' '. $exception->getMessage());

                }





            }else{
                $output->writeln($exchange->name . ' IS A BIG MEANIE');
            }
        }

    }


}


