<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 2:45 PM
 */

namespace Adr;

//Need to use an autoloader here
require_once 'Response/AdditionalNode.php';
require_once 'Response/DriverNode.php';
require_once 'Response/HistoryNode.php';
require_once 'Response/LicenseNode.php';
require_once 'Response/MiscNode.php';
require_once 'Response/OrderNode.php';
require_once 'Response/ReturnNode.php';

use Adr\Response\AdditionalNode;
use Adr\Response\DriverNode;
use Adr\Response\HistoryNode;
use Adr\Response\LicenseNode;
use Adr\Response\MiscNode;
use Adr\Response\OrderNode;
use Adr\Response\ReturnNode;
use \DOMXPath;

//This needs to become a MVR2000 Object
class Response extends \DOMDocument {

    private $orderNodes;
    private $returnNodes;
    private $driverNodes;
    private $licenseNodes;
    private $miscNodes;
    private $additionalNodes;
    private $historyNodes;
    const XPATH_ORDER = '/ADR/MVR2000/Order';
    const XPATH_RETURN = '/ADR/MVR2000/Return';
    const XPATH_DRIVER = '/ADR/MVR2000/Driver';
    const XPATH_LICENSE = '/ADR/MVR2000/License';
    const XPATH_MISC = '/ADR/MVR2000/Misc';
    const XPATH_ADDITIONAL = '/ADR/MVR2000/Additional';
    const XPATH_HISTORY = '/ADR/MVR2000/History';

    public function __construct($ver = 1, $enc = 'utf8'){
        parent::__construct($ver, $enc);
        $this->orderNodes = array();
        $this->returnNodes = array();
        $this->driverNodes = array();
        $this->licenseNodes = array();
        $this->miscNodes = array();
        $this->additionalNodes = array();
        $this->historyNodes = array();
    }

    public function parse(){
        $xpath = new DOMXPath($this);
        $result = $xpath->query(self::XPATH_ORDER);
        foreach($result as $node){
            $this->orderNodes[] = new OrderNode($node);
        }
        $result = $xpath->query(self::XPATH_RETURN);
        foreach($result as $node){
            $this->returnNodes[] = new ReturnNode($node);
        }
        $result = $xpath->query(self::XPATH_DRIVER);
        foreach($result as $node){
            $this->driverNodes[] = new DriverNode($node);
        }
        $result = $xpath->query(self::XPATH_LICENSE);
        foreach($result as $node){
            $this->licenseNodes[] = new LicenseNode($node);
        }
        $result = $xpath->query(self::XPATH_MISC);
        foreach($result as $node){
            $this->miscNodes[] = new MiscNode($node);
        }
        $result = $xpath->query(self::XPATH_ADDITIONAL);
        foreach($result as $node){
            $this->additionalNodes[] = new AdditionalNode($node);
        }
        $result = $xpath->query(self::XPATH_HISTORY);
        foreach($result as $node){
            $this->historyNodes[] = new HistoryNode($node);
        }
    }

    public function save($param){
        if($param instanceof \mysqli){
            //Persist to the SQL schema of your choosing.

        }else{
            //Do the usual DOMDocument::save() instead.
            parent::save($param);
        }
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



    public function getScore(){

    }

    public function getDecision(){

    }

}