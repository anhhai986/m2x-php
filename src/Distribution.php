<?php
/**
 * Method for Wrapper for {@link https://m2x.att.com/developer/documentation/v2/distribution M2X Distribution} API 
 */
namespace Att\M2X;

class Distribution extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = '/distributions';

/**
 * Method for The Key resource properties
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
 * Method for {@link https://m2x.att.com/developer/documentation/v2/distribution#list-devices-from-an-existing-distribution List Devices from a Distribution} endpoint.
 *
 * @return DeviceCollection List of Devices associated with this Distribution.
 */
  public function devices() {
    return new DeviceCollection($this->client, array(), false, $this);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/distribution#add-device-to-an-existing-distribution Add Device to a Distribution} endpoint.
 *
 * @param string $serial The unique (account-wide) serial for the DistributionDevice being added to the Distribution
 * @return Device The newly created DistributionDevice
 */
  public function addDevice($serial) {
    $data = array('serial' => $serial);
    $response = $this->client->post($this->path() . '/devices', $data);
    return new Device($this->client, $response->json());
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#List-Data-Streams} endpoint.
 *
 * @return StreamCollection List of data streams associated with the distribution
 */
  public function streams() {
    return new StreamCollection($this->client, $this);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#View-Data-Stream View Data Stream} endpoint.
 *
 * @param string $name Name of the stream for its data
 * @return Stream The data associated with the stream
 */
  public function stream($name) {
    return Stream::getStream($this->client, $this, $name);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Create-Update-Data-Stream Create/Update Data Stream} endpoint.
 *
 * @param string $name Name of the the stream
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Stream The Stream being updated
 */
  public function updateStream($name, $data = array()) {
    return Stream::createStream($this->client, $this, $name, $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/distribution#Read-Distribution-Metadata Read Distribution Metadata} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function metadata($params = array()) {
    return $this->client->get($this->path() . '/metadata', $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/distribution#Read-Distribution-Metadata-Field Read Distribution Metadata Field} endpoint.
 *
 * @param string $key The metadata field to be read
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function metadataField($key, $params = array()) {
    return $this->client->get($this->path() . '/metadata/' . $key, $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/distribution#Update-Distribution-Metadata Update Distribution Metadata} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function updateMetadata($params = array()) {
    return $this->client->put($this->path() . '/metadata', $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/distribution#Update-Distribution-Metadata-Field Update Distribution Metadata Field} endpoint.
 *
 * @param string $key The metadata field to be updated
 * @param string $value The value to be updated
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function updateMetadataField($key, $value) {
      return $this->client->put($this->path() . '/metadata/' . $key , array('value' => $value));
  }

}
