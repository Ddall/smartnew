<?php
/**
 * SmartNew - ManagedExchange.php
 * Created by Allan.
 */

namespace MarketBundle\Entity;


use ccxt\Exchange;

class ManagedExchange {

    /**
     * @var Exchange
     */
    private $ccxtExchange;

    /**
     * @var array
     */
    private $marketsConfig;


    public function __construct(Exchange $exchange, array $marketsConfig) {
        $this->ccxtExchange = $exchange;
        $this->marketsConfig = $marketsConfig;
    }


    /**
     * @return Exchange
     */
    public function getExchange(){
        return $this->ccxtExchange;
    }

    /**
     * @return array
     */
    public function getMarkets(){
        $arr = array();

        foreach ($this->marketsConfig as $id => $data){
            $arr[] = $data['name'];
        }
        return $arr;
    }


    
}
