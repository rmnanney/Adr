<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/5/15
 * Time: 1:55 PM
 */

namespace Adr\Date;

require_once __DIR__ . '/../Date.php';

use Adr\Date;

class IssueDate extends Date {

    public function __construct(\DOMElement $xmlNode){
        parent::__construct($xmlNode);
        $this->dateType = self::DATE_TYPE_ISSUE;
    }
}