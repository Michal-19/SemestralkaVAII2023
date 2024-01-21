<?php

namespace App\Models;

use App\Core\Model;

class Menu extends Model
{
    protected $id;
    protected $name;
    protected $soup;
    protected $mainFood;
    protected $day;
    protected $price;
    protected $priceUnit;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSoup()
    {
        return $this->soup;
    }

    /**
     * @param mixed $soup
     */
    public function setSoup($soup): void
    {
        $this->soup = $soup;
    }

    /**
     * @return mixed
     */
    public function getMainFood()
    {
        return $this->mainFood;
    }

    /**
     * @param mixed $mainFood
     */
    public function setMainFood($mainFood): void
    {
        $this->mainFood = $mainFood;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day): void
    {
        $this->day = $day;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPriceUnit()
    {
        return $this->priceUnit;
    }

    /**
     * @param mixed $priceUnit
     */
    public function setPriceUnit($priceUnit): void
    {
        $this->priceUnit = $priceUnit;
    }
}