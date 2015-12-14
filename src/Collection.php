<?php

namespace Att\M2X;

class Collection extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = '/collections';

/**
 * The Collection resource properties
 *
 * @var array
 */
  protected static $properties = array(
    'name', 'description', 'parent', 'tags', 'metadata'
  );

/**
 * The resource id for the REST URL
 *
 * @return string
 */
  public function id() {
    return $this->id;
  }

/**
 * Retrieve a list of devices assigned to the specified collection.
 *
 * @link https://m2x.att.com/developer/documentation/v2/collections#List-Devices-from-an-existing-Collection
 *
 * @return DeviceCollection
 */
  public function devices($params = array()) {
    return new DeviceCollection($this->client, $params, true, $this);
  }

/**
 * Get custom metadata of an existing Collection.
 *
 * @link https://m2x.att.com/developer/documentation/v2/collections#Read-Collection-Metadata-Field
 *
 * @return array
 */
  public function metadata() {
    $response = $this->client->get($this->path() . '/metadata');
    return $response->json();
  }

/**
 * Update the custom metadata of the specified Collection.
 *
 * @link https://m2x.att.com/developer/documentation/v2/collections#Update-Collection-Metadata-Field
 *
 * @param array $data
 * @return HttpResponse
 */
  public function updateMetadata($data) {
    return $this->client->put($this->path() . '/metadata', $data);
  }
}
