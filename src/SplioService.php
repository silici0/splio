<?php namespace silici0\Splio;

use Noodlehaus\Config;
use Curl\Curl;

class SplioService {

    private $config;
    private $curl;
    private $apiUrl = "s3s.fr/api/data/1.1/";
    private $apiProcotol = "https://";

    public function __construct($path = null)
    {
        if (!is_null($path))
            $this->config = Config::load($path.'config-vtex.json');
        else
            $this->config = Config::load('config-vtex.json');
        $this->curl = new Curl();
    }


    public function getLists()
    {
        $finalUrl = $this->apiProcotol.$this->apiUrl;
        $this->curl->setBasicAuthentication($this->config->get('universe'), $this->config->get('apiKey'));
        $this->curl->get($finalUrl.'lists');
        if ($this->curl->error)
            return $this->treatError();
        else
            return json_decode($this->curl->response, true);
    }

    public function getFields()
    {
        $finalUrl = $this->apiProcotol.$this->apiUrl;
        $this->curl->setBasicAuthentication($this->config->get('universe'), $this->config->get('apiKey'));
        $this->curl->get($finalUrl.'fields');
        if ($this->curl->error)
            return $this->treatError();
        else
            return json_decode($this->curl->response, true);
    }

    public function saveNewContact($params)
    {
        $finalUrl = $this->apiProcotol.$this->apiUrl;
        $this->curl->setBasicAuthentication($this->config->get('universe'), $this->config->get('apiKey'));
        $params = $this->curl_postfields_flatten($params, $post);
        $this->curl->post($finalUrl.'contact', $params);
        if ($this->curl->error)
            return $this->treatError();
        else
            return json_decode($this->curl->response, true);
    }

    public function getContact($email)
    {
        $finalUrl = $this->apiProcotol.$this->apiUrl;
        $this->curl->setBasicAuthentication($this->config->get('universe'), $this->config->get('apiKey'));
        $this->curl->get($finalUrl.'contact/'.$email);
        if ($this->curl->error)
            return $this->treatError();
        else
            return json_decode($this->curl->response, true);
    }

    public function updateContact($email, $params)
    {
        $finalUrl = $this->apiProcotol.$this->apiUrl;
        $this->curl->setBasicAuthentication($this->config->get('universe'), $this->config->get('apiKey'));
        $params = $this->curl_postfields_flatten($params, $post);
        $this->curl->put($finalUrl.'contact/'.$email, $post, true);
        if ($this->curl->error)
            return $this->treatError();
        else
            return json_decode($this->curl->response, false);
    }

    public function curl_postfields_flatten($arrays, &$new = array(), $prefix = null) {
        if ( is_object( $arrays ) ) {
            $arrays = get_object_vars( $arrays );
        }

        foreach ( $arrays AS $key => $value ) {
            $k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
            if ( is_array( $value ) OR is_object( $value )  ) {
                $this->curl_postfields_flatten( $value, $new, $k );
            } else {
                $new[$k] = $value;
            }
        }
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