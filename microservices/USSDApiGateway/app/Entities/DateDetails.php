<?php


namespace App\Entities;


use Carbon\Carbon;

class DateDetails
{
    private $date;
    private $firstQuarterDate;
    private $lastQuarterDate;
    private $dateQuarter;
    private $dateYear;
    private $dateMonth;
    private $dateDay;

    /**
     * DateDetails constructor.
     * @param $date
     */
    public function __construct($date)
    {
        $this->date = $date;
        $this->dateYear = $date->year;
        $this->dateMonth = $date->month;
        $this->dateDay = $date->day;
        $this->dateQuarter = $date->quarter;

        if($this->dateQuarter == 1) {
            $this->firstQuarterDate = "{$this->dateYear}-01-01";
            $this->lastQuarterDate = "{$this->dateYear}-03-31";
        } else if($this->dateQuarter == 2) {
            $this->firstQuarterDate = "{$this->dateYear}-04-01";
            $this->lastQuarterDate = "{$this->dateYear}-06-30";
        } else if($this->dateQuarter == 3) {
            $this->firstQuarterDate = "{$this->dateYear}-07-01";
            $this->lastQuarterDate = "{$this->dateYear}-09-30";
        } else if($this->dateQuarter == 4) {
            $this->firstQuarterDate = "{$this->dateYear}-10-01";
            $this->lastQuarterDate = "{$this->dateYear}-12-31";
        }
    }

    //get methods
    public function getDate()
    {
        return $this->date;
    }

    public function getFirstQuarterDate(): string
    {
        return $this->firstQuarterDate;
    }

    public function getLastQuarterDate(): string
    {
        return $this->lastQuarterDate;
    }

    public function getDateQuarter()
    {
        return $this->dateQuarter;
    }

    public function getDateYear()
    {
        return $this->dateYear;
    }

    public function getDateMonth()
    {
        return $this->dateMonth;
    }

    public function getDateDay()
    {
        return $this->dateDay;
    }
}
