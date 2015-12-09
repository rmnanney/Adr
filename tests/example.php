<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/9/15
 * Time: 1:34 PM
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Adr\Response;

//Just a quick rig to get this thing running ASAP.
$config = parse_ini_file(__DIR__ . '/dbconfig.ini');

$db = new \mysqli($config['hostname'],$config['username'],$config['password'],$config['dbname']);

$response = new Response();
$response->loadXML(file_get_contents(__DIR__ . '/mvr1.xml'));
$response->parse();
//$response->save('./mvr2.xml');
$historyNodes = $response->getHistoryNodes();

$pointTotal = 0;
$decisions = array();
$rulesHits = array();

if(count($historyNodes)){

    /** @var \Adr\Response\HistoryNode $history */
    foreach($historyNodes as $history){

        if($history->hasViolations()){
            $violations = $history->getViolations();

            /** @var \Adr\Response\Violation $violation */
            foreach($violations as $violation){
                $avdCode = $violation->getIncident()->getAvdcode();
                $timeSince = $violation->getTimeSinceIncident();

                $q = "SELECT * FROM `MVR_AVDCodes` WHERE `productID` = 1 AND `avdcode`='" . $avdCode . "'";
                $res = $db->query($q);
                while($row = $res->fetch_assoc()){
                    $ruleSetID = $row['ruleSetID'];
                    $rulesHits[$ruleSetID][] = array(
                        'avdcode' => $avdCode,
                        'timesince' => $timeSince
                    );
                }
            }
        }else{
            echo "No violations found.";
        }
    }

    //We have found AVD Codes we need to lookup
    if(count($rulesHits)){

        //Rules are classified into buckets, known as RuleSets
        foreach($rulesHits as $ruleSetID => $hits){
            $numHits = count($rulesHits[$ruleSetID]);
            $timeSince = $hits[0]['timesince'];
            if(1 < $numHits){
                //Ensure we find the most recent incident for this RuleSet
                for($i = 1; $i < $numHits; $i++){
                    $timeSince = ($hits[$i] < $timeSince)?$hits[$i]:$timeSince;
                }
            }

            echo "Found $numHits incidents on RuleSet #4.  Most recently $timeSince seconds ago." . PHP_EOL;

            $q = "SELECT * FROM MVR_Rules ".
                "WHERE ruleSetID = $ruleSetID ".
                "AND minOccurrences <= $numHits ".
                "AND riskBoundary >= $timeSince ".
                "ORDER BY minOccurrences DESC, riskBoundary ASC ".
                "LIMIT 1";
            $result = $db->query($q);
            if($row = $result->fetch_assoc()){
                if(!empty($row['decision'])){
                    $decisions[] = $row['decision'];
                }else{
                    $pointTotal += $row['points'];
                    echo $row['points'] . " points associated to this violation (Rule ID: " . $row['ruleID'] . ")." . PHP_EOL;
                }
            }
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
elseif(1 == $pointTotal || 0 == $pointTotal)
    echo "return 'Decision::PREFERRED'" . PHP_EOL;
else
    echo "Help me houston." . PHP_EOL;