<?php

namespace App\Entities;

use JsonSerializable;

class USSDHandler implements JsonSerializable
{
    private $input;
    private $msisdn;
    private $sessionId;
    private $responseBody;
    private $isNewRequest;
    private $isSessionContinuing;
    private $sessionVariables;
    private $sessionHistory;


    public function __construct($input, $sessionId, $msisdn, $isNewRequest)
    {
        $this->input = $input;
        $this->sessionId = $sessionId;
        $this->msisdn = $msisdn;
        $this->sessionVariables = array();
        $this->sessionHistory = new LinkedList();

        if($isNewRequest == "1") {
            $this->isNewRequest = TRUE;
        } else {
            $this->isNewRequest = FALSE;
        }
    }


    //set methods
    public function setIsSessionContinuing($isSessionContinuing): void
    {
        $this->isSessionContinuing = $isSessionContinuing;
    }

    public function setResponseBody($responseBody): void
    {
        $this->responseBody = $responseBody;
    }

    public function setSessionVariables(array $sessionVariables): void
    {
        $this->sessionVariables = $sessionVariables;
    }

    public function setSessionVariable($key, $value)
    {
        $this->sessionVariables[$key] = $value;
    }

    public function setSessionHistory(LinkedList $sessionHistory): void
    {
        $this->sessionHistory = $sessionHistory;
    }



    //get methods
    public function getInput()
    {
        return $this->input;
    }

    public function getMsisdn()
    {
        return $this->msisdn;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function getIsNewRequest()
    {
        return $this->isNewRequest;
    }

    public function getIsSessionContinuing()
    {
        return $this->isSessionContinuing;
    }

    public function getSessionVariables(): array
    {
        return $this->sessionVariables;
    }

    public function getSessionVariable($key)
    {
        return $this->sessionVariables[$key];
    }

    public function getSessionHistory(): LinkedList
    {
        return $this->sessionHistory;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
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
