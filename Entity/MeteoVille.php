<?php

namespace MeteoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeteoVille
 *
 * @ORM\Table(name="meteo_ville")
 * @ORM\Entity(repositoryClass="MeteoBundle\Repository\MeteoVilleRepository")
 */
class MeteoVille
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
     * @var int
     *
     * @ORM\Column(name="idCountry", type="integer")
     */
    private $idCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text")
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    public function __construct()
    {
        $this->time = new \DateTime();
    }


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
     * Set idCountry
     *
     * @param integer $idCountry
     *
     * @return MeteoVille
     */
    public function setIdCountry($idCountry)
    {
        $this->idCountry = $idCountry;

        return $this;
    }

    /**
     * Get idCountry
     *
     * @return int
     */
    public function getIdCountry()
    {
        return $this->idCountry;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return MeteoVille
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return MeteoVille
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }
}

