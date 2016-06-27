<?php

namespace MeteoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * meteo
 *
 * @ORM\Table(name="meteo")
 * @ORM\Entity(repositoryClass="MeteoBundle\Repository\MeteoRepository")
 */
class Meteo
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
     * @ORM\Column(name="country", type="integer", nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="input", type="string", length=255, nullable=true)
     */
    private $input;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text")
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="data_un", type="text")
     */
    private $dataUn;

    /**
     * @var string
     *
     * @ORM\Column(name="data_deux", type="text")
     */
    private $dataDeux;

    /**
     * @var string
     *
     * @ORM\Column(name="data_trois", type="text")
     */
    private $dataTrois;

    /**
     * @var string
     *
     * @ORM\Column(name="data_quatre", type="text")
     */
    private $dataQuatre;

    /**
     * @var string
     *
     * @ORM\Column(name="data_cinq", type="text")
     */
    private $dataCinq;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set country
     *
     * @param integer $country
     *
     * @return meteo
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return int
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set input
     *
     * @param string $input
     *
     * @return meteo
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
     * Set latitude
     *
     * @param float $latitude
     *
     * @return meteo
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return meteo
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return meteo
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
     * Set dataUn
     *
     * @param string $dataUn
     *
     * @return meteo
     */
    public function setDataUn($dataUn)
    {
        $this->dataUn = $dataUn;

        return $this;
    }

    /**
     * Get dataUn
     *
     * @return string
     */
    public function getDataUn()
    {
        return $this->dataUn;
    }

    /**
     * Set dataDeux
     *
     * @param string $dataDeux
     *
     * @return meteo
     */
    public function setDataDeux($dataDeux)
    {
        $this->dataDeux = $dataDeux;

        return $this;
    }

    /**
     * Get dataDeux
     *
     * @return string
     */
    public function getDataDeux()
    {
        return $this->dataDeux;
    }

    /**
     * Set dataTrois
     *
     * @param string $dataTrois
     *
     * @return meteo
     */
    public function setDataTrois($dataTrois)
    {
        $this->dataTrois = $dataTrois;

        return $this;
    }

    /**
     * Get dataTrois
     *
     * @return string
     */
    public function getDataTrois()
    {
        return $this->dataTrois;
    }

    /**
     * Set dataQuatre
     *
     * @param string $dataQuatre
     *
     * @return meteo
     */
    public function setDataQuatre($dataQuatre)
    {
        $this->dataQuatre = $dataQuatre;

        return $this;
    }

    /**
     * Get dataQuatre
     *
     * @return string
     */
    public function getDataQuatre()
    {
        return $this->dataQuatre;
    }

    /**
     * Set dataCinq
     *
     * @param string $dataCinq
     *
     * @return meteo
     */
    public function setDataCinq($dataCinq)
    {
        $this->dataCinq = $dataCinq;

        return $this;
    }

    /**
     * Get dataCinq
     *
     * @return string
     */
    public function getDataCinq()
    {
        return $this->dataCinq;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return meteo
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

