<?php

namespace Att\M2X;

/**
 * Wrapper for {@link https://m2x.att.com/developer/documentation/v2/collections M2X Collections} API 
 */
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
 * @return string Collection ID
 */
  public function id() {
    return $this->id;
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#List-Devices-from-an-existing-Collection List Devices from an existing collection} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return DeviceCollection List of Device objects
 */
  public function devices($params = array()) {
    return new DeviceCollection($this->client, $params, true, $this);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#Add-device-to-collection Add a device to the collection} endpoint.
 *
 * @param string $device_id ID of the Device being added to Collection
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function addDevice($device_id) {
    return $this->client->put($this->path() . '/devices/' . $device_id);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#Remove-device-from-collection Remove a device from the collection} endpoint.
 *
 * @param string $device_id ID of the Device being removed from Collection
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function removeDevice($device_id) {
    return $this->client->delete($this->path() . '/devices/' . $device_id);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#Read-Collection-Metadata Read Collection metadata of a Collection} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse All of the user defined metadata associated with the resource
 */
  public function metadata($params = array()) {
    return $this->client->get($this->path() . '/metadata', $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#Update-Collection-Metadata Update collection metadata of a Collection} endpoint.
 *
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function updateMetadata($data = array()) {
    return $this->client->put($this->path() . '/metadata', $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#Read-Collection-Metadata-Field Get Collection Metadata field} endpoint.
 *
 * Get the value of a single custom metadata field from an existing Collection.
 *
 * @param string $key The metadata field to be read
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function metadataField($key, $params = array()) {
    return $this->client->get($this->path() . '/metadata/' . $key, $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/collections#Update-Collection-Metadata-Field Update Collection Metadata Field} endpoint.
 *
 * @param string $key The metadata field to be updated
 * @param string $value The value to update
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function updateMetadataField($key, $value) {
      return $this->client->put($this->path() . '/metadata/' . $key , array('value' => $value));
  }

}
