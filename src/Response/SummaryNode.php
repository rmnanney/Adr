<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/6/16
 * Time: 1:40 PM
 */

namespace Adr\Response;


class SummaryNode
{

    private $onlineNode;
    private $ordersNode;
    private $reportsNode;

    public function __construct(\DOMElement $xmlNode)
    {
        foreach ($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                switch (strtoupper($element->nodeName)) {
                    case 'ONLINE':
                        $this->onlineNode = new OnlineNode($element);
                        break;
//                    case 'ORDERS':
//                        $this->{strtolower($element->nodeName)} = new Orders($element);
//                        break;
//                    case 'REPORTS':
//                        $this->{strtolower($element->nodeName)} = new Reorts($element);
//                        break;
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
    public function getError()
    {
        return $this->onlineNode->getError();
    }

    /**
     * @return mixed
     */
    public function getErrorDescription()
    {
        return $this->onlineNode->getErrorDescription();
    }

    /**
     * @return mixed
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @return mixed
     */
    public function getReports()
    {
        return $this->reports;
    }

}
