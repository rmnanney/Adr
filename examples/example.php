<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/9/15
 * Time: 1:34 PM
 */

require_once __DIR__ . '/../../../autoload.php';

use Adr\Request;
use Adr\Request\Order;
use Adr\Date\Dob;
use Adr\Response;

//Intro: It's likely you will not have credentials to the ADR service, so this example will use a mock XML file for the
//       request and response from the ADR service.


// If this is the first time you're running this code, you'll need to import the SQL files in the ./data directory
// into the server of your choosing.
//  #! mysql -u root yourDB < MVR_AVDCodes.sql
// #! mysql -u root yourDB < MVR_Rules.sql
// #! mysql -u root yourDB < MVR_RuleSets.sql
// Next, you'll want to #! cp ./dbconfig.ini.example dbconfig.ini
// Then, edit the dbconfig.ini with your sql server credentials
// Finally, run this file
// TODO: Create indexes in the three SQL files.

$config = parse_ini_file(__DIR__ . '/dbconfig.ini');
$db = new mysqli($config['hostname'], $config['username'], $config['password'], $config['dbname']);

print PHP_EOL . PHP_EOL . "Connecting to ADR DB:" . PHP_EOL;

if ($db->connect_error) {
    die('Connect Error (' . $db->connect_errno . ') '
        . $db->connect_error . PHP_EOL . PHP_EOL);
}

//Setup the request to be send to ADR (American Driving Records) WebMVR.
$requestOrder = new Order();  //NOTE: This is a Request\Order, NOT a Response\Order;  they are different!
//NOTE!! ADR Caveat: If the number of the year is specified in a two digit format, the values between 00-69
// are mapped to 2000-2069 and 70-99 to 1970-1999.
$dob = new Dob();
$dob->setYear(2000);
$dob->setMonth(01);
$dob->setDay(16);
$requestOrder->setState('WI');
$requestOrder->setLicense('N50073371234-01');
$requestOrder->setFirstName('Test');
$requestOrder->setLastName('TestLastName');
$requestOrder->setDOB($dob);
$requestOrder->setMisc('SomeRandomInternalTrackingID');
$requestOrder->setAuxMisc('SomeOtherRandomInternalTrackingID');
$requestOrder->setAccount('S1234');
$requestOrder->setHandling('OL');
$requestOrder->setProductID('DL');
$requestOrder->setSubtype('3Y');
$requestOrder->setPurpose('AA');

//Create the Request object, then add the Order to it.
$request = new Request();
$request->setHost('Online');
$request->setAccount('S1234');
$request->setUserID('03');
$request->setPassword('22225d7bs6e4bfdf71d5d5a1e912345', 'encrypted');
$request->setDeviceID('0C341E44063418446A304A3615314C30184C8831244C19442B404C473F40512345441C34274928351B4D4B431D4139456C4D5B36644D593490332B405123456', 'encrypted');
$request->setReportType('XML');
$request->addOrder($requestOrder);

//Let's check out how the Request XML looks
print 'REQUEST XML BEING SENT TO ADR:' . PHP_EOL . $request->getXML();

//Our Request is ready to send to ADR, but we're not actually doing it as I assume you do not have an account.
$response = $request->send($CURLResource);

//Since we aren't actually going to communicate with ADR, so we have to fake this out by calling response::loadXML below
//There are four different XML files you can use to simulate different scores (see below)
$response = new Response();
//$response->loadXML(file_get_contents(__DIR__ . '/response.standard.xml'));
$response->loadXML(file_get_contents(__DIR__ . '/response.preferred.xml'));
//$response->loadXML(file_get_contents(__DIR__ . '/response.decline.xml'));
//$response->loadXML(file_get_contents(__DIR__ . '/response.refer.xml'));
$response->parse();

//If you want to have your response persist to the filesystem
//$response->save('./mvr2.xml');

//Our Response is received and parsed.  Lets print out the XML so you can look it over.
print PHP_EOL . PHP_EOL . "Simulated response from ADR:" . PHP_EOL;
print $response->getXML();
print PHP_EOL . PHP_EOL . "Begin custom processing of response XML:" . PHP_EOL;

//At this point, the communication with ADR is done, and you can do whatever you need with the response data.  This
//example involves scoring the data, based on our Codes, Rules and RuleSets (in the SQL).  This does little more than
//give an idea of what you might want to do with the data.

//History nodes have violations, violations have AVD Codes which we will score.
$historyNodes = $response->getHistoryNodes();

$pointTotal = 0;
$decisions = array();
$rulesHits = array();

if (count($historyNodes)) {

    /** @var \Adr\Response\HistoryNode $history */
    foreach ($historyNodes as $history) {

        if ($history->hasViolations()) {
            $violations = $history->getViolations();

            /** @var \Adr\Response\Violation $violation */
            foreach ($violations as $violation) {
                $avdCode = $violation->getIncident()->getAvdcode();
                $timeSince = $violation->getTimeSinceIncident();

                $q = "SELECT * FROM `MVR_AVDCodes` WHERE `productID` = 1 AND `avdcode`='" . $avdCode . "'";
                $res = $db->query($q);
                while ($row = $res->fetch_assoc()) {
//                    print_r($row);
                    $ruleSetID = $row['ruleSetID'];
                    $rulesHits[$ruleSetID][] = array(
                        'avdcode' => $avdCode,
                        'timesince' => $timeSince
                    );
                }
            }
        } else {
            echo "No violations found.";
        }
    }

    //We have found AVD Codes we need to lookup.
    if (count($rulesHits)) {
        print_r($rulesHits);
        //Rules are classified into buckets, known as RuleSets
        foreach ($rulesHits as $ruleSetID => $hits) {
            $numHits = count($rulesHits[$ruleSetID]);
            $timeSince = $hits[0]['timesince'];
            if (1 < $numHits) {
                //Ensure we find the most recent incident for this RuleSet
                for ($i = 1; $i < $numHits; $i++) {
                    $timeSince = ($hits[$i] < $timeSince) ? $hits[$i] : $timeSince;
                }
            }

            echo "Found $numHits incidents on RuleSet #$ruleSetID.  Most recently $timeSince seconds ago." . PHP_EOL;

            $q = "SELECT * FROM MVR_Rules " .
                "WHERE ruleSetID = $ruleSetID " .
                "AND minOccurrences <= $numHits " .
                "AND riskBoundary >= $timeSince " .
                "ORDER BY minOccurrences DESC, riskBoundary ASC " .
                "LIMIT 1";
            $result = $db->query($q);
            if ($row = $result->fetch_assoc()) {
                print_r($row);
                if (!empty($row['decision'])) {
                    $decisions[] = $row['decision'];
                } else {
                    $pointTotal += $row['points'];
                    echo $row['points'] . " points associated to this violation (Rule ID: "
                        . $row['ruleID'] . ")." . PHP_EOL;
                }
            }
        }
    }
}


//If you want to categorize the results, you can use the $pointTotal to do something interesting, such as ...
echo "Total points: $pointTotal" . PHP_EOL;
echo "Decisions found: " . var_export($decisions, true) . PHP_EOL;

if (3 <= $pointTotal) {
    echo "return 'Decision::DECLINE'" . PHP_EOL;
} elseif (in_array('REFER', $decisions)) {
    echo "return 'Decision::REFER HOME OFFICE'" . PHP_EOL;
} elseif (2 == $pointTotal) {
    echo "return 'Decision::STANDARD" . PHP_EOL;
} elseif (1 == $pointTotal || 0 == $pointTotal) {
    echo "return 'Decision::PREFERRED'" . PHP_EOL;
} else {
    echo "Help me houston." . PHP_EOL;
}
