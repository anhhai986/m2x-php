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
}
