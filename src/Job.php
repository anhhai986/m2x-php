<?php

namespace Att\M2X;

/**
 * Wrapper for {@link https://m2x.att.com/developer/documentation/v2/jobs M2X Job} API
 */
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
 * @return string Job ID
 */
  public function id() {
    return $this->id;
  }

/**
 * Updating a job is not allowed
 *
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Resource Resource to be updated
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
 * @param M2X $client Client API
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return void
 */
  public static function create($client, $data = array()) {
    throw new \BadMethodCallException('Not implemented');
  }
}
