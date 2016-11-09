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
 * Add the device to the collection.
 *
 * @link https://m2x.att.com/developer/documentation/v2/collections#Add-device-to-collection
 *
 * @param string $device_id
 * @return HttpResponse
 */
  public function addDevice($device_id) {
    return $this->client->put($this->path() . '/devices/' . $device_id);
  }

/**
 * Remove the device from the collection.
 *
 * @link https://m2x.att.com/developer/documentation/v2/collections#Remove-device-from-collection
 *
 * @param string $device_id
 * @return HttpResponse
 */
  public function removeDevice($device_id) {
    return $this->client->delete($this->path() . '/devices/' . $device_id);
  }

/**
 * Get custom metadata of an existing Collection.
 *
 * @link https://m2x.att.com/developer/documentation/v2/collections#Read-Collection-Metadata
 *
 * @param array $params
 * @return HttpResponse
 */
  public function metadata($params = array()) {
    return $this->client->get($this->path() . '/metadata', $params);
  }

/**
 * Update the custom metadata of the specified Collection.
 *
 * @link https://m2x.att.com/developer/documentation/v2/collections#Update-Collection-Metadata
 *
 * @param array $data
 * @return HttpResponse
 */
  public function updateMetadata($data = array()) {
    return $this->client->put($this->path() . '/metadata', $data);
  }

/**
 * Get Collection Metadata Field.
 *
 * Get the value of a single custom metadata field from an existing Collection.
 *
 * @link https://m2x.att.com/developer/documentation/v2/collections#Read-Collection-Metadata-Field
 *
 * @param string $key
 * @param array $params
 * @return HttpResponse
 */
  public function metadataField($key, $params = array()) {
    return $this->client->get($this->path() . '/metadata/' . $key, $params);
  }

/**
 * Update Collection Metadata Field.
 *
 * @link https://m2x.att.com/developer/documentation/v2/collections#Update-Collection-Metadata-Field
 *
 * @param string $key
 * @param string $value
 * @return HttpResponse
 */
  public function updateMetadataField($key, $value) {
      return $this->client->put($this->path() . '/metadata/' . $key , array('value' => $value));
  }

}
