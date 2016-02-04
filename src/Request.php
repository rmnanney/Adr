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
    private $Password;              //EG: asdf.1234
    private $NewPassword;           //EG: 4321.fdsa
    private $ReportType;            //EG: XML
    private $AdditionalReportType;            //EG: HTML
    private $xmlStr;
    private $ADRIPAddress;
    private $ADRPort;
    private $order;

    /**
     * @param Request\Order $order
     */
    public function addOrder(Request\Order $order)
    {
        $this->order = $order;
    }


    /**
     * @return Response
     * @throws \Exception
     */
    public function send()
    {
        $this->xmlStr = self::generateXML();

        $ch = curl_init(); //initiate the curl session
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, 'https://' . $this->ADRIPAddress . ":" . $this->ADRPort); //set to url to post to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // tell curl to return data in a variable;
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'OrderXml=' . $this->xmlStr); // post the xml
        $xmlResponse = curl_exec($ch);
        if(!$xmlResponse){
            throw new \Exception( 'Unable to connect to ADR: ' . curl_error($ch) );
        }

        curl_close ($ch);
        $response = new Response();
        $response->loadXML($xmlResponse);
        $response->parse();

        //Let's check for any errors
        if($response->getError() != '0'){
            throw new \Exception('ADR ERROR: ' . $response->getError() . ' ' . $response->getErrorDescription() . PHP_EOL);
        }
        return $response;
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
        $comm->appendChild($doc->createElement('Password', $this->Password));
        if(!empty($this->NewPassword)){
            $comm->appendChild($doc->createElement('NewPassword', $this->NewPassword));
        }
        $comm->appendChild($doc->createElement('ReportType', $this->ReportType));
        if(!empty($this->AdditionalReportType)){
            $comm->appendChild($doc->createElement('AdditionalReportType', $this->AdditionalReportType));
        }
        $adr->appendChild($comm);

        //we may want to support multiple orders soon.
        $adr->appendChild($this->order->getXML($doc));
        $doc->appendChild($adr);
        return $doc->saveXML();
    }

    /**
     * @param string $params
     * @return bool
     */
    public function save($params)
    {
        //some kind of file handler(s) to persist to the filesystem, and/or maybe a DB.
        return true;
    }

    /**
     * @return string
     */
    public function resetPassword(){
        $this->NewPassword = $this->generatePassword();
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
     * @param mixed $ADRIPAddress
     */
    public function setADRIPAddress($ADRIPAddress)
    {
        $this->ADRIPAddress = $ADRIPAddress;
    }

    /**
     * @param mixed $ADRPort
     */
    public function setADRPort($ADRPort)
    {
        $this->ADRPort = $ADRPort;
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
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;
    }

    /**
     * @param mixed $NewPassword
     */
    public function setNewPassword($NewPassword)
    {
        $this->NewPassword = $NewPassword;
    }

    /**
     * @param mixed $ReportType
     */
    public function setReportType($ReportType)
    {
        $this->ReportType = $ReportType;
    }

    /**
     * @param mixed $AdditionalReportType Ensure you use \Adr\Request\AdditionalReportType to lookup the type.
     */
    public function setAdditionalReportType($AdditionalReportType)
    {
        $this->AdditionalReportType = $AdditionalReportType;
    }



    /**
     * @param Request\Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getNewPassword()
    {
            return $this->NewPassword;
    }

    /**
     * @return bool
     */
    public function hasNewPassword()
    {
        if(!empty($this->NewPassword))
        {
            return true;
        }
        return false;
    }

}

