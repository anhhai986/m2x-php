<?php

class Batches extends CurlRequest {

/**
 * The base path to the resource, this will be appeneded
 * to the api endpoint.
 *
 * @var string
 */
  const RESOURCE_BASE = "/batches";

  public function __construct($endpoint, $api_key) {
    parent::__construct($endpoint, $api_key);
  }

/**
 * Retrieve the list of batches accessible by the authenticated API key that meet the search criteria.
 *
 * @param $query is Text to search (optional)
 * @param $filters
 * @return Response
 */
  public function search($query = null, $filters = array()) {
    if(!is_null($query)) {
      $filters['q'] = $query;
    }
    return $this->get(self::RESOURCE_BASE, $filters);
  }


/**
 * Retrieve the list of datasources accessible by the authenticated API key that meet the search criteria.
 *
 * @param $id is the batch id
 * @param $query is Text to search (optional)
 * @param $filters
 * @return Response
 */
  public function search_datasources($id, $query = null, $filters = array()) {
    if(!is_null($query)) {
      $filters['q'] = $query;
    }
    return $this->get(self::RESOURCE_BASE . "/$id/datasources", $filters);
  }
}
