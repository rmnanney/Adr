<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/6/15
 * Time: 9:44 AM
 */

namespace Adr\Response;

use Adr\Response\Date\IncidentDate;
use Adr\Response\Date\ConvictionDate;
use Adr\State;

class Violation
{

    private $type;
    private $mnemonic;
    private $incidentdate;
    private $convictiondate;
    private $state;
    private $location;
    private $incident;
    private $actualspeed;
    private $postedspeed;
    private $disposition;
    private $docket;

    public function __construct(\DOMElement $xmlNode)
    {
        foreach ($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                switch (strtoupper($element->nodeName)) {
                    case 'INCIDENTDATE':
                        $this->incidentdate = new IncidentDate($element);
                        break;
                    case 'CONVICTIONDATE':
                        $this->convictiondate = new ConvictionDate($element);
                        break;
                    case 'STATE':
                        $this->state = new State($element);
                        break;
                    case 'INCIDENT':
                        $this->incident = new Incident($element);
                        break;
                    default:
                        $this->{strtolower($element->nodeName)} = $element->nodeValue;
                        break;
                }
            }
        }
    }

    public function getTimeSinceIncident()
    {
        return time() - $this->incidentdate->getEpoch();
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
    public function getConvictiondate()
    {
        return $this->convictiondate;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
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
    public function getActualspeed()
    {
        return $this->actualspeed;
    }

    /**
     * @return mixed
     */
    public function getPostedspeed()
    {
        return $this->postedspeed;
    }

    /**
     * @return mixed
     */
    public function getDisposition()
    {
        return $this->disposition;
    }

    /**
     * @return mixed
     */
    public function getDocket()
    {
        return $this->docket;
    }
}
