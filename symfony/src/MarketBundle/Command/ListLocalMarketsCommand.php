<?php

namespace MarketBundle\Command;

use MarketBundle\Entity\Market;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListLocalMarketsCommand extends ContainerAwareCommand {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('markets:list:local')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $marketsRepo = $this->getContainer()->get('doctrine')->getRepository(Market::class);

        /**
         * @var $markets Market[]
         */
        $markets = $marketsRepo->findAll();

        $table = new Table($output);
        $table->setHeaders(array(
            '#',
            'id',
            'symbol',
            'base',
            'quote',
            'exchange',
        ));

        foreach ($markets as $market){
            $table->addRow(array(
                $market->getIdLocal(),
                $market->getId(),
                $market->getSymbol(),
                $market->getBase(),
                $market->getQuote(),
            ));
        }

        $table->render();
    }
}
