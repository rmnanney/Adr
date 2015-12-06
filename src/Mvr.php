<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 2:41 PM
 */

namespace Adr;


class Mvr{
    private $request;
    private $response;

    function __construct(){
        $this->request = new Request();
        $this->response = new Response();
    }

    public function send(){
        //send over curl or w/e
        $xmlResponse = $this->request->send();

        $this->response->loadXML($xmlResponse);
//        $this->response->parseObjects();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }



}