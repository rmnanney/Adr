<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/5/15
 * Time: 1:55 PM
 */

namespace Adr;

class Date
{

    protected $year;
    protected $month;
    protected $day;
    private $epoch;
    protected $dateType;

    public function __construct(\DOMElement $xmlNode = null)
    {
        if (null != $xmlNode) {
            foreach ($xmlNode->childNodes as $element) {
                if (!$element instanceof \DOMText) {
                    $this->{strtolower($element->nodeName)} = $element->nodeValue;
                }
            }
            $this->epoch = strtotime($this->year . '-' . $this->month . '-' . $this->day);
        }
    }

    public function getDateType()
    {
        return $this->dateType;
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
