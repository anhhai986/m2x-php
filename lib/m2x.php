<?php

require_once 'm2x'.DIRECTORY_SEPARATOR.'response.php';
require_once 'm2x'.DIRECTORY_SEPARATOR.'curl_exception.php';
require_once 'm2x'.DIRECTORY_SEPARATOR.'curl_request.php';
require_once 'm2x'.DIRECTORY_SEPARATOR.'feeds.php';
require_once 'm2x'.DIRECTORY_SEPARATOR.'blueprints.php';
require_once 'm2x'.DIRECTORY_SEPARATOR.'batches.php';
require_once 'm2x'.DIRECTORY_SEPARATOR.'datasources.php';

class M2X {

/**
 * Version of the API
 */
  const VERSION = "1.0.0";

/**
 * The default endpoint that will be used for all API calls
 */
  const ENDPOINT = "http://api-m2x.att.com/v1";

/**
 * Holds API Key that will be used for authentication
 *
 * @var string
 */
  private $api_key = '';

/**
 * Holds the endpoint that will be used for each call
 *
 * @var string
 */
  private $endpoint = '';

/**
 * Construct the main API instance that can spawn off resource instances.
 *
 * @param string $api_key the authentication key
 * @param string $endpoint the full url to the endpoint (optional)
 */
  public function __construct($api_key, $endpoint = self::ENDPOINT) {
    $this->api_key = $api_key;
    $this->endpoint = $endpoint;
  }

/**
 * Changes the active endpoint for an API instance
 *
 * @param string $endpoint
 * @return void
 */
  public function change_endpoint($endpoint) {
    $this->endpoint = $endpoint;
  }

/**
 * Creates an API instance object for the Feed resource
 *
 * @return Feeds
 */
  public function feeds() {
    return new Feeds($this->endpoint, $this->api_key);
  }

/**
 * Creates an API instance object for the Batch resource
 *
 * @return Batches
 */
  public function batches() {
    return new Batches($this->endpoint, $this->api_key);
  }

/**
 * Creates an API instance object for the Blueprint resource
 *
 * @return Blueprints
 */
  public function blueprints() {
    return new Blueprints($this->endpoint, $this->api_key);
  }

/**
 * Creates an API instance object for the Datasource resource
 *
 * @return Blueprints
 */
  public function datasources() {
    return new Datasources($this->endpoint, $this->api_key);
  }
} 
