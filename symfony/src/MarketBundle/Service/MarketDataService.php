<?php
/**
 * SmartNew - MarketDataService.php * Created by Allan.
 */

namespace MarketBundle\Service;


use Doctrine\ORM\EntityManager;
use MarketBundle\Entity\Candlestick;
use MarketBundle\Entity\Market;
use MarketBundle\Exception\MarketFunctionalityUnavailable;

class MarketDataService {

    const BATCH_SIZE = 1000;

    /**
     * @var ExchangeManager
     */
    private $exchangeManager;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * MarketDataService constructor.
     *
     * @param ExchangeManager $exchangeManager
     * @param EntityManager   $entityManager
     */
    public function __construct(ExchangeManager $exchangeManager, EntityManager $entityManager) {
        $this->exchangeManager = $exchangeManager;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Market    $market
     * @param \DateTime $since
     * @param string    $timeframe
     * @return bool|integer
     * @throws \AppBundle\Exception\InvalidParameter
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws MarketFunctionalityUnavailable
     */
    public function updateCandlestickData(Market $market, \DateTime $since, $timeframe = '1m'){
        $ccxtExchange = $this->exchangeManager->getExchange($market->getExchange());

        if($ccxtExchange->has('fetchOHLCV') === false){
            throw new MarketFunctionalityUnavailable('Market ' . get_class($market) . ' has no fetchOHLCV method available');
        }

        $rawOHLCV = $ccxtExchange->fetchOHLCV($market->getSymbol(), $timeframe, $since);

        // format data
        $candlesticks = array();
        foreach ($rawOHLCV as $item){
            $candlesticks[] = new Candlestick($item, $timeframe, $market);
        }

        // persist
        $i = 0;

        /**
         * @var $candlestick Candlestick
         */
        foreach ($candlesticks as $candlestick){
            $candlestick->setMarket($market);
            $this->entityManager->persist($candlestick);

            if($i > self::BATCH_SIZE){
                $this->entityManager->flush();
                $this->entityManager->clear();
                $i = 0;
            }
            $i++;

        }

        $this->entityManager->flush();
        $this->entityManager->clear();
        return count($candlesticks);
    }

    public function updateTicker(Market $market){

    }

    public function updateTrades(Market $market){

    }

    public function updateOrderBook(Market $market){

    }

}
