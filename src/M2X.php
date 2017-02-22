<?php

namespace Att\M2X;

use Att\M2X\Error\M2XException;

class M2X {

  const VERSION = '4.1.0';
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
 * Holds the user agent string
 *
 * @var string
 */
  protected $userAgent = '';

/**
 * Holds a reference to the last received HttpResponse
 *
 * @var HttpResponse
 */
  protected $lastResponse = null;

/**
 * Creates a new instance of the M2X API.
 *
 * Options:
 * - endpoint: Configure a custom endpoint (optional)
 *
 * @param string $apiKey Client API
 * @param array $options Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return void
 */
  public function __construct($apiKey, $options = array()) {
    $this->apiKey = $apiKey;

    if (isset($options['endpoint'])) {
      $this->endpoint = $options['endpoint'];
    } else {
      $this->endpoint = self::DEFAULT_API_BASE . '/' . self::DEFAULT_API_VERSION;
    }

    $this->userAgent = $this->userAgent();
  }

/**
 * Returns the API Key
 *
 * @return string API key
 */
  public function apiKey() {
    return $this->apiKey;
  }

/**
 * Returns the full URI to the M2X API.
 *
 * @return string URI to M2X API
 */
  public function endpoint() {
    return $this->endpoint;
  }

/**
 * Returns the API status.
 *
 * @return HttpResponse API status
 */
  public function status() {
    return $this->get('/status');
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/keys#List-Keys List Keys} endpoint.
 *
 * @return array Keys associated with the user
 */
  public function keys() {
    return Key::index($this);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/keys#View-Key-Details View Key Details} endpoint.
 * This method instantiates an instance of Key with
 * all its attributes initialized.
 *
 * @param string $key Key to retrieve
 * @return Key Instance of the key
 */
  public function key($key) {
    return Key::get($this, $key);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/keys#Create-Key Create Key} endpoint.
 *
 * @param  $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Key The newly created Key
 */
  public function createKey($data) {
    return Key::create($this, $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/distribution#List-Distributions List Distributions} endpoint.
 *
 * @param $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return DistributionCollection List of distributions
 */
  public function distributions($params = array()) {
    return new DistributionCollection($this, $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/distribution#View-Distribution-Details View Distribution Details} endpoint.
 * This method instantiates an instance of Distribution
 * with all its attributes initialized.
 *
 * @param string $id Distribution ID to be retrieved
 * @return Distribution Distribution retrieved
 */
  public function distribution($id) {
    return Distribution::get($this, $id);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/distribution#Create-Distribution Create Distribution} endpoint.
 *
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Distribution The newly created Distribution
 */
  public function createDistribution($data) {
    return Distribution::create($this, $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#List-Devices List Devices} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return DeviceCollection List of Devices
 */
  public function devices($params = array()) {
    return new DeviceCollection($this, $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#List-Search-Public-Devices-Catalog List Public Devices Catalog} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return DeviceCollection List of Devices that meet the search criteria
 */
  public function deviceCatalog($params = array()) {
    return new DeviceCollection($this, $params, true);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#View-Device-Details View Device Details} endpoint.
 *
 * This method instantiates an instance of Device
 * with all its attributes initialized.
 *
 * @param string $id Device ID to be retrieved
 * @return Device The Device retrieved
 */
  public function device($id) {
    return Device::get($this, $id);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Create-Device Create Device} endpoint.
 *
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Device The newly created Device
 */
  public function createDevice($data) {
    return Device::create($this, $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#List-Device-Tags List Device Tags} endpoint.
 *
 * @return array Device tags associated with your account
 */
  public function deviceTags() {
    $response = $this->get('/devices/tags');
    return $response->json();
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Search-Devices Search Devices} endpoint.
 *
 * @param $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse List of Device objects
 */
  public function searchDevices($data) {
    return $this->post('/devices/search', $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#List-collections List Collections} endpoint.
 *
 * @param $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return CollectionCollection List of Collection objects
 */
  public function collections($params = array()) {
    return new CollectionCollection($this, $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#View-Collection-Details View Collection Details} endpoint.
 * This method instantiates an instance of Collection
 * with all its attributes initialized.
 *
 * @param string $id Collection ID to be retrieved
 * @return Collection The retrieved Collection
 */
  public function collection($id) {
    return Collection::get($this, $id);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/jobs#List-Jobs List Jobs} endpoint.
 *
 * @param $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return CollectionCollection List of jobs retrieved
 */
  public function jobs($params = array()) {
    return new JobCollection($this, $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/commands#View-Command-Details View Command Details} endpoint.
 *
 * @param string $id Command ID
 * @return Command The retrieved Command
 */
  public function viewCommandDetails($id) {
    return Command::get($this, $id);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/commands#Send-Command Send Command} endpoint.
 *
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The Command that was just sent
 */
  public function sendCommand($data = array()) {
     return $this->post('/commands', $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/commands#List-Sent-Commands List Sent Commands} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return CommandCollection List of Commands retrieved
 */
  public function commands($params = array()) {
    return new CommandCollection($this, $params);
 }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/jobs#View-Job-Details View Job Details} endpoint.
 * This method instantiates an instance of Job with all its attributes initialized.
 *
 * @param string $id ID of the Job to retrieve
 * @return Job The matching Job
 */
  public function job($id) {
    return Job::get($this, $id);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#Create-Collection Create Collection} endpoint.
 *
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Device The newly created Collection.
 */
  public function createCollection($data) {
    return Collection::create($this, $data);
  }

/**
 * Perform a GET request to the API.
 *
 * @param string $path
 * @param array $params query parameters
 * @param array $vars request body
 * @return HttpResponse
 * @throws M2XException
 */
  public function get($path, $params = array(), $vars = array()) {
    $request = $this->request();
    $request = $this->prepareRequest($request);

    $response = $request->get($this->endpoint . $path, $params, $vars);
    return $this->handleResponse($response);
  }

/**
 * Perform a POST request to the API.
 *
 * @param string $path
 * @param array $vars
 * @return HttpResponse
 * @throws M2XException
 */
  public function post($path, $vars = array()) {
    $request = $this->request();
    $request = $this->prepareRequest($request);

    $response = $request->post($this->endpoint . $path, $vars);
    return $this->handleResponse($response);
  }

/**
 * Perform a PUT request to the API.
 *
 * @param string $path
 * @param array $vars
 * @return HttpResponse
 * @throws M2XException
 */
  public function put($path, $vars = array()) {
    $request = $this->request();
    $request = $this->prepareRequest($request);

    $response = $request->put($this->endpoint . $path, $vars);
    return $this->handleResponse($response);
  }

/**
 * Perform a DELETE request to the API.
 *
 * @param string $path
 * @param array $params
 * @return HttpResponse
 * @throws M2XException
 */
  public function delete($path, $params = array()) {
    $request = $this->request();
    $request = $this->prepareRequest($request);

    $response = $request->delete($this->endpoint . $path, $params);
    return $this->handleResponse($response);
  }

/**
 * Sets the common headers for each request to the API.
 *
 * @param HttpRequest $request
 * @return HttpRequest
 */
  protected function prepareRequest($request) {
    $request->header('X-M2X-KEY', $this->apiKey);
    $request->header('User-Agent', $this->userAgent);
    return $request;
  }

/**
 * Checks the HttpResponse for errors and throws an exception, if
 * no errors are encountered, the HttpResponse is returned.
 *
 * @param HttpResponse $response
 * @return HttpResponse
 * @throws M2XException
 */
  protected function handleResponse(HttpResponse $response) {
    $this->lastResponse = $response;

    if ($response->success()) {
      return $response;
    }

    throw new M2XException($response);
  }

/**
 * Generate the user agent string
 *
 * @return string
 */
  public function userAgent() {
    $version = self::VERSION;
    $phpVersion = phpversion();
    $os = php_uname();

    return "M2X-PHP/{$version} PHP/{$phpVersion} ({$os})";
  }

/**
 * Creates an instance of the HttpRequest if it doesnt exist yet.
 *
 * @return HttpRequest
 */
  private function request() {
    if (!$this->request) {
      $this->request = new HttpRequest();
    }

    return $this->request;
  }

/**
 * The last received response
 *
 * @return HttpResponse
 */
  public function lastResponse() {
    return $this->lastResponse;
  }
}
