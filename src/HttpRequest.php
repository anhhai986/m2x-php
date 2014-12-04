<?php

namespace Att\M2X;

class HttpRequest {

/**
 * Holds the resource handle for the CURL request
 *
 * @var resource
 */
  protected $request;

/**
 * List of headers to be sent
 *
 * @var array
 */
  protected $headers = array();

/**
 * Performs a GET request
 *
 * @param $url
 * @param array  $options
 * @return HttpResponse
 */
  public function get($url, $options = array()) {
    return $this->request('GET', $url, $options);
  }

/**
 * Add a header to the request
 *
 * @param string $key
 * @param string $value
 * @return HttpRequest
 */
  public function header($key, $value) {
    $this->headers[$key] = $value;
    return $this;
  }
/**
 * Executes a request
 *
 * @param string $method
 * @param string $url
 * @param array $vars
 * @return HttpResponse
 */
  public function request($method, $url, $vars = array()) {
    $this->request = curl_init();

    $this->setRequestMethod($method);
    $this->setOptions($url, $vars);

    $data = curl_exec($this->request);

    $response = new HttpResponse($data);

    curl_close($this->request);

    return $response;
  }

/**
 * Set the associated CURL options for a request method
 *
 * @param string $method
 * @return void
 */
  protected function setRequestMethod($method) {
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

/**
 * Set the CURL options
 *
 * @param string $url
 * @param array $vars
 * @return void
 */
  protected function setOptions($url, $vars) {
    curl_setopt($this->request, CURLOPT_URL, $url);
    curl_setopt($this->request, CURLOPT_HEADER, true);
    curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->request, CURLOPT_FOLLOWLOCATION, true);

    $headers = array();
    foreach ($this->headers as $key => $value) {
      $headers[] = $key . ':' . $value;
    }
    curl_setopt($this->request, CURLOPT_HTTPHEADER, $headers);
  }
}