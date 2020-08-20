<?php


namespace App\Entities;


use Iterator;
use JsonSerializable;

class LinkedList implements Iterator, JsonSerializable
{
    private $firstNode = null;
    private $current = null;
    private $position = 0;
    private $count = 0;

    /**
     * LinkedList constructor.
     */
    public function __construct(){}


    /**
     * Insert node at the beginning of the list.
     * @param null $data
     * @return bool
     */
    public function insertFirst($data = null) {
        $newNode = new Node($data);

        //check if first node is not null
        if ($this->firstNode != null ) {
            //set next node of new node as the existing first node
            $newNode->setNext($this->firstNode);
        }

        //set new node as first node
        $this->firstNode = $newNode;

        //increment count by one
        $this->count++;

        //return true
        return true;
    }

    /**
     * Insert node at the end of the list.
     * @param null $data
     * @return bool
     */
    public function insertLast($data = null) {

        //check if first node is null
        if ($this->firstNode == null ) {
            //if first node is null call insert first method to add first node
            $this->insertFirst($data);

        } else { //if first node is not equals to null

            //create new node
            $newNode = new Node($data);

            //set current node as first node
            $current = $this->firstNode;

            while($current->getNext() !== null ) {
                $current = $current->getNext();
            } //while loop is existed if current node next value is null
              //signifying that current node is the last node

            //set current node next value as new node
            $current->setNext($newNode);

            //increment count value by one
            $this->count++;
        }

        return true;
    }

    /**
     * Delete the first node in the list.
     */
    public function deleteFirst() {

        //check if first node is not equal to null
        if ($this->firstNode != null) {

            //check if the next attribute of the first node is not equal to null
            if($this->firstNode->next != null) {

                //set first node as next node value of current first node
                $this->firstNode = $this->firstNode->next;
            } else {

                //set first node to null
                $this->firstNode = null;
            }

            //reduce count value by one
            $this->count--;

            return true;
        }

        return false;
    }

    /**
     * Delete the last node in the list.
     */
    public function deleteLast() {

        //check if first node is not equal to null
        if ($this->firstNode != null) {

            //check if the next node of the first node is null
            if ($this->firstNode->next == null) {

                //set first node to null
                $this->firstNode = null;
            } else {
                $previous = null;
                $current = $this->firstNode;

                while($current->next != null) {
                    $previous = $current;
                    $current = $current->next;
                }

                $previous->next = null;

                $this->count--;
            }

            return true;
        }

        return false;
    }

    /**
     * Delete all matching nodes.
     */
    public function deleteAll($query = NULL) {
        if ( $this->firstNode !== NULL ) {
            $previous = NULL;
            $current = $this->firstNode;

            while ( $current->next !== NULL ) {
                if ( $current->data === $query ) {
                    if ( $previous === NULL ) {
                        $this->firstNode = $current->next;
                        $current = $this->firstNode;
                        continue;
                    } else {
                        $previous->next = $current->next;
                    }

                    $this->count--;
                }

                $previous = $current;
                $current = $current->next;
            }
        }

        return FALSE;
    }

    /**
     * Reverse the list.
     */
    public function reverse() {
        if ( $this->firstNode !== NULL ) {
            if ( $this->firstNode->next !== NULL ) {
                $reversed = $temp = NULL;
                $current = $this->firstNode;

                while ( $current !== NULL ) {
                    $temp = $current->next;

                    $current->next = $reversed;
                    $reversed = $current;

                    $current = $temp;
                }

                $this->firstNode = $reversed;
            }
        }
    }

    /**
     * Sort the list in ascending order.
     */
    public function sort() {
        if ( $this->firstNode !== NULL ) {
            if ( $this->firstNode->next !== NULL ) {
                for ( $i = 0; $i < $this->count; $i++ ) {
                    $temp = NULL;
                    $current = $this->firstNode;

                    while ( $current !== NULL ) {
                        if ( $current->next !== NULL && $current->data > $current->next->data ) {
                            $temp = $current->data;
                            $current->data = $current->next->data;
                            $current->next->data = $temp;
                        }

                        $current = $current->next;
                    }
                }
            }
        }
    }

    /**
     * Get the nth element in the list.
     * @param int $n
     * @return bool|null
     */
    public function getNthElement($n = 0) {
        if ( $this->firstNode != null && $n <= $this->count ) {
            $current = $this->firstNode;

            for ($i = 1; $i < $n; $i++ ) {
                $current = $current->getNext();
            }

            return $current;
        }

        return null;
    }

    /**
     * Get the nth element from the end in the list.
     * @param int $n
     * @return bool|null
     */
    public function getNthElementFromLast($n = 0) {
        if ($this->firstNode != null && $n <= $this->count) {
            $current = $this->firstNode;

            for ($i = 0; $i < $this->count - $n - 1; $i++) {
                $current = $current->getnext();
            }

            return $current;
        }

        return false;
    }

    /**
     * Get size of the list
     */
    public function size() {
        return $this->count;
    }

    /*
     * Iterator Implementation
     */
    public function rewind() {
        $this->position = 0;
        $this->current = $this->firstNode;
    }

    public function current() {
        return $this->current->data;
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        $this->position++;
        $this->current = $this->current->next;
    }

    public function valid() {
        return $this->current !== NULL;
    }

    //set methods
    public function setFirstNode($firstNode): void
    {
        $this->firstNode = $firstNode;
    }

    public function setCurrent($current): void
    {
        $this->current = $current;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }


    //get methods
    public function getFirstNode()
    {
        return $this->firstNode;
    }

    public function getCurrent()
    {
        return $this->current;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getCount(): int
    {
        return $this->count;
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
