<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 2:45 PM
 */

namespace Adr;

class Request extends \DOMDocument
{

    private $Host;                  //EG: Online
    private $Account;               //EG: S1234
    private $UserID;                //EG: 03
    private $Password;              //EG: 22225d7bs6e4bfdf71d5d5a1e912345
    private $PasswordFormat;        //EG: encrypted
    private $NewPassword;           //EG: 22225d7bs6e4bfdf71d5d5a1e912345
    private $NewPasswordFormat;     //EG: encrypted
    private $NewPasswordEncoded;    //EG: 5def5d7bs6e4bfdf71d5d5a1e9971fa4
    private $DeviceID;              //EG: FF02A84F9B1D4314MVDEC5F98200FD57B0HLMEIDDHDCGN
    private $DeviceIDFormat;        //EG: encoded
    private $ReportType;            //EG: XML
    private $xmlStr;

    private $order;

    /**
     * @param Request\Order $order
     */
    public function addOrder(Request\Order $order)
    {
        $this->order = $order;
    }


    /**
     * @param $curlObjecctOrSomething
     * @return Response
     */
    public function send($curlObjecctOrSomething)
    {
        $this->xmlStr = self::generateXML();

        //Do transfer, throw errors or return response

        return new Response();
    }

    /**
     * @return string
     */
    public function getXML()
    {
        $this->formatOutput = true;
        return self::generateXML();
    }

    /**
     * @return string
     */
    private function generateXML()
    {
        $doc = new \DOMDocument('1.0');
        $doc->formatOutput = true;
        $adr = $doc->createElement('ADR');
        $comm = $doc->createElement('Communications');
        $comm->appendChild($doc->createElement('Host', $this->Host));
        $comm->appendChild($doc->createElement('Account', $this->Account));
        $comm->appendChild($doc->createElement('UserID', $this->UserID));
        $comm->appendChild($doc->createElement('Password', $this->Password)->setAttribute('format', $this->PasswordFormat));
        if(!empty($this->NewPassword)){
            $comm->appendChild($doc->createElement('NewPassword', $this->NewPassword)->setAttribute('format', $this->NewPasswordFormat));
        }
        $comm->appendChild($doc->createElement('DeviceID', $this->DeviceID)->setAttribute('format', $this->DeviceIDFormat));
        $comm->appendChild($doc->createElement('ReportType', $this->ReportType));
        $adr->appendChild($comm);

        //we may want to support multiple orders soon.
        $adr->appendChild($this->order->getXML($doc));
        $doc->appendChild($adr);
        return $doc->saveXML();
    }

    /**
     * @param string $params
     */
    public function save($params)
    {
        //some kind of file handler(s) to persist to the filesystem, and/or maybe a DB.
    }

    public function resetPassword(){
        $this->NewPassword = $this->generatePassword();
        $output = array();
        exec("java -cp " . $this->adrJarFile . " adr.client.util.adrclienttool ".$this->NewPassword, $output);
        $this->NewPasswordEncoded = trim(substr($output[0], 1+strpos($output[0], ":")));
    }

    private function generatePassword() {
        /*
        Upper case and Lowercase letters
        One number and one symbol
        8-10 characters
        No more than two consecutive
        identical characters
        */
        $password = array();
        $upperCase = explode(',' , "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z");
        $lowerCase = explode(',' , "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z");
        $numbers = explode(',' , "0,1,2,3,4,5,6,7,8,9");
        $special = explode(',' , "!,@,#,%,^,*");

        shuffle($upperCase);
        shuffle($lowerCase);
        shuffle($numbers);
        shuffle($special);

        for ($i = 0; $i <= 3; $i++) $password[] = array_pop($upperCase);
        for ($i = 0; $i <= 3; $i++) $password[] = array_pop($lowerCase);
        $password[] = array_pop($numbers);
        $password[] = array_pop($special);

        shuffle($password);
        $password = implode('', $password);

        //profit :)
        return $password;
    }

    /**
     * @param mixed $Host
     */
    public function setHost($Host)
    {
        $this->Host = $Host;
    }

    /**
     * @param mixed $Account
     */
    public function setAccount($Account)
    {
        $this->Account = $Account;
    }

    /**
     * @param mixed $UserID
     */
    public function setUserID($UserID)
    {
        $this->UserID = $UserID;
    }

    /**
     * @param mixed $Password
     * @param mixed $format
     */
    public function setPassword($Password, $format)
    {
        $this->Password = $Password;
        $this->PasswordFormat = $format;
    }

    /**
     * @param mixed $NewPassword
     * @param mixed $format
     */
    public function setNewPassword($NewPassword, $format)
    {
        $this->NewPassword = $NewPassword;
        $this->NewPasswordFormat = $format;
    }

    /**
     * @param mixed $DeviceID
     * @param mixed $format
     */
    public function setDeviceID($DeviceID, $format)
    {
        $this->DeviceID = $DeviceID;
        $this->DeviceIDFormat = $format;
    }

    /**
     * @param mixed $ReportType
     */
    public function setReportType($ReportType)
    {
        $this->ReportType = $ReportType;
    }

    /**
     * @param Request\Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }
}
