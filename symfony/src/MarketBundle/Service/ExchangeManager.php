<?php
/**
 * SmartNew - ExchangeManager.php
 * Created by Allan.
 */

namespace MarketBundle\Service;


use ccxt\Exchange;

class ExchangeManager {

    /**
     * @var array
     */
    private $exchangesConfig;

    /**
     * ExchangeManager constructor.
     *
     * @param array $exchangesConfig
     * @param bool  $strict
     */
    public function __construct($exchangesConfig = array(), $strict = false) {
        $this->exchangesConfig = $exchangesConfig;
    }


    public function getExchange($name){
        if(array_key_exists($name, $this->exchangesConfig) === false){
            throw new InvalidParameter
        }
    }


    /**
     * @param       $name
     * @param array $config
     * @return bool|Exchange
     */
    private function hydrateExchange($name, $config = array()){
        $className = 'ccxt\\' . $name;
        try{
            /**
             * @var $exchange Exchange
             */
            $exchange = new $className($config);
            $exchange = $this->setDefaultOptions($exchange);

            return $exchange;
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * @param Exchange $exchange
     * @return Exchange
     */
    private function setDefaultOptions(Exchange $exchange){
        $exchange->enableRateLimit = true;

        return $exchange;
    }

    /**
     * @return array
     */
    public function getExchangesConfig(){
        return $this->exchangesConfig;
    }
}
