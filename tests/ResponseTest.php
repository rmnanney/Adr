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


$response = new Response();
$response->loadXML(file_get_contents('./mvr1.xml'));
$response->parse();
print_r($response);