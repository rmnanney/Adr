<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/5/15
 * Time: 2:52 PM
 */

namespace Adr\Response\License;

class Status
{

    private $status;

    public function __construct(\DOMElement $xmlNode)
    {
        foreach ($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                $this->{strtolower($element->nodeName)} = $element->nodeValue;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
