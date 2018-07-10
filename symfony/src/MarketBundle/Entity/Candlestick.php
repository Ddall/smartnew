<?php

namespace MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * Candlestick
 *
 * @ORM\Table(name="candlestick_data")
 * @ORM\Entity(repositoryClass="MarketBundle\Repository\CandlestickRepository")
 */
class Candlestick
{
    /**
     * @var UuidInterface
     *
     * @ORM\Column(name="id", type="uuid", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="timestamp", type="float")
     */
    private $timestamp;

    /**
     * @var float
     *
     * @ORM\Column(name="open", type="float")
     */
    private $open;

    /**
     * @var float
     *
     * @ORM\Column(name="high", type="float")
     */
    private $high;

    /**
     * @var float
     *
     * @ORM\Column(name="low", type="float")
     */
    private $low;

    /**
     * @var float
     *
     * @ORM\Column(name="closing", type="float")
     */
    private $closing;

    /**
     * @var float
     *
     * @ORM\Column(name="volume", type="float")
     */
    private $volume;

    /**
     * @var string
     *
     * @ORM\Column(name="timeframe", type="string", length=255)
     */
    private $timeframe;

    /**
     * @var Market
     * @ORM\ManyToOne(targetEntity="MarketBundle\Entity\Market")
     * @ORM\JoinColumn(name="market_id", referencedColumnName="id", nullable=false, unique=false)
     */
    private $market;

    /**
     * Candlestick constructor.
     *
     * @param array  $raw_ohlcv
     * @param        $timeframe
     * @param Market $market
     */
    public function __construct(array $raw_ohlcv_line, $timeframe, Market $market) {
        $this->market = $market;
        $this->timeframe = $timeframe;

        $this->timestamp = $raw_ohlcv_line[0];
        $this->open = $raw_ohlcv_line[1];
        $this->high = $raw_ohlcv_line[2];
        $this->low = $raw_ohlcv_line[3];
        $this->closing = $raw_ohlcv_line[4];
        $this->volume = $raw_ohlcv_line[5];

    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set timestamp.
     *
     * @param int $timestamp
     *
     * @return Candlestick
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp.
     *
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set open.
     *
     * @param float $open
     *
     * @return Candlestick
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get open.
     *
     * @return float
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set high.
     *
     * @param float $high
     *
     * @return Candlestick
     */
    public function setHigh($high)
    {
        $this->high = $high;

        return $this;
    }

    /**
     * Get high.
     *
     * @return float
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * Set low.
     *
     * @param float $low
     *
     * @return Candlestick
     */
    public function setLow($low)
    {
        $this->low = $low;

        return $this;
    }

    /**
     * Get low.
     *
     * @return float
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * Set closing.
     *
     * @param float $closing
     *
     * @return Candlestick
     */
    public function setClosing($closing)
    {
        $this->closing = $closing;

        return $this;
    }

    /**
     * Get closing.
     *
     * @return float
     */
    public function getClosing()
    {
        return $this->closing;
    }

    /**
     * Set volume.
     *
     * @param float $volume
     *
     * @return Candlestick
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume.
     *
     * @return float
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set timeframe.
     *
     * @param string $timeframe
     *
     * @return Candlestick
     */
    public function setTimeframe($timeframe)
    {
        $this->timeframe = $timeframe;

        return $this;
    }

    /**
     * Get timeframe.
     *
     * @return string
     */
    public function getTimeframe()
    {
        return $this->timeframe;
    }

    /**
     * Set market.
     *
     * @param string $market
     *
     * @return Candlestick
     */
    public function setMarket($market)
    {
        $this->market = $market;

        return $this;
    }

    /**
     * Get market.
     *
     * @return string
     */
    public function getMarket()
    {
        return $this->market;
    }
}
