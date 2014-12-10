<?php

namespace Att\M2X;

class Distribution extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = '/distributions';

/**
 * The Key resource properties
 *
 * @var array
 */
  protected static $properties = array(
  	'name'
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
