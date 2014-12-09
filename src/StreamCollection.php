<?php

namespace Att\M2X;

use Att\M2X\Device;
use Att\M2X\Stream;

class StreamCollection extends ResourceCollection {

  protected static $resourceClass = 'Att\M2X\Stream';

/**
 * Boolean flag to define if the resource collection
 * is paginated or not.
 *
 * @var boolean
 */
  protected $paginate = false;

/**
 * The device resource that this collection belongs to
 *
 * @var Device
 */
	public $device = null;

/**
 * Resource collection constructor
 *
 * @param M2X $client
 */
  public function __construct(M2X $client, Device $device, $params = array()) {
    $this->device = $device;

    parent::__construct($client, $params);
  }

/**
 * Return the API path for the query
 *
 * @return void
 */
  protected function path() {
    $class = static::$resourceClass;
    return str_replace(':device', $this->device->id(), $class::$path);
  }

/**
 * Initialize and add a resource to the collection
 *
 * @param integer $i
 * @param array $data
 */
  protected function setResource($i, $data) {
    $this->resources[$i] = new static::$resourceClass($this->client, $this->device, $data);
  }
}
