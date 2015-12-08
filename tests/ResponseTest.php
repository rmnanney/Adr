<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 4:38 PM
 */

namespace Adr\tests;

//need to use an autoloader
require_once '../src/Response.php';

use Adr\Response;

//class ResponseTest extends \PHPUnit_Framework_TestCase {
//    public function testConstructor(){
//        $response = new Response();
//        $response->loadXML(file_get_contents('./mvr1.xml'));
//        $response->parse();
//    }
//}

//Just a quick rig to get this thing running ASAP.  Unit tests to replace.
$response = new Response();
$response->loadXML(file_get_contents('./mvr1.xml'));
$response->parse();
$historyNodes = $response->getHistoryNodes();

if(count($historyNodes)){
    /** @var \Adr\Response\HistoryNode $history */
    foreach($historyNodes as $history){
        if($history->hasViolations()){
            $violations = $history->getViolations();
            //Now we can begin evaluating the violation against our custom rule sets
            /** @var \Adr\Response\Violation $violation */
            foreach($violations as $violation){
                $convictedDate = $violation->getConvictiondate();
                $convictedEpoch = $convictedDate->getEpoch();
                $incident = $violation->getIncident();
                $avdCode = $incident->getAvdcode();
                var_dump($avdCode);
                var_dump($convictedEpoch);
            }
        }else{
            echo "No violations found.";
        }
    }
}