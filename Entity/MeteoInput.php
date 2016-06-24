<?php

namespace MeteoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeteoInput
 *
 * @ORM\Table(name="meteo_input")
 * @ORM\Entity(repositoryClass="MeteoBundle\Repository\MeteoInputRepository")
 */
class MeteoInput
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
     * @ORM\Column(name="input", type="string", length=255)
     */
    private $input;

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
     * Set input
     *
     * @param string $input
     *
     * @return MeteoInput
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get input
     *
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return MeteoInput
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
     * @return MeteoInput
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

