<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/9/15
 * Time: 1:58 PM
 */

namespace Adr\Request;

use Adr\Date\Dob;

class Order
{

    private $Account;       //EG: S1234
    private $Handling;      //EG: OL
    private $ProductID;     //EG: DL
    private $Subtype;       //EG: 3Y
    private $Purpose;       //EG: AA
    private $Misc;          //EG: 368616
    private $AuxMisc;       //EG: 61162
    private $FirstName;     //EG: TestFname
    private $LastName;      //EG: TestLname
    private $License;       //EG: N50073371234-06
    private $DOB;           //This is an Adr\Date\Dob object.
    private $State;         //The Two-Digit State code, EG: WI
    private $SSN;           //Social Security Numbers.
    private $xmlStr;

    public function __construct()
    {
        $this->DOB = new Dob();
    }

    public function getXML(\DOMDocument $doc)
    {
        return self::generateXML($doc);
    }

    private function generateXML(\DOMDocument $doc)
    {
        $order = $doc->createElement('Order');
        $order->appendChild($doc->createElement('Account', $this->Account));
        $order->appendChild($doc->createElement('Handling', $this->Handling));
        $order->appendChild($doc->createElement('ProductID', $this->ProductID));
        $order->appendChild($doc->createElement('Subtype', $this->Subtype));
        $order->appendChild($doc->createElement('Purpose', $this->Purpose));
        $order->appendChild($doc->createElement('Misc', $this->Misc));
        $order->appendChild($doc->createElement('AuxMisc', $this->AuxMisc));
        $order->appendChild($doc->createElement('FirstName', $this->FirstName));
        $order->appendChild($doc->createElement('LastName', $this->LastName));
        $order->appendChild($doc->createElement('License', $this->License));
        $order->appendChild($doc->createElement('SSN', $this->SSN));
        $order->appendChild($this->DOB->getXML($doc));
        return $order;
    }

    /**
     * @param mixed $Account
     */
    public function setAccount($Account)
    {
        $this->Account = $Account;
    }

    /**
     * @param mixed $Handling
     */
    public function setHandling($Handling)
    {
        $this->Handling = $Handling;
    }

    /**
     * @param mixed $ProductID
     */
    public function setProductID($ProductID)
    {
        $this->ProductID = $ProductID;
    }

    /**
     * @param mixed $Subtype
     */
    public function setSubtype($Subtype)
    {
        $this->Subtype = $Subtype;
    }

    /**
     * @param mixed $Purpose
     */
    public function setPurpose($Purpose)
    {
        $this->Purpose = $Purpose;
    }

    /**
     * @param mixed $Misc
     */
    public function setMisc($Misc)
    {
        $this->Misc = $Misc;
    }

    /**
     * @param mixed $AuxMisc
     */
    public function setAuxMisc($AuxMisc)
    {
        $this->AuxMisc = $AuxMisc;
    }

    /**
     * @param mixed $FirstName
     */
    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
    }

    /**
     * @param mixed $LastName
     */
    public function setLastName($LastName)
    {
        $this->LastName = $LastName;
    }

    /**
     * @param mixed $License
     */
    public function setLicense($License)
    {
        $this->License = $License;
    }

    /**
     * @param \Adr\Date\Dob $DOB
     */
    public function setDOB(Dob $DOB)
    {
        $this->DOB = $DOB;
    }

    /**
     * @param string $state The Two-Digit state code.
     */
    public function setState($state)
    {
        $this->State = $state;
    }

    public function setSSN($ssn)
    {
        $this->SSN = $ssn;
    }
}
