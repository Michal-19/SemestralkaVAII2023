<?php

namespace App\Models;

use App\Core\Model;

class FoodType extends Model
{
    protected $id;
    protected $name;
    protected $createdBy;
    protected $createdTime;
    protected $lastEditedBy;
    protected $lastEditedTime;

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
    public function getLastEditedTime()
    {
        return $this->lastEditedTime;
    }

    /**
     * @param mixed $lastEditedTime
     */
    public function setLastEditedTime($lastEditedTime): void
    {
        $this->lastEditedTime = $lastEditedTime;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param mixed $createdTime
     */
    public function setCreatedTime($createdTime): void
    {
        $this->createdTime = $createdTime;
    }

    /**
     * @return mixed
     */
    public function getLastEditedBy()
    {
        return $this->lastEditedBy;
    }

    /**
     * @param mixed $lastEditedBy
     */
    public function setLastEditedBy($lastEditedBy): void
    {
        $this->lastEditedBy = $lastEditedBy;
    }
}