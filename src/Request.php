<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 2:45 PM
 */

namespace Adr;


class Request extends \DOMDocument {

    private $Host;                  //EG: Online
    private $Account;               //EG: S1234
    private $UserID;                //EG: 03
    private $Password;              //EG: 22225d7bs6e4bfdf71d5d5a1e912345
    private $PasswordFormat;        //EG: encrypted
    private $NewPassword;           //EG:  22225d7bs6e4bfdf71d5d5a1e912345
    private $NewPasswordFormat;     //EG:  encrypted
    private $DeviceID;              //EG:  0C341E440634184 ... 644D593490332B405123456
    private $DeviceIDFormat;        //EG:  encrypted
    private $ReportType;            //EG: XML
    private $xmlStr;

    private $order;

    public function addOrder(Request\Order $order) {
        $this->order = $order;
    }

    /**
     * @return Response
     */
    public function send($curlObjecctOrSomething){
        $this->xmlStr = self::generateXML();

        //Do transfer, throw errors or return response

        return new Response();
    }

    /**
     * @return string
     */
    public function getXML(){
        $this->formatOutput = true;
        return self::generateXML();
    }

    private function generateXML(){
        $doc = new \DOMDocument('1.0');
        $doc->formatOutput = true;
        $adr = $doc->createElement('ADR');
        $comm = $doc->createElement('Communications');
        $comm->appendChild($doc->createElement('Host', $this->Host));
        $comm->appendChild($doc->createElement('Account', $this->Account));
        $comm->appendChild($doc->createElement('UserID', $this->UserID));
        $comm->appendChild($doc->createElement('Password', $this->Password));
        $comm->appendChild($doc->createElement('NewPassword', $this->NewPassword));
        $comm->appendChild($doc->createElement('DeviceID', $this->DeviceID));
        $comm->appendChild($doc->createElement('ReportType', $this->ReportType));
        $adr->appendChild($comm);

        //we may want to support multiple orders soon.
        $adr->appendChild($this->order->getXML($doc));
        $doc->appendChild($adr);
        return $doc->saveXML();
    }

    public function save($params){
        //some kind of file handler(s) to persist to the filesystem, and/or maybe a DB.
    }

    /**
     * @param mixed $Host
     */
    public function setHost($Host) {
        $this->Host = $Host;
    }

    /**
     * @param mixed $Account
     */
    public function setAccount($Account) {
        $this->Account = $Account;
    }

    /**
     * @param mixed $UserID
     */
    public function setUserID($UserID) {
        $this->UserID = $UserID;
    }

    /**
     * @param mixed $Password
     * @param mixed $format
     */
    public function setPassword($Password, $format) {
        $this->Password = $Password;
        $this->PasswordFormat = $format;
    }

    /**
     * @param mixed $NewPassword
     * @param mixed $format
     */
    public function setNewPassword($NewPassword, $format) {
        $this->NewPassword = $NewPassword;
        $this->NewPasswordFormat = $format;
    }

    /**
     * @param mixed $DeviceID
     * @param mixed $format
     */
    public function setDeviceID($DeviceID, $format) {
        $this->DeviceID = $DeviceID;
        $this->DeviceIDFormat = $format;
    }

    /**
     * @param mixed $ReportType
     */
    public function setReportType($ReportType) {
        $this->ReportType = $ReportType;
    }

    /**
     * @param Request\Order $order
     */
    public function setOrder($order) {
        $this->order = $order;
    }

}