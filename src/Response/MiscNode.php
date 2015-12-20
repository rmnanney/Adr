<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 4:24 PM
 */

namespace Adr\Response;

class MiscNode
{

    private $miscellaneous;

    public function __construct($xmlNode)
    {
        $this->miscellaneous = array();
        foreach ($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                $this->{strtolower($element->nodeName)}[] = $element->nodeValue;
            }
        }
    }

    /**
     * @return array
     */
    public function getMiscellaneous()
    {
        return $this->miscellaneous;
    }
}
