<?php

namespace Att\M2X;

use Att\M2X\Error\M2XException;

class M2X {

  const DEFAULT_API_BASE = 'https://api-m2x.att.com';
    const DEFAULT_API_VERSION = 'v2';

/**
 * The full URI to the M2X API
 *
 * @var string
 */
    protected $endpoint;

/**
 * Holds the API Key
 *
 * @var string
 */
  protected $apiKey;

/**
 * Holds the instance that does all HTTP requests
 *
 * @var HttpRequest
 */
  public $request;

/**
 * Contructor
 *
 * @param string $apiKey
 * @return void
 */
  public function __construct($apiKey) {
    $this->apiKey = $apiKey;
    $this->endpoint = self::DEFAULT_API_BASE . '/' . self::DEFAULT_API_VERSION;
  }

/**
 * Returns the API Key
 *
 * @return string
 */
  public function apiKey() {
    return $this->apiKey;
  }

/**
 * Returns the full URI to the M2X API
 *
 * @return string
 */
  public function endpoint() {
    return $this->endpoint;
  }

/**
 * Returns the API status
 *
 * @return HttpResponse
 */
  public function status() {
    return $this->get('/status');
  }

/**
 * Retrieve a list of keys associated with the user account.
 *
 * @return 
 */
  public function keys() {
    return Key::index($this);
  }

/**
 * Retrieve a single key from the API.
 *
 * This method instantiates an instance of Key with
 * all its attributes initialized.
 * 
 * @param string $key
 * @return Key
 */
  public function key($key) {
    return Key::get($this, $key);
  }

/**
 * Create a new API key.
 *
 * @param  $data
 * @return Key
 */
  public function createKey($data) {
    return Key::create($this, $data);
  }

/**
 * Retrieve a list of distributions associated with the user account.
 *
 * @return 
 */
  public function distributions() {
    return Distribution::index($this);
  }

/**
 * Retrieve a list of devices associated with the user account.
 *
 * @return DeviceCollection
 */
  public function devices($params = array()) {
    return new DeviceCollection($this, $params);
  }

/**
 * Retrieve a single device from the API.
 *
 * This method instantiates an instance of Device
 * with all its attributes initialized.
 *
 * @param string $key
 * @return Key
 */
  public function device($id) {
    return Device::get($this, $id);
  }

/**
 * Create a new device.
 *
 * @param  $data
 * @return Device
 */
  public function createDevice($data) {
    return Device::create($this, $data);
  }

  public function get($path, $params = array()) {
    $request = $this->request();
    $request->header('X-M2X-KEY', $this->apiKey);

    $response = $request->get($this->endpoint . $path, $params);
    return $this->handleResponse($response);
  }

  public function post($path, $vars = array()) {
    $request = $this->request();
    $request->header('X-M2X-KEY', $this->apiKey);

    $response = $request->post($this->endpoint . $path, $vars);
    return $this->handleResponse($response);
  }

  public function put($path, $vars = array()) {
    $request = $this->request();
    $request->header('X-M2X-KEY', $this->apiKey);

    $response = $request->put($this->endpoint . $path, $vars);
    return $this->handleResponse($response);
  }

  public function delete($path, $vars = array()) {
    $request = $this->request();
    $request->header('X-M2X-KEY', $this->apiKey);

    $response = $request->delete($this->endpoint . $path, $vars);
    return $this->handleResponse($response);
  }

  protected function handleResponse(HttpResponse $response) {
    if (!in_array($response->statusCode, array(200, 201, 202, 204))) {
      throw new M2XException($response);
    }

    return $response;
  }

/**
 * Creates an instance of the HttpRequest if it doesnt exist yet
 *
 * @return HttpRequest
 */
  private function request() {
    if (!$this->request) {
      $this->request = new HttpRequest();
    }

    return $this->request;
  }
}
