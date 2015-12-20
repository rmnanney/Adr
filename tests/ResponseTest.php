<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 4:38 PM
 */

namespace Adr\tests;

require_once __DIR__ . '/../vendor/autoload.php';

use Adr\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $response = new Response();
        $response->loadXML(file_get_contents('./mvr1.xml'));
        $response->parse();

        //Do something useful...
    }
}
