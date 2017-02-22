<?php

namespace Att\M2X;

use Att\M2X\M2X;
use Att\M2X\Device;

/**
 * Methods for interacting M2X Device Streams
 */
class Stream extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = ':parent_path/streams';

/**
 * The parent resource that this stream belongs to
 *
 * @var Resource
 */
  public $parent = null;
/**
 * The Stream resource properties
 *
 * @var array
 */
  protected static $properties = array(
    'name', 'unit', 'type'
  );

/**
 * Disable the original GET factory
 *
 * @param M2X $client
 * @param string $id
 * @return void
 */
  public static function get($client, $id) {
    throw new \BadMethodCallException('Not implemented, use Stream::getStream() instead.');
  }

/**
 * Disable the original POST factory
 *
 * @param M2X $client
 * @param array $data
 * @return void
 */
  public static function create($client, $data = array()) {
    throw new \BadMethodCallException('Not implemented, use Stream::createStream() instead.');
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#View-Data-Stream View Data Stream} endpoint.
 *
 * @param M2X $client Client API
 * @param Resource $parent Parent resource that this collection belongs to
 * @param string $id Stream ID to be retrieved
 * @return Resource Stream retrieved
 */
  public static function getStream(M2X $client, Resource $parent, $id) {
    $response = $client->get(str_replace(':parent_path', $parent->path(), static::$path) . '/' . $id);

    $class = get_called_class();
    return new $class($client, $parent, $response->json());
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Create-Update-Data-Stream Create or update Data Stream} endpoint.
 *
 * @param M2X $client Client API
 * @param Resource $parent Parent resource that this collection belongs to
 * @param string $name Stream name to be created
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Stream The newly created stream
 */
  public static function createStream(M2X $client, Resource $parent, $name, $data) {
    $path = str_replace(':parent_path', $parent->path(), static::$path) . '/' . $name;
    $response = $client->put($path, $data);

    if ($response->statusCode == 204) {
      return self::getStream($client, $parent, $name);
    }

    return new self($client, $parent, $response->json());
  }

/**
 * Create object from API data
 *
 * @param M2X $client Client API
 * @param resource $parent Parent resource that this collection belongs to
 * @param stdClass $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 */
  public function __construct(M2X $client, Resource $parent, $data) {
    $this->parent = $parent;
    parent::__construct($client, $data);
  }

/**
 * The resource id for the REST URL
 *
 * @return string
 */
  public function id() {
    return $this->name;
  }

/**
 * Returns the path to the resource
 *
 * @return string Path
 */
  public function path() {
    return str_replace(':parent_path', $this->parent->path(), self::$path) . '/' . $this->id();
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Update-Data-Stream-Value Update Data Stream Value} endpoint.
 * The timestamp is optional. If ommited, the current server time will be used.
 *
 * @param string $value Value to be updated
 * @param string $timestamp Current Timestamp
 * @return void
 */
  public function updateValue($value, $timestamp = null) {
    $data = array('value' => $value);

    if ($timestamp) {
      $data['timestamp'] = $timestamp;
    }

    $this->client->put($this->path() . '/value', $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#List-Data-Stream-Values List Data Stream Values} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return array List of values from the stream
 */
  public function values($params = array()) {
    $response = $this->client->get($this->path() . '/values', $params);
    return $response->json();
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Data-Stream-Sampling Data Stream Sampling Values} endpoint.
 * Sample values from the stream, sorted in reverse chronological order
 * (most recent values first).
 * This method only work for numeric streams
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return array List of sample values from the stream
 */
  public function sampling($params = array()) {
    $response = $this->client->get($this->path() . '/sampling', $params);
    return $response->json();
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Data-Stream-Stats Data Stream Stats} endpoint.
 * Returns count, min, max, average and standard deviation stats for the
 * values of the stream.
 * This method only works for numeric stream
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return array Stats of the stream
 */
  public function stats($params = array()) {
    $response = $this->client->get($this->path() . '/stats', $params);
    return $response->json();
  }

/**
 * Method for({@link https://m2x.att.com/developer/documentation/v2/device#Post-Data-Stream-Values Post multiple values} endpoint.
 * The `values` parameter is an array with the following format:
 * array(
 *   array('timestamp' => <Time in ISO8601>, 'value' => x),
 *   array('timestamp' => <Time in ISO8601>, 'value' => y)
 * )
 *
 * @param array $values Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return void
 */
  public function postValues($values) {
    $data = array('values' => $values);
    $response = $this->client->post($this->path() . '/values', $data);
  }
}
