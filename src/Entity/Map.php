<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MapRepository")
 */
class Map
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank()
     */
    private $city_name;

    /**
     * @ORM\Column(type="integer", unique=true)
     * @Assert\NotBlank()
     */
    private $open_weather_id;

    public function getId()
    {
        return $this->id;
    }

    public function getCityName()
    {
        return $this->city_name;
    }

    public function setCityName($name)
    {
        $this->city_name = $name;
    }


    public function getOpenWeatherId()
    {
        return $this->open_weather_id;
    }

    public function setOpenWeatherId($ow_id)
    {
        $this->open_weather_id = $ow_id;
    }
}
