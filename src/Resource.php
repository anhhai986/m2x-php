<?php

namespace Att\M2X;

abstract class Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  protected static $path = '';

/**
 * The resource properties
 *
 * @var array
 */
  protected static $properties = array();

/**
 * Holds the resource data properties
 *
 * @var array
 */
  protected $data = array();

/**
 * Holds the M2X Client instance
 *
 * @var M2X
 */
  protected $client;

/**
 * Retrieves a list of resources
 *
 * @param M2X $client
 * @return array
 */
  public static function index($client) {
    $response = $client->get(static::$path);

    $data = (array) $response->json();

    $class = get_called_class();

    $resources = array();
    foreach (array_shift($data) as $resourceData) {
      $resources[] = new $class($client, $resourceData);
    }

    return $resources;
  }

/**
 * Retrieves a single resource
 *
 * @param M2X $client
 * @param string $id
 * @return Resource
 */
  public static function get($client, $id) {
    $response = $client->get(static::$path . '/' . $id);

    $class = get_called_class();
    return new $class($client, $response->json());
  }


/**
 * Create object from API data
 *
 * @param M2X $client
 * @param stdClass $data
 */
  public function __construct($client, $data) {
    $this->client = $client;
    $this->loadData($data);
  }

/**
 * Loads the properties into the resource data array
 * from the API data.
 *
 * @param array $data
 * @return void
 */
  public function loadData($data) {
    foreach (static::$properties as $name) {
      $this->data[$name] = $data->{$name};
    }
  }

/**
 * Returns the data of the resource
 *
 * @return array
 */
  public function data() {
    return $this->data;
  }
}
