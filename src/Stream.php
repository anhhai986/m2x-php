<?php

namespace Att\M2X;

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
  protected $device = null;
/**
 * The Stream resource properties
 *
 * @var array
 */
  protected static $properties = array(
  	'name', 'unit', 'type'
  );

/**
 * The resource id for the REST URL
 *
 * @return string
 */
  public function id() {
  	return $this->name;
  }
}
