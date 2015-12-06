<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 4:24 PM
 */

namespace Adr\Response;

require_once __DIR__ . '/Violation.php';
require_once __DIR__ . '/Action.php';

use Adr\Action;

class HistoryNode {

    private $viol;
    private $action;

    public function __construct($xmlNode){
        $this->action = array();
        $this->viol = array();
        foreach($xmlNode->childNodes as $element){
            if(!$element instanceof \DOMText) {
                switch (strtoupper($element->nodeName)) {
                    case 'VIOL':
                        $this->{strtolower($element->nodeName)}[] = new Violation($element);
                        break;
                    case 'ACTION':
                        $this->{strtolower($element->nodeName)}[] = new Action($element);
                        break;
                    default:
                        $this->{strtolower($element->nodeName)} = $element->nodeValue;
                        break;
                }
            }
        }
    }
}