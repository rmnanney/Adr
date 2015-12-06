<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/5/15
 * Time: 1:55 PM
 */

namespace Adr;


class Date {

    private $year;
    private $month;
    private $day;
    private $epoch;
    protected $dateType;

    const DATE_TYPE_DATE = 1;
    const DATE_TYPE_DOB = 2;
    const DATE_TYPE_EXPIRE = 3;
    const DATE_TYPE_ISSUE = 4;
    const DATE_TYPE_INCIDENT = 5;
    const DATE_TYPE_CONVICTION = 6;
    const DATE_TYPE_CLEAR = 7;
    const DATE_TYPE_ACTIONEND = 8;
    const DATE_TYPE_MAIL = 9;

    public function __construct(\DOMElement $xmlNode){
        $this->dateType = self::DATE_TYPE_DATE;
        foreach($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                $this->{strtolower($element->nodeName)} = $element->nodeValue;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
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
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return mixed
     */
    public function getEpoch()
    {
        return $this->epoch;
    }

    /**
     * @param mixed $epoch
     */
    public function setEpoch($epoch)
    {
        $this->epoch = $epoch;
    }


}