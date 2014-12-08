<?php

namespace Att\M2X;

abstract class ResourceCollection implements \Iterator {

/**
 * Holds the instances of the resources 
 *
 * @var array
 */
  protected $resources = array();

/**
 * Holds the client instance
 *
 * @var M2X
 */
  protected $client = null;

/**
 * Parameters used in the query
 * 
 * @var array
 */
  protected $params = array();

/**
 * Total amount of resources
 *
 * @var integer
 */
  protected $total = null;

/**
 * Total amount of pages
 *
 * @var integer
 */
  protected $pages = null;

/**
 * The current page in the result set
 *
 * @var integer
 */
  protected $currentPage = 1;

/**
 * Number of resources to fetch per page
 *
 * @var integer
 */
  protected $limit = null;

/**
 * Current position in the iterator
 *
 * @var integer
 */
  protected $position = 0;

/**
 * Resource collection constructor
 *
 * @param M2X $client
 */
  public function __construct(M2X $client, $params = array()) {
    $this->client = $client;
    $this->params = $params;

    $this->fetch();
  }

  public function fetch($page = 1) {
    $params = array_merge($this->params, array('page' => $page));

    $response = $this->client->get($this->path(), $params);
    $data = $response->json();

    $this->total = $data['total'];
    $this->pages = $data['pages'];
    $this->limit = $data['limit'];
    $this->currentPage = $data['current_page'];

    foreach ($data['devices'] as $i => $deviceData) {
      $position = $i + ($this->currentPage - 1) * $this->limit;
      $this->setResource($position, $deviceData);
    }
  }

  protected function setResource($i, $data) {
    $this->resources[$i] = new static::$resourceClass($this->client, $data);
  }

/**
 * Return the API path for the query
 *
 * @return void
 */
  protected function path() {
    $class = static::$resourceClass;
    return $class::$path;
  }

  public function total() {
    return $this->total;
  }

/**
 * this method takes the pointer back to the beginning
 * of the dataset to restart the iteration
 *
 * @return void
 */
    public function rewind() {
      $this->position = 0;
    }
 
 /**
  * This method returns the resource at the current
  * position in the dataset.
  *
  * @return void
  */
    public function current() {
      return $this->resources[$this->position];
    }
 
 /**
  * Returns the current value of the pointer
  *
  * @return integer
  */
    public function key() {
      return $this->position;
    }
 
 /**
  * Moves the pointer to the next resource in the dataset
  *
  * @return void
  */
    public function next() {
      ++$this->position;
    }
 
 /**
  * Returns a boolean indicating if there is a resource
  * at the current position in the dataset
  *
  * @return boolean
  */
    public function valid() {
      if (isset($this->resources[$this->position])) {
        return true;
      }

      if ($this->position >= $this->total) {
        return false;
      }

      $this->fetch($this->currentPage + 1);
      return isset($this->resources[$this->position]);
    }
}