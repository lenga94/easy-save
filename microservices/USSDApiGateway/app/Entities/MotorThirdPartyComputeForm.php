<?php


namespace App\Entities;


class MotorThirdPartyComputeForm
{
    private $startDate;
    private $productTypeId;

    /**
     * MotorThirdPartyComputeForm constructor.
     * @param $startDate
     * @param $productTypeId
     */
    public function __construct($startDate, $productTypeId)
    {
        $this->startDate = $startDate;
        $this->productTypeId = $productTypeId;
    }

    //set methods
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    public function setProductTypeId($productTypeId): void
    {
        $this->productTypeId = $productTypeId;
    }


    //get methods
    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getProductTypeId()
    {
        return $this->productTypeId;
    }
}
