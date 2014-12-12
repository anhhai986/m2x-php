<?php

class CurlRequest {

/**
 * Version of this API lib
 */
  const VERSION = "0.0.1";

/**
 * The selected endpoint
 *
 * @var string
 */
  private $endpoint = "";

/**
 * The API key to authenticate the request
 * @var string
 */
  private $key = "";

/**
 * Holds the curl instance
 *
 * @var integer
 */
  private $request;

/**
 * List of additional headers to set for the request
 *
 * @var array
 */
  private $headers = array();

/**
 * Configuration of this request
 *
 * @param string $endpoint the api endpoint
 * @param string $key the api key
 */
  public function __construct($endpoint, $key) {
    $this->endpoint = $endpoint;
    $this->key = $key;

    $this->headers["X-M2X-KEY"] = $key;
    $this->headers["Content-Type"] = "application/json";
  }

/**
 * Executes a HEAD request
 *
 * @param string $url
 * @param array $vars head variables
 * @return Response
 */
  public function head($url, $vars = array()) {
    return $this->request('head', $url, $vars);
  }

  public function options($url, $vars = array()) {
    return $this->request('options', $url, $vars);
  }

/**
 * Executes a GET request
 *
 * @param string $url
 * @param array $vars query parameters
 * @return Response
 */
  public function get($url, $vars = array()) {
    return $this->request('get', $url, $vars);
  }

/**
 * Executes a POST request
 *
 * @param string $url
 * @param array $vars post variables
 * @return Response
 */
  public function post($url, $vars = array()) {
    return $this->request('post', $url, $vars);
  }

/**
 * Executes a PUT request
 *
 * @param string $url
 * @param array $vars put variables
 * @return Response
 */
  public function put($url, $vars = array()) {
    return $this->request('put', $url, $vars);
  }

/**
 * Executes a DELETE request
 *
 * @param string $url
 * @param array $vars delete variables
 * @return Response
 */
  public function delete($url, $vars = array()) {
    return $this->request('delete', $url, $vars);
  }

  public function request($method, $url, $vars = array()) {
    $this->request = curl_init();

    $method = strtoupper($method);

    if($method == 'GET' && !empty($vars)) {
      $url = $url . "?" . http_build_query($vars); 
    }

    // set url and agent
    curl_setopt($this->request, CURLOPT_URL, $this->endpoint . $url); 
    curl_setopt($this->request, CURLOPT_USERAGENT, "M2X/" . self::VERSION . " (PHP curl)");
    //return the transfer as a string
    curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->request, CURLOPT_SSL_VERIFYPEER , false);
    // set curl timeout
    curl_setopt($this->request, CURLOPT_TIMEOUT, 60); 

    // retrieve headers
    curl_setopt($this->request, CURLOPT_HEADER, true);
    curl_setopt($this->request, CURLINFO_HEADER_OUT, true);

    $this->set_request_method($method);
    $this->set_request_headers();

    if(in_array($method, array("POST", "DELETE", "PUT"))) {
      curl_setopt($this->request, CURLOPT_POSTFIELDS, json_encode($vars));
    }
    
    // make call
    $result = curl_exec($this->request);
    $headers = curl_getinfo($this->request);
    $curl_error = curl_error($this->request);

    // close curl resource to free up system resources 
    curl_close($this->request);

    $output = substr($result, $headers['header_size']);

    // catch errors
    if(!empty($curl_error)) { 
      throw new CurlException("CURL ERROR: $curl_error, Output: $output", $headers['http_code'], null, $headers);
    }

    return new Response($headers, $output);
  }

/**
 * Internal helper method to configure CURL for a specific HTTP verb
 *
 * @param string $method
 * @return void
 */
  private function set_request_method($method) {
    switch (strtoupper($method)) {
    case 'HEAD':
      curl_setopt($this->request, CURLOPT_NOBODY, true);
      break;
    case 'GET':
      curl_setopt($this->request, CURLOPT_HTTPGET, true);
      break;
    case 'POST':
      curl_setopt($this->request, CURLOPT_POST, true);
      break;
    default:
      curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, $method);
    }
  }

  protected function set_request_headers() {
    $headers = array();
    foreach ($this->headers as $key => $value) {
      $headers[] = $key.': '.$value;
    }
    curl_setopt($this->request, CURLOPT_HTTPHEADER, $headers);
  }
}
