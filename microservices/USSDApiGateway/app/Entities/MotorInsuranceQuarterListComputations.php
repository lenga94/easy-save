<?php


namespace App\Entities;


use JsonSerializable;

class MotorInsuranceQuarterListComputations implements JsonSerializable
{
    private $startDate;
    private $endDate;
    private $premium;
    private $numberOfQuarters;
    private $numberOfDays;

    /**
     * MotorInsuranceQuarterListComputations constructor.
     * @param $startDate
     * @param $endDate
     * @param $premium
     * @param $numberOfQuarters
     * @param $numberOfDays
     */
    public function __construct($startDate, $endDate, $premium, $numberOfQuarters, $numberOfDays)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->premium = $premium;
        $this->numberOfQuarters = $numberOfQuarters;
        $this->numberOfDays = $numberOfDays;
    }


    //set methods
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    public function setPremium($premium): void
    {
        $this->premium = $premium;
    }

    public function setNumberOfQuarters($numberOfQuarters): void
    {
        $this->numberOfQuarters = $numberOfQuarters;
    }

    public function setNumberOfDays($numberOfDays): void
    {
        $this->numberOfDays = $numberOfDays;
    }



    //get methods
    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getPremium()
    {
        return $this->premium;
    }

    public function getNumberOfQuarters()
    {
        return $this->numberOfQuarters;
    }

    public function getNumberOfDays()
    {
        return $this->numberOfDays;
    }




    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
