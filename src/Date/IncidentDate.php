<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/6/15
 * Time: 9:47 AM
 */

namespace Adr\Date;

require_once __DIR__ . '/../Date.php';

use Adr\Date;

class IncidentDate extends Date {

    public function __construct(\DOMElement $xmlNode){
        parent::__construct($xmlNode);
        $this->dateType = self::DATE_TYPE_INCIDENT;
    }

}