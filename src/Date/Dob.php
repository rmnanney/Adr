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

class Dob extends Date {

    protected $dateType = 2;

    public function getXML(\DOMDocument $doc){
        return self::generateXML($doc);
    }

    private function generateXML(\DOMDocument $doc){
        $dob = $doc->createElement('DOB');
        $dob->appendChild($doc->createElement('Year', $this->year));
        $dob->appendChild($doc->createElement('Month', $this->month));
        $dob->appendChild($doc->createElement('Day', $this->day));
        return $dob;
    }

}