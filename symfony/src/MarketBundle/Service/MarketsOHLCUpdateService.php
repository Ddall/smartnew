<?php
/**
 * SmartNew - MarketsOHLCUpdateService.phpService.php
 * Created by Allan.
 */

namespace MarketBundle\Service;


use ccxt\Exchange;
use Doctrine\ORM\EntityManager;

class MarketsOHLCUpdateService {

    /**
     * @var ExchangeManager
     */
    private $exchangeManager;

    /**
     * @var array
     */
    private $symbols;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var array
     */
    private $defaultOptions;

    /**
     * MarketsOHLCUpdateService constructor.
     *
     * @param ExchangeManager $exchangeManager
     * @param                 $symbols
     */
    public function __construct(ExchangeManager $exchangeManager, array $symbols, EntityManager $entityManager) {
        $this->exchangeManager = $exchangeManager;
        $this->symbols = $symbols;
        $this->entityManager = $entityManager;

        $this->defaultOptions = array(
            'timeframe' => '1m',
            'since' => new \DateTime('yesterday'),
        );
    }


    /**
     * @param Exchange $exchange
     * @param          $symbol
     * @param array    $options
     * @return array
     */
    public function update(Exchange $exchange, $symbol, $options = array()){
        if(empty($options)){
            $options = $this->defaultOptions;
        }

        $data = $exchange->fetchOHLCV($symbol, $options['timeframe'], $options['since']);

        return $data;
    }
}
