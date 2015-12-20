<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/6/15
 * Time: 10:24 AM
 */

namespace Adr\Response;

use Adr\Response\Date\IncidentDate;
use Adr\Response\Date\MailDate;
use Adr\Response\Date\ClearDate;
use Adr\Response\Date\ActionEndDate;
use Adr\State;

class Action
{

    private $type;
    private $mnemonic;
    private $incidentdate;
    private $maildate;
    private $incident;
    private $docket;
    private $cleardate;
    private $actionenddate;
    private $suspflag;

    public function __construct(\DOMElement $xmlNode)
    {
        foreach ($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                switch (strtoupper($element->nodeName)) {
                    case 'INCIDENTDATE':
                        $this->{strtolower($element->nodeName)} = new IncidentDate($element);
                        break;
                    case 'MAILDATE':
                        $this->{strtolower($element->nodeName)} = new MailDate($element);
                        break;
                    case 'STATE':
                        $this->{strtolower($element->nodeName)} = new State($element);
                        break;
                    case 'INCIDENT':
                        $this->{strtolower($element->nodeName)} = new Incident($element);
                        break;
                    case 'CLEARDATE':
                        $this->{strtolower($element->nodeName)} = new ClearDate($element);
                        break;
                    case 'ACTIONENDDATE':
                        $this->{strtolower($element->nodeName)} = new ActionEndDate($element);
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getMnemonic()
    {
        return $this->mnemonic;
    }

    /**
     * @return mixed
     */
    public function getIncidentdate()
    {
        return $this->incidentdate;
    }

    /**
     * @return mixed
     */
    public function getMaildate()
    {
        return $this->maildate;
    }

    /**
     * @return mixed
     */
    public function getIncident()
    {
        return $this->incident;
    }

    /**
     * @return mixed
     */
    public function getDocket()
    {
        return $this->docket;
    }

    /**
     * @return mixed
     */
    public function getCleardate()
    {
        return $this->cleardate;
    }

    /**
     * @return mixed
     */
    public function getActionenddate()
    {
        return $this->actionenddate;
    }

    /**
     * @return mixed
     */
    public function getSuspflag()
    {
        return $this->suspflag;
    }
}
