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
    'name', 'description', 'visibility'
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
 * Retrieve a list of devices associated with the distribution.
 *
 * @link https://m2x.att.com/developer/documentation/v2/distribution#list-devices-from-an-existing-distribution
 *
 * @return DeviceCollection
 */
  public function devices() {
    return new DeviceCollection($this->client, array(), false, $this);
  }

/**
 * Add a new device to an existing distribution.
 *
 * @link https://m2x.att.com/developer/documentation/v2/distribution#add-device-to-an-existing-distribution
 *
 * @param string $serial
 * @return Device
 */
  public function addDevice($serial) {
    $data = array('serial' => $serial);
    $response = $this->client->post($this->path() . '/devices', $data);
    return new Device($this->client, $response->json());
  }

/**
 * Retrieve list of data streams associated with the distribution
 *
 * @return StreamCollection
 */
  public function streams() {
    return new StreamCollection($this->client, $this);
  }

/**
 * Get details of a specific data Stream associated with the
 * distribution.
 *
 * @param string $name
 * @return Stream
 */
  public function stream($name) {
    return Stream::getStream($this->client, $this, $name);
  }

/**
 * Update a data stream associated with the Distribution, if a
 * stream with this name does not exist it gets created.
 *
 * @param string $name
 * @param array $data
 * @return Stream
 */
  public function updateStream($name, $data = array()) {
    return Stream::createStream($this->client, $this, $name, $data);
  }

/**
 * Get custom metadata of an existing Distribution Device.
 *
 * @link https://m2x.att.com/developer/documentation/v2/distribution#Read-Distribution-Metadata
 *
 * @param array $params
 * @return HttpResponse
 */
  public function metadata($params = array()) {
    return $this->client->get($this->path() . '/metadata', $params);
  }

/**
 * Get the value of a single custom metadata field from an existing Distribution Device.
 *
 * @link https://m2x.att.com/developer/documentation/v2/distribution#Read-Distribution-Metadata-Field
 *
 * @param string $key
 * @param array $params
 * @return HttpResponse
 */
  public function metadataField($key, $params = array()) {
    return $this->client->get($this->path() . '/metadata/' . $key, $params);
  }

/**
 * Update metadata of a distribution device.
 *
 * @link https://m2x.att.com/developer/documentation/v2/distribution#Update-Distribution-Metadata
 *
 * @param array $params
 * @return HttpResponse
 */
  public function updateMetadata($params = array()) {
    return $this->client->put($this->path() . '/metadata', $params);
  }

/**
 * Update distribution device metadata field.
 *
 * @link https://m2x.att.com/developer/documentation/v2/distribution#Update-Distribution-Metadata-Field
 *
 * @param string $key
 * @param string $value
 * @return HttpResponse
 */
  public function updateMetadataField($key, $value) {
      return $this->client->put($this->path() . '/metadata/' . $key , array('value' => $value));
  }

}
