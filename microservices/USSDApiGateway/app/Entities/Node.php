<?php


namespace App\Entities;


use JsonSerializable;

class Node implements JsonSerializable
{
    private $data;
    private $next;

    public function __construct($data = null)
    {
        $this->data = $data;
    }


    //set methods
    public function setData($data): void
    {
        $this->data = $data;
    }

    public function setNext($next): void
    {
        $this->next = $next;
    }


    //get methods
    public function getData()
    {
        return $this->data;
    }

    public function getNext()
    {
        return $this->next;
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
