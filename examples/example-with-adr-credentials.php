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
use Adr\State;
use Adr\Response;

//Intro: It's likely you will not have credentials to the ADR service, so this example will use a mock XML file for the
//       request and response from the ADR service.


// If this is the first time you're running this code, you'll need to import the SQL files in the ./data directory
// into the server of your choosing.
// #! mysql -u root yourDB < MVR_AVDCodes.sql
// #! mysql -u root yourDB < MVR_Rules.sql
// #! mysql -u root yourDB < MVR_RuleSets.sql
// Next, you'll want to #! cp ./dbconfig.ini.example dbconfig.ini
// Then, edit the dbconfig.ini with your sql server credentials
// ANND DEN, ensure you setup the adrconfig.ini with your ADR DEV Credentials.
// Finally, run this file
// TODO: Create indexes in the three SQL files.

$dbConfig = parse_ini_file(__DIR__ . '/dbconfig.ini');
$db = new mysqli($dbConfig['hostname'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

print PHP_EOL . PHP_EOL . "Connecting to ADR DB:" . PHP_EOL;

if ($db->connect_error) {
    die('Connect Error (' . $db->connect_errno . ') '
        . $db->connect_error . PHP_EOL . PHP_EOL);
}

$adrConfig = parse_ini_file(__DIR__ . '/adrconfig.ini');
$CONFIG_HOST = $adrConfig['host'];
$CONFIG_ACCOUNT = $adrConfig['account'];
$CONFIG_USERID = $adrConfig['userID'];
$CONFIG_PASSWORD = $adrConfig['password'];
$CONFIG_REPORTTYPE = $adrConfig['reportType'];
$CONFIG_ADRIPADDRESS = $adrConfig['ADRIPAddress'];
$CONFIG_ADRPORT = $adrConfig['ADRPort'];

//Setup the request to be send to ADR (American Driving Records) WebMVR.
$requestOrder = new Order();  //NOTE: This is a Request\Order, NOT a Response\Order;  they are different!
//NOTE!! ADR Caveat: If the number of the year is specified in a two digit format, the values between 00-69
// are mapped to 2000-2069 and 70-99 to 1970-1999.
$dob = new Dob();
$dob->setYear(1975);
$dob->setMonth(11);
$dob->setDay(12);
$state = new State();
$state->setAbbrev('CA');
$requestOrder->setLicense('A1000004');
$requestOrder->setFirstName('CHRIS');
$requestOrder->setLastName('SMITH');
$requestOrder->setDOB($dob);
$requestOrder->setMisc('SomeRandomInternalTrackingID');
$requestOrder->setState($state);
$requestOrder->setAuxMisc('SomeOtherRandomInternalTrackingID');
$requestOrder->setAccount($CONFIG_ACCOUNT);
$requestOrder->setHandling('OL');
$requestOrder->setProductID('DL');
$requestOrder->setSubtype('3Y');
$requestOrder->setPurpose('AA');

//Create the Request object, then add the Order to it.
$request = new Request();

//If you call this method, you will need to ensure a
//$newPassword = $request->resetPassword();
$request->setHost($CONFIG_HOST);
$request->setAccount($CONFIG_ACCOUNT);
$request->setUserID($CONFIG_USERID);
$request->setPassword($CONFIG_PASSWORD);
$request->setReportType($CONFIG_REPORTTYPE);
$request->setADRIPAddress($CONFIG_ADRIPADDRESS);
$request->setADRPort($CONFIG_ADRPORT);

//An optional report
$request->setAdditionalReportType(\Adr\Request\AdditionalReportType::HTML);

$request->addOrder($requestOrder);

//Let's check out how the Request XML looks
print 'REQUEST XML BEING SENT TO ADR:' . PHP_EOL . $request->getXML();

//Our Request is ready to send to ADR, but we're not actually doing it as I assume you do not have an account.
try{
    $response = $request->send();

    //Did we reset that password?  Save it or you'll be <epic>Sad Face</epic>.
    if($request->hasNewPassword()){
        $newPassword = $request->getNewPassword();
        //Open a file / database / whatever and save your new password.
    }
} catch (Exception $e) {
    print "Exception found : " . $e->getMessage();
}

//If you wanted to get the HTML report, assuming you set it above: $request->setAdditionalReportType(\Adr\Request\AdditionalReportType::HTML);
//print $response->getReportData();
//print $response->getReportFormat();


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
