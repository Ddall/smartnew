<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hello
 *
 * @ORM\Table(name="hello")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HelloRepository")
 */
class Hello
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="world", type="string", length=255)
     */
    private $world;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set world
     *
     * @param string $world
     *
     * @return Hello
     */
    public function setWorld($world)
    {
        $this->world = $world;

        return $this;
    }

    /**
     * Get world
     *
     * @return string
     */
    public function getWorld()
    {
        return $this->world;
    }
}

