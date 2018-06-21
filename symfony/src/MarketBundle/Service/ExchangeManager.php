<?php
/**
 * SmartNew - ExchangeManager.php
 * Created by Allan.
 */

namespace MarketBundle\Service;


use AppBundle\Exception\InvalidParameter;
use ccxt\Exchange;

class ExchangeManager {

    /**
     * @var array
     */
    private $exchangesConfig;

    /**
     * @var boolean
     */
    private $strict;

    /**
     * ExchangeManager constructor.
     *
     * @param array $exchangesConfig
     * @param bool  $strict
     * @throws InvalidParameter
     */
    public function __construct($exchangesConfig = array(), $strict = false) {

        // checking exchanges
        foreach ($exchangesConfig as $name => $options){

            if($this->checkExchangeAvailability($name) === false){

                if($strict === true){
                    throw new InvalidParameter('could not find ' . $name . ' is this exchange available through ccxt?');
                }else{
                    unset($exchangesConfig[$name]);
                }

            }
        }

        $this->exchangesConfig = $exchangesConfig;
        $this->strict = $strict;
    }

    // Simple exchange

    /**
     * @param $name
     * @param $options
     * @return bool|Exchange
     * @throws InvalidParameter
     */
    public function getExchange($name){
        if($this->isExchangeConfigAvailable($name) == false){
            throw new InvalidParameter('could not fetch configuration for ' . $name . ' is this exchange enabled?');
        }

        return $this->hydrateExchange($name, $this->exchangesConfig[$name]);
    }

    /**
     * @return array
     */
    public function getAvailableExchangesNames(){
        return array_keys($this->exchangesConfig);
    }

    /**
     * @return Exchange[]
     */
    public function getAvailableExchanges(){
        $exchanges = array();
        foreach ($this->getAvailableExchangesNames() as $name){
            $exchanges[$name] = $this->getExchange($name);
        }
        return $exchanges;
    }

    // END Simple exchange

    /**
     * @param $name
     * @return mixed
     * @throws InvalidParameter
     */
    public function getExchangeMarkets($name){
        if($this->isExchangeConfigAvailable($name)){
            throw new InvalidParameter('could not fetch configuration for ' . $name . ' is this exchange enabled?');
        }

        return $this->exchangesConfig[$name]['markets'];
    }

    //-- Private

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
     * @param $name
     * @return bool
     */
    private function checkExchangeAvailability($name){
        if(in_array($name, Exchange::$exchanges)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $name
     * @return bool
     */
    private function isExchangeConfigAvailable($name){
        return array_key_exists($name, $this->exchangesConfig);
    }

}
