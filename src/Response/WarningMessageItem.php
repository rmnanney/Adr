<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/5/15
 * Time: 2:23 PM
 */

namespace Adr\Response;

class WarningMessageItem {

    private $line;

    public function __construct(\DOMElement $xmlNode){
        $this->line = array();
        foreach($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                $this->{strtolower($element->nodeName)}[] = $element->nodeValue;
            }
        }
    }
}