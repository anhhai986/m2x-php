<?php

namespace Att\M2X;

use Att\M2X\M2X;
use Att\M2X\Device;

class Stream extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = '/devices/:device/streams';

/**
 * The device resource that this stream belongs to
 *
 * @var Device
 */
  public $device = null;
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
 * @param string $id
 * @return void
 */
  public static function create($client, $data = array()) {
    throw new \BadMethodCallException('Not implemented, use Stream::createStream() instead.');
  }

/**
 * Retrieves a single resource
 *
 * @param Device $device
 * @param string $id
 * @return Resource
 */
  public static function getStream(M2X $client, Device $device, $id) {
    $response = $client->get(str_replace(':device', $device->id(), static::$path) . '/' . $id);

    $class = get_called_class();
    return new $class($client, $device, $response->json());
  }

/**
 * Create or update a stream resource
 *
 * @param M2X $client
 * @param Device $device
 * @param string $name
 * @param array $data
 * @return Stream
 */
  public static function createStream(M2X $client, Device $device, $name, $data) {
    $path = str_replace(':device', $device->id(), static::$path) . '/' . $name;
    $response = $client->put($path, $data);

    if ($response->statusCode == 204) {
      return self::getStream($client, $device, $name);
    }

    return new self($client, $device, $response->json());
  }

/**
 * Create object from API data
 *
 * @param M2X $client
 * @param Device $device
 * @param stdClass $data
 */
  public function __construct(M2X $client, Device $device, $data) {
    $this->device = $device;
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
 * @return string
 */
  public function path() {
    return str_replace(':device', $this->device->id(), self::$path) . '/' . $this->id();
  }

/**
 * Update the current value of the stream. The timestamp is optional.
 * If ommited, the current server time will be used.
 *
 * @param string $value
 * @param string $timestamp
 * @return void
 */
  public function updateValue($value, $timestamp = null) {
    $data = array('value' => $value);

    if ($timestamp) {
      $data['at'] = $timestamp;
    }

    $this->client->put($this->path() . '/value', $data);
  }

/**
 * List values from the stream, sorted in reverse chronological order
 * (most recent value first).
 *
 * @param array $params
 * @return array
 */
  public function values($params = array()) {
    $response = $this->client->get($this->path() . '/values', $params);
    return $response->json();
  }

/**
 * Sample values from the stream, sorted in reverse chronological order
 * (most recent values first).
 *
 * This method only work for numeric streams
 *
 * @param array $params
 * @return array
 */
  public function sampling($params = array()) {
    $response = $this->client->get($this->path() . '/sampling', $params);
    return $response->json();
  }

/**
 * Return count, min, max, average and standard deviation stats for the
 * values of the stream.
 *
 * This method only works for numeric stream
 *
 * @param array $params
 * @return array
 */
  public function stats($params = array()) {
    $response = $this->client->get($this->path() . '/stats', $params);
    return $response->json();
  }
}
