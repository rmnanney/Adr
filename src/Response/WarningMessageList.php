<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/5/15
 * Time: 2:19 PM
 */

namespace Adr\Response;

class WarningMessageList
{

    private $warningmessageitem;

    public function __construct(\DOMElement $xmlNode)
    {
        $this->warningmessageitem = array();
        foreach ($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                $this->{strtolower($element->nodeName)}[] = new WarningMessageItem($element);
            }
        }
    }
}
