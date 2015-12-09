<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 4:24 PM
 */

namespace Adr\Response;


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

    public function hasViolations(){
        return (count($this->viol))?true:false;
    }

    public function hasActions(){
        return (count($this->action))?true:false;
    }

    /**
     * @return array
     */
    public function getViolations()
    {
        return $this->viol;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->action;
    }


}