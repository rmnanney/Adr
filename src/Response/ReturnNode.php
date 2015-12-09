<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 3:29 PM
 */

namespace Adr\Response;

use Adr\Date;
use Adr\Time;
use Adr\WarningMessageList;

class ReturnNode {

    private $valid;
    private $date;
    private $time;
    private $clear;
    private $originaltype;
    private $warningmessagelist;


    public function __construct(\DOMElement $xmlNode){
        foreach($xmlNode->childNodes as $element){
            if(!$element instanceof \DOMText) {
                switch (strtoupper($element->nodeName)) {
                    case 'DATE':
                        $this->{strtolower($element->nodeName)} = new Date($element);
                        break;
                    case 'TIME':
                        $this->{strtolower($element->nodeName)} = new Time($element);
                        break;
                    case 'WARNINGMESSAGELIST':
                        $this->{strtolower($element->nodeName)} = new WarningMessageList($element);
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
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return mixed
     */
    public function getClear()
    {
        return $this->clear;
    }

    /**
     * @return mixed
     */
    public function getOriginaltype()
    {
        return $this->originaltype;
    }

    /**
     * @return mixed
     */
    public function getWarningmessagelist()
    {
        return $this->warningmessagelist;
    }



}