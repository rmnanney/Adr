<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 4:23 PM
 */

namespace Adr\Response;

use Adr\Name;

class DriverNode{

    private $license;
    private $name;

    public function __construct(\DOMElement $xmlNode){
        foreach($xmlNode->childNodes as $element){
            if(!$element instanceof \DOMText) {
                switch (strtoupper($element->nodeName)) {
                    case 'NAME':
                        $this->{strtolower($element->nodeName)} = new Name($element);
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
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    

}