<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 2:45 PM
 */

namespace Adr;

use Adr\Response\AdditionalNode;
use Adr\Response\DriverNode;
use Adr\Response\HistoryNode;
use Adr\Response\LicenseNode;
use Adr\Response\MiscNode;
use Adr\Response\OrderNode;
use Adr\Response\ReturnNode;
use Adr\Response\SummaryNode;
use \DOMXPath;

//This needs to become a MVR2000 Object
class Response extends \DOMDocument
{

    private $orderNodes;
    private $returnNodes;
    private $driverNodes;
    private $licenseNodes;
    private $miscNodes;
    private $additionalNodes;
    private $historyNodes;
    private $summaryNode;
    private $data;
    private $format;
    const XPATH_ORDER = '/ADR/MVR2000/Order';
    const XPATH_RETURN = '/ADR/MVR2000/Return';
    const XPATH_DRIVER = '/ADR/MVR2000/Driver';
    const XPATH_LICENSE = '/ADR/MVR2000/License';
    const XPATH_MISC = '/ADR/MVR2000/Misc';
    const XPATH_ADDITIONAL = '/ADR/MVR2000/Additional';
    const XPATH_HISTORY = '/ADR/MVR2000/History';
    const XPATH_SUMMARY = '/ADR/Summary';
    const XPATH_DATA = '/ADR/MVR2000/Data';
    const XPATH_FORMAT = '/ADR/MVR2000/Format';

    /**
     * Response constructor.
     * @param int $ver
     * @param string $enc
     */
    public function __construct($ver = 1, $enc = 'utf8')
    {
        parent::__construct($ver, $enc);
        $this->orderNodes = array();
        $this->returnNodes = array();
        $this->driverNodes = array();
        $this->licenseNodes = array();
        $this->miscNodes = array();
        $this->additionalNodes = array();
        $this->historyNodes = array();
    }

    /**
     * @return string
     */
    public function getXML()
    {
        $this->formatOutput = true;
        return parent::saveXML();
    }

    /**
     *
     */
    public function parse()
    {
        $xpath = new DOMXPath($this);
        $result = $xpath->query(self::XPATH_ORDER);
        foreach ($result as $node) {
            $this->orderNodes[] = new OrderNode($node);
        }
        $result = $xpath->query(self::XPATH_RETURN);
        foreach ($result as $node) {
            $this->returnNodes[] = new ReturnNode($node);
        }
        $result = $xpath->query(self::XPATH_DRIVER);
        foreach ($result as $node) {
            $this->driverNodes[] = new DriverNode($node);
        }
        $result = $xpath->query(self::XPATH_LICENSE);
        foreach ($result as $node) {
            $this->licenseNodes[] = new LicenseNode($node);
        }
        $result = $xpath->query(self::XPATH_MISC);
        foreach ($result as $node) {
            $this->miscNodes[] = new MiscNode($node);
        }
        $result = $xpath->query(self::XPATH_ADDITIONAL);
        foreach ($result as $node) {
            $this->additionalNodes[] = new AdditionalNode($node);
        }
        $result = $xpath->query(self::XPATH_HISTORY);
        foreach ($result as $node) {
            $this->historyNodes[] = new HistoryNode($node);
        }
        $result = $xpath->query(self::XPATH_SUMMARY);
        foreach ($result as $node) {
            $this->summaryNode = new SummaryNode($node);
        }
        $result = $xpath->query(self::XPATH_DATA);
        foreach ($result as $node) {
            $this->data = $node->nodeValue;
        }
        $result = $xpath->query(self::XPATH_FORMAT);
        foreach ($result as $node){
            $this->format = $node->nodeValue;
        }
    }

    /**
     * @param string $param
     * @return void
     */
    public function save($param)
    {
        if ($param instanceof \mysqli) {
            //Persist to the SQL schema of your choosing.

        } else {
            //Do the usual DOMDocument::save() instead.
            parent::save($param);
        }
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->summaryNode->getError();
    }

    /**
     * @return mixed
     */
    public function getErrorDescription()
    {
        return $this->summaryNode->getErrorDescription();
    }

    /**
     * @return array
     */
    public function getOrderNodes()
    {
        return $this->orderNodes;
    }

    /**
     * @return array
     */
    public function getReturnNodes()
    {
        return $this->returnNodes;
    }

    /**
     * @return array
     */
    public function getDriverNodes()
    {
        return $this->driverNodes;
    }

    /**
     * @return array
     */
    public function getLicenseNodes()
    {
        return $this->licenseNodes;
    }

    /**
     * @return array
     */
    public function getMiscNodes()
    {
        return $this->miscNodes;
    }

    /**
     * @return array
     */
    public function getAdditionalNodes()
    {
        return $this->additionalNodes;
    }

    /**
     * @return array
     */
    public function getHistoryNodes()
    {
        return $this->historyNodes;
    }

    /**
     * @return mixed
     */
    public function getReportData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getReportFormat()
    {
        return $this->format;
    }




    /**
     *
     */
    public function getScore()
    {

    }

    /**
     *
     */
    public function getDecision()
    {

    }
}
