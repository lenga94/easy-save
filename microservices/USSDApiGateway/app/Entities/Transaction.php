<?php


namespace App\Entities;


use JsonSerializable;

class Transaction implements JsonSerializable
{
    private $productType;
    private $client;
    private $coverType;
    private $coverStartDate;
    private $coverEndDate;
    private $coverPeriod;
    private $coverPeriodType;
    private $riskDetails;
    private $premium;
    private $status;

    /**
     * Transaction constructor.
     * @param $productType
     */
    public function __construct($productType){
        $this->productType = $productType;
        $this->status = "QUOTATION";
        $this->riskDetails = array();
    }

    //set methods
    public function setProductType($productType): void
    {
        $this->productType = $productType;
    }

    public function setCoverType($coverType): void
    {
        $this->coverType = $coverType;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function setCoverStartDate($coverStartDate): void
    {
        $this->coverStartDate = $coverStartDate;
    }

    public function setCoverEndDate($coverEndDate): void
    {
        $this->coverEndDate = $coverEndDate;
    }

    public function setCoverPeriod($coverPeriod)
    {
        $this->coverPeriod = $coverPeriod;
    }

    public function setCoverPeriodType($coverPeriodType)
    {
        $this->coverPeriodType = $coverPeriodType;
    }

    public function setRiskDetails($riskDetails): void
    {
        $this->riskDetails = $riskDetails;
    }

    public function setRiskDetail($riskAttribute, $riskDetail)
    {
        $this->riskDetails[$riskAttribute] = $riskDetail;
    }

    public function setPremium($premium): void
    {
        $this->premium = $premium;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    //get methods
    public function getProductType()
    {
        return $this->productType;
    }

    public function getCoverType()
    {
        return $this->coverType;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getCoverStartDate()
    {
        return $this->coverStartDate;
    }

    public function getCoverEndDate()
    {
        return $this->coverEndDate;
    }

    public function getCoverPeriod()
    {
        return $this->coverPeriod;
    }

    public function getCoverPeriodType()
    {
        return $this->coverPeriodType;
    }

    public function getRiskDetails(): array
    {
        return $this->riskDetails;
    }

    public function getRiskDetail($riskAttribute)
    {
        return $this->riskDetails[$riskAttribute];
    }

    public function getPremium()
    {
        return $this->premium;
    }

    public function getStatus()
    {
        return $this->status;
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
