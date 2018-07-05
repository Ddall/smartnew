<?php

namespace MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Market
 *
 * @ORM\Table(name="market")
 * @ORM\Entity(repositoryClass="MarketBundle\Repository\MarketRepository")
 */
class Market
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $idLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=255)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=255)
     */
    private $symbol;

    /**
     * @var string
     *
     * @ORM\Column(name="base", type="string", length=255)
     */
    private $base;

    /**
     * @var string
     *
     * @ORM\Column(name="quote", type="string", length=255)
     */
    private $quote;


    /**
     * @var array
     *
     * @ORM\Column(name="info", type="array", nullable=true)
     */
    private $info;

    /**
     * @var string
     *
     * @ORM\Column(name="exchange", type="string", length=255)
     */
    private $exchange;

    /**
     * Market constructor.
     *
     * @param array $data
     */
    public function __construct($data = array()) {
        $this->info = array();

        if(empty($data) === false){
            $this->hydrateFromArray($data);
        }
    }

    /**
     * @param array $data
     */
    public function hydrateFromArray(array $data){

        if(array_key_exists('id', $data)){
            $this->id = $data['id'] ;
        }

        if(array_key_exists('symbol', $data)){
            $this->symbol = $data['symbol'] ;
        }

        if(array_key_exists('base', $data)){
            $this->base = $data['base'] ;
        }

        if(array_key_exists('quote', $data)){
            $this->quote = $data['quote'];
        }

        if(array_key_exists('exchange', $data)){
            $this->exchange = $data['exchange'] ;
        }

    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getIdLocal()
    {
        return $this->idLocal;
    }

    /**
     * Set identifier.
     *
     * @param string $id
     *
     * @return Market
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get identifier.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set symbol.
     *
     * @param string $symbol
     *
     * @return Market
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set base.
     *
     * @param string $base
     *
     * @return Market
     */
    public function setBase($base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get base.
     *
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set quote.
     *
     * @param string $quote
     *
     * @return Market
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;

        return $this;
    }

    /**
     * Get quote.
     *
     * @return string
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Set exchange.
     *
     * @param string $exchange
     *
     * @return Market
     */
    public function setExchange($exchange)
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * Get exchange.
     *
     * @return string
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * @return array
     */
    public function getInfo(): array {
        return $this->info;
    }

    /**
     * @param array $info
     * @return Market
     */
    public function setInfo(array $info): Market {
        $this->info = $info;
        return $this;
    }


}
