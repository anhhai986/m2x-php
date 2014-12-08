<?php

namespace Att\M2X;

class Device extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = '/devices';

/**
 * The Key resource properties
 *
 * @var array
 */
  protected static $properties = array(
  	'name', 'description', 'visibility', 'groups'
  );

/**
 * The resource id for the REST URL
 *
 * @return string
 */
  public function id() {
  	return $this->id;
  }

}
