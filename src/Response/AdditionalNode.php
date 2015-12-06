<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 4:24 PM
 */

namespace Adr\Response;

require_once __DIR__ . '/../Message.php';

use Adr\Message;

class AdditionalNode {

    private $message;

    public function __construct($xmlNode){
        $this->message = array();
        foreach($xmlNode->childNodes as $element){
            if(!$element instanceof \DOMText) {
                switch (strtoupper($element->nodeName)) {
                    case 'MESSAGE':
                        $this->{strtolower($element->nodeName)}[] = new Message($element);
                        break;
                    default:
                        $this->{strtolower($element->nodeName)} = $element->nodeValue;
                        break;
                }
            }
        }
    }
}