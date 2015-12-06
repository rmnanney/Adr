<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/6/15
 * Time: 10:07 AM
 */

namespace Adr;


class Incident {

    private $descsmall;
    private $statecode;
    private $desclarge;
    private $adrpoints;
    private $acdcode;
    private $avdcode;
    private $avd2;
    private $statepoints;
    private $key;

    public function __construct(\DOMElement $xmlNode){
        foreach($xmlNode->childNodes as $element){
            if(!$element instanceof \DOMText) {
                $this->{strtolower($element->nodeName)} = $element->nodeValue;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getDescsmall()
    {
        return $this->descsmall;
    }

    /**
     * @return mixed
     */
    public function getStatecode()
    {
        return $this->statecode;
    }

    /**
     * @return mixed
     */
    public function getDesclarge()
    {
        return $this->desclarge;
    }

    /**
     * @return mixed
     */
    public function getAdrpoints()
    {
        return $this->adrpoints;
    }

    /**
     * @return mixed
     */
    public function getAcdcode()
    {
        return $this->acdcode;
    }

    /**
     * @return mixed
     */
    public function getAvdcode()
    {
        return $this->avdcode;
    }

    /**
     * @return mixed
     */
    public function getAvd2()
    {
        return $this->avd2;
    }

    /**
     * @return mixed
     */
    public function getStatepoints()
    {
        return $this->statepoints;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }



}