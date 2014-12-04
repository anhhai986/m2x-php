<?php

namespace Att\M2X;

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
    return Key::get($key);
  }

  public function get($path) {
    $request = $this->request();

    $request->header('X-M2X-KEY', $this->apiKey);

    return $request->get($this->endpoint . $path);
  }

  public function post($path, $vars) {
    $request = $this->request();
    $request->header('X-M2X-KEY', $this->apiKey)
            ->header('Content-Type', 'application/json');

    return $request->post($this->endpoint . $path, $vars);
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
