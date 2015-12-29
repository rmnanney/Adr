<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/5/15
 * Time: 1:56 PM
 */

namespace Adr;

class State
{

    private $abbrev;
    private $full;

    public function __construct(\DOMElement $xmlNode = null)
    {
        if (null != $xmlNode) {
            foreach ($xmlNode->childNodes as $element) {
                if (!$element instanceof \DOMText) {
                    $this->{strtolower($element->nodeName)} = $element->nodeValue;
                }
            }
        }
    }

    public function getXML(\DOMDocument $doc)
    {
        return self::generateXML($doc);
    }

    private function generateXML(\DOMDocument $doc)
    {
        $state = $doc->createElement('State');
        $state->appendChild($doc->createElement('Abbrev', $this->abbrev));
        $state->appendChild($doc->createElement('Full', $this->full));
        return $state;
    }

    /**
     * @return mixed
     */
    public function getAbbrev()
    {
        return $this->abbrev;
    }

    /**
     * @param mixed $abbrev
     */
    public function setAbbrev($abbrev)
    {
        $this->abbrev = $abbrev;
    }

    /**
     * @return mixed
     */
    public function getFull()
    {
        return $this->full;
    }

    /**
     * @param mixed $full
     */
    public function setFull($full)
    {
        $this->full = $full;
    }
}
