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
$db = new \mysqli('127.0.0.1','*****','*****','*****');

$response = new Response();
$response->loadXML(file_get_contents('./mvr1.xml'));
$response->parse();
//$response->save('./mvr2.xml');
$historyNodes = $response->getHistoryNodes();

$pointTotal = 0;
$decisions = array();

if(count($historyNodes)){

    /** @var \Adr\Response\HistoryNode $history */
    foreach($historyNodes as $history){

        if($history->hasViolations()){
            $violations = $history->getViolations();

            /** @var \Adr\Response\Violation $violation */
            foreach($violations as $violation){
                $avdCode = $violation->getIncident()->getAvdcode();
                $timeSince = $violation->getTimeSinceIncident();

                echo "Report on AVDCode: $avdCode, $timeSince seconds ( ~".(round(($timeSince/604800)/4,2))." months) have elapsed since." . PHP_EOL;

                $q = "SELECT * FROM `MVR_AVDCodes` AS `Codes`
 LEFT JOIN `MVR_Rules` AS `Rules`
 ON `Codes`.`ruleID` = `Rules`.`id`
 WHERE `Codes`.`productID` = 1 AND `Codes`.`avdcode`='" . $avdCode . "'
 AND `riskBoundary` >= " . $timeSince . " ORDER BY `riskBoundary` ASC LIMIT 1";
                $res = $db->query($q);
                if($row = $res->fetch_assoc()){
                    if(!empty($row['decision']))
                        $decisions[] = $row['decision'];

                    $pointTotal += $row['points'];
                    echo $row['points'] . " points associated to this violation (Rule ID: " . $row['ruleID'] . ")." . PHP_EOL;
                }else{
                    echo "0 points associated to this violation." . PHP_EOL;
                }
                echo PHP_EOL;
            }
        }else{
            echo "No violations found.";
        }
    }
}

echo "Total points: $pointTotal" . PHP_EOL;
echo "Decisions found: " . var_export($decisions, true) . PHP_EOL;

if(3 <= $pointTotal)
    echo "return 'Decision::DECLINE'" . PHP_EOL;
elseif(in_array('REFER', $decisions))
    echo "return 'Decision::REFER HOME OFFICE'" . PHP_EOL;
elseif(2 == $pointTotal)
    echo "return 'Decision::STANDARD" . PHP_EOL;
elseif(1 == $pointTotal)
    echo "return 'Decision::PREFERRED'" . PHP_EOL;
else
    echo "Help me houston." . PHP_EOL;