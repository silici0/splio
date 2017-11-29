<?php namespace silici0\Splio

use Noodlehaus\Config;
use Curl\Curl;

class SplioService {

    private $config;
    private $curl;
    private $apiUrl = "s3s.fr/api/data/1.1/";
    private $apiProcotol = "https://";

    public function __construct()
    {
        $this->config = Config::load('config-splio.json');
        $this->curl = new Curl();
    }


    public function getLists()
    {
        $finalUrl = $this->apiProcotol.$this->config->universe.":".$this->config->apiKey."@".$this->apiUrl;
        $this->get($finalUrl);
        if ($this->curl->error)
            return $this->treatError();
        else
            return json_encode($this->curl->response);
    }

    private function treatError()
    {
        $message = array();
        
        $message['error'] = true;
        $message['error_code'] = $this->curl->error_code;
        $message['error_message'] = $this->curl->error_message;
        return json_encode($message);
    }
}