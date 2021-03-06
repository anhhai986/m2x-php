<?php

namespace Att\M2X;

use Att\M2X\Device;

class DeviceCollection extends ResourceCollection {

/**
 * Name of the collection. This is used for the envelope key in the API.
 *
 * @var string
 */
  public static $name = 'devices';

/**
 * The resource class used in the collection
 *
 * @var string
 */
  protected static $resourceClass = 'Att\M2X\Device';

/**
 * Holds the flag that decided if this collection is
 * refering to the public devices or not.
 *
 * @var boolean
 */
  protected $catalog = false;

/**
 * The parent resource that this collection belongs to
 *
 * @var Resource
 */
  public $parent = null;

/**
 * Device collection constructor
 *
 * @param M2X $client client api
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @param boolean $catalog Search in the catalog
 * @param resource $parent Parent resource the device belongs to
 */
  public function __construct(M2X $client, $params = array(), $catalog = false, $parent = null) {
    $this->catalog = $catalog;

    if ($parent) {
      $this->parent = $parent;
      $this->catalog = false;
    }

    parent::__construct($client, $params);
  }

/**
 * Return the API path for the query
 *
 * @return void
 */
  protected function path() {
    if ($this->parent) {
      return $this->parent->path() . '/devices';
    }

    $class = static::$resourceClass;
    $path = $class::$path;
    if ($this->catalog) {
      $path .= '/catalog';
    }
    return $path;
  }
}
