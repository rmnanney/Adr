<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/6/15
 * Time: 9:50 AM
 */

namespace Adr;

require_once __DIR__ . '/../Date.php';

class ConvictionDate extends Date {

    public function __construct(\DOMElement $xmlNode){
        parent::__construct($xmlNode);
        $this->dateType = self::DATE_TYPE_CONVICTION;
    }

}