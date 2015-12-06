<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/5/15
 * Time: 3:05 PM
 */

namespace Adr;


class Message {

    private $line;

    public function __construct($xmlNode){
        $this->line = array();
        foreach($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                $this->{strtolower($element->nodeName)}[] = $element->nodeValue;
            }
        }
    }
}