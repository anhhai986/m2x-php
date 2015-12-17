<?php

namespace Att\M2X;

class Job extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = '/jobs';

/**
 * The Collection resource properties
 *
 * @var array
 */
  protected static $properties = array();

/**
 * The resource id for the REST URL
 *
 * @return string
 */
  public function id() {
    return $this->id;
  }

/**
 * Updating a job is not allowed
 *
 * @param array $data
 * @return Resource
 */
  public function update($data = array()) {
    throw new \BadMethodCallException('Not implemented');
  }

/**
 * Deleting a job is not allowed
 *
 * @return void
 */
  public function delete() {
    throw new \BadMethodCallException('Not implemented');
  }

/**
 * Creating jobs is not allowed
 *
 * @param M2X $client
 * @param string $id
 * @return void
 */
  public static function create($client, $data = array()) {
    throw new \BadMethodCallException('Not implemented');
  }
}
