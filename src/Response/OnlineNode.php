<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/6/16
 * Time: 1:43 PM
 */

namespace Adr\Response;


/**
 * Class OnlineNode
 * @package Adr\Response
 */
class OnlineNode
{

    private $error;
    private $errordescription;
    private $result;
    private $resultdescription;
    private $message;
    private $daysleft;
    private $showwarning;


    /**
     * OnlineNode constructor.
     * @param \DOMElement $xmlNode
     */
    public function __construct(\DOMElement $xmlNode)
    {
        foreach ($xmlNode->childNodes as $element) {
            $this->{strtolower($element->nodeName)} = $element->nodeValue;
        }
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getErrorDescription()
    {
        return $this->errordescription;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return mixed
     */
    public function getResultDescription()
    {
        return $this->resultdescription;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getDaysLeft()
    {
        return $this->daysleft;
    }

    /**
     * @return mixed
     */
    public function getShowWarning()
    {
        return $this->showwarning;
    }

}
