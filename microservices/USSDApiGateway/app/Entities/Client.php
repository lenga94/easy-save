<?php


namespace App\Entities;


use JsonSerializable;

class Client implements JsonSerializable
{
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $nrc;
    private $address;
    private $gender;
    private $dob;

    /**
     * Client constructor.
     * @param $firstName
     * @param $lastName
     * @param $phoneNumber
     */
    public function __construct($firstName, $lastName, $phoneNumber)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
    }

    //set methods
    public function setNrc($nrc): void
    {
        $this->nrc = $nrc;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    public function setDob($dob): void
    {
        $this->dob = $dob;
    }

    //get methods
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getNrc()
    {
        return $this->nrc;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getDob()
    {
        return $this->dob;
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
