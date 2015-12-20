<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 3:28 PM
 */

namespace Adr\Response;

use Adr\Date;
use Adr\Date\Dob;
use Adr\State;
use Adr\Time;

class OrderNode
{
    private $controlnumber;
    private $date;
    private $time;
    private $dob;
    private $type;
    private $handling;
    private $misc;
    private $state;
    private $license;
    private $firstname;
    private $lastname;
    private $account;
    private $inputmethod;
    private $outputmethod;
    private $purpose;
    private $subtype;
    private $productid;
    private $tracking;
    private $identifer;  //This is an ADR TYPE-O in the XML :-(
    private $auxmisc;

    public function __construct(\DOMElement $xmlNode)
    {
        foreach ($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                switch (strtoupper($element->nodeName)) {
                    case 'DATE':
                        $this->{strtolower($element->nodeName)} = new Date($element);
                        break;
                    case 'TIME':
                        $this->{strtolower($element->nodeName)} = new Time($element);
                        break;
                    case 'DOB':
                        $this->{strtolower($element->nodeName)} = new Dob($element);
                        break;
                    case 'STATE':
                        $this->{strtolower($element->nodeName)} = new State($element);
                        break;
                    default:
                        $this->{strtolower($element->nodeName)} = $element->nodeValue;
                        break;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getControlnumber()
    {
        return $this->controlnumber;
    }

    /**
     * @param mixed $controlnumber
     */
    public function setControlnumber($controlnumber)
    {
        $this->controlnumber = $controlnumber;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param mixed $dob
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getHandling()
    {
        return $this->handling;
    }

    /**
     * @param mixed $handling
     */
    public function setHandling($handling)
    {
        $this->handling = $handling;
    }

    /**
     * @return mixed
     */
    public function getMisc()
    {
        return $this->misc;
    }

    /**
     * @param mixed $misc
     */
    public function setMisc($misc)
    {
        $this->misc = $misc;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @param mixed $license
     */
    public function setLicense($license)
    {
        $this->license = $license;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getInputmethod()
    {
        return $this->inputmethod;
    }

    /**
     * @param mixed $inputmethod
     */
    public function setInputmethod($inputmethod)
    {
        $this->inputmethod = $inputmethod;
    }

    /**
     * @return mixed
     */
    public function getOutputmethod()
    {
        return $this->outputmethod;
    }

    /**
     * @param mixed $outputmethod
     */
    public function setOutputmethod($outputmethod)
    {
        $this->outputmethod = $outputmethod;
    }

    /**
     * @return mixed
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * @param mixed $purpose
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;
    }

    /**
     * @return mixed
     */
    public function getSubtype()
    {
        return $this->subtype;
    }

    /**
     * @param mixed $subtype
     */
    public function setSubtype($subtype)
    {
        $this->subtype = $subtype;
    }

    /**
     * @return mixed
     */
    public function getProductid()
    {
        return $this->productid;
    }

    /**
     * @param mixed $productid
     */
    public function setProductid($productid)
    {
        $this->productid = $productid;
    }

    /**
     * @return mixed
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * @param mixed $tracking
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;
    }

    /**
     * @return mixed
     */
    public function getIdentifer()
    {
        return $this->identifer;
    }

    /**
     * @param mixed $identifer
     */
    public function setIdentifer($identifer)
    {
        $this->identifer = $identifer;
    }

    /**
     * @return mixed
     */
    public function getAuxmisc()
    {
        return $this->auxmisc;
    }

    /**
     * @param mixed $auxmisc
     */
    public function setAuxmisc($auxmisc)
    {
        $this->auxmisc = $auxmisc;
    }
}
