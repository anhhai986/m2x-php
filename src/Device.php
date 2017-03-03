<?php

namespace Att\M2X;

use Att\M2X\Stream;
use Att\M2X\StreamCollection;

/**
 * Wrapper for {@link https://m2x.att.com/developer/documentation/v2/device M2X Device} API
 */
class Device extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = '/devices';

/**
 * The Device resource properties
 *
 * @var array
 */
  protected static $properties = array(
    'name', 'description', 'visibility', 'tags'
  );

/**
 * The resource id for the REST URL
 *
 * @return string Device ID
 */
  public function id() {
    return $this->id;
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Read-Device-Location Read Device Location} endpoint.
 * It will get location details of the device, will return False if no
 * location details are available. Otherwise it will return
 * an array with the details.
 *
 * @return array|boolean Most recently logged location of the Device, see M2X API docs for details
 */
  public function location() {
    $response = $this->client->get(self::$path . '/' . $this->id . '/location');

    if ($response->statusCode == 204) {
      return False;
    }

    return $response->json();
  }

/**
 * Method for{@link https://m2x.att.com/developer/documentation/v2/device#Update-Device-Location Update Device Location} endpoint.
 *
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Device The API response, see M2X API docs for details
 */
  public function updateLocation($data) {
    $response = $this->client->put(self::$path . '/' . $this->id . '/location', $data);
    return $this;
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Read-Device-Location-History Read location history} endpoint.
 *
 * @param  $data optional Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return array Location history of the Device
 */
  public function locationHistory($data) {
    $response = $this->client->get(self::$path . '/' . $this->id . '/location/waypoints', $data);
    return $response->json();
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Delete-Location-History Delete location history} endpoint.
 *
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Device The API response, see M2X API docs for details
 */
  public function deleteLocationHistory($data) {
    $response = $this->client->delete(self::$path . '/' . $this->id . '/location/waypoints', $data);
    return $this;
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#List-Data-Streams List Data Streams} endpoint.
 *
 * @return StreamCollection List of data streams associated with this device as StreamCollection objects
 */
  public function streams() {
    return new StreamCollection($this->client, $this);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#View-Data-Stream View Data Stream} endpoint.
 *
 * @param string $name The name of the Stream being retrieved
 * @return Stream The matching Stream
 */
  public function stream($name) {
    return Stream::getStream($this->client, $this, $name);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Create-Update-Data-Stream Create/Update data stream} endpoint.
 *
 * @param string $name Name of the stream to be updated
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return Stream The Stream being updated
 */
  public function updateStream($name, $data = array()) {
    return Stream::createStream($this->client, $this, $name, $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Post-Device-Updates--Multiple-Values-to-Multiple-Streams Post Device Updates (Multiple Values to Multiple Streams)} endpoint.
 *
 * This method allows posting multiple values to multiple streams
 * belonging to a device and optionally, the device location.
 *
 * All the streams should be created before posting values using this method.
 *
 * The `values` parameter is an array with the following format:
 * array(
 *   'stream_a' => array(
 *     array('timestamp' => <Time in ISO8601>, 'value' => x),
 *     array('timestamp' => <Time in ISO8601>, 'value' => y)
 *   ),
 *   'stream_b' => array(
 *     array('timestamp' => <Time in ISO8601>, 'value' => t),
 *     array('timestamp' => <Time in ISO8601>, 'value' => g)
 *   )
 * )
 *
 * @param array $values The values being posted, formatted according to the API docs
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function postUpdates($values) {
    $data = array('values' => $values);
    return $this->client->post($this->path() . '/updates', $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Post-Device-Update--Single-Values-to-Multiple-Streams- Post Device Update (Single Value to Multiple Streams)} endpoint.
 *
 * This method allows posting a single value to multiple streams
 * belonging to a device and optionally, the device's location.
 *
 * All the streams should be created before posting values using this method.
 *
 * The `params` parameter accepts a Hash which can contain the following keys:
 *   - values:    A Hash in which the keys are the stream names and the values
 *                hold the stream values.
 *   - location:  (optional) A hash with the current location of the specified
 *                device.
 *   - timestamp: (optional) The timestamp for all the passed values and
 *                location. If ommited, the M2X server's time will be used.
 *
 *      array(
 *         'values' => array(
 *             'temperature' => 30,
 *             'humidity'    => 80
 *         ),
 *         'location' => array(
 *           'name'      => "Storage Room",
 *           'latitude'  => -37.9788423562422,
 *           'longitude' => -57.5478776916862,
 *           'elevation' => 5
 *         )
 *      )
 *
 * @param array $params The values being posted, formatted according to the API docs
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function postUpdate($params) {
    return $this->client->post($this->path() . '/update', $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#List-Values-from-all-Data-Streams-of-a-Device List Values from all Data Streams} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return array The API response, see M2X API docs for details
 */
  public function values($params = array()) {
    $response = $this->client->get($this->path() . '/values', $params);
    return $response->json();
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Export-Values-from-all-Data-Streams-of-a-Device Export Values from all Data Streams} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttResponse The API response, see M2X API docs for details
 */
  public function valuesExport($params = array()) {
    return $this->client->get($this->path() . '/values/export.csv', $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Search-Values-from-all-Data-Streams-of-a-Device Search Values from all Data Streams} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return array The API response, see M2X API docs for details
 */
  public function valuesSearch($params) {
    $response = $this->client->get($this->path() . '/values/search', array(), $params);
    return $response->json();
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#View-Request-Log View Request Log} endpoint. (up to 100 latest entries).
 *
 * @return array Most recent API requests made against this Device
 */
  public function log() {
    $response = $this->client->get($this->path() . '/log');
    return current($response->json());
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/commands#Device-s-List-of-Received-Commands List of Recieved Commands} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return CommandCollection The API response, see M2X API docs for details
 */
  public function commands($params = array()) {
  return new CommandCollection($this->client, $params, $this);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/commands#Device-s-View-of-Command-Details Device view of Command Details} endpoint.
 *
 * @param string $id ID of the Command to retrieve
 * @return Command The API response, see M2X API docs for details
 */
  public function command($id) {
     return Command::get($this->client , $id);
  }


/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/commands#Device-Marks-a-Command-as-Rejected Device Marks Command as rejected} endpoint.
 *
 * @param Command $command ID of the Command being marked as rejected
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function reject($command, $data = null) {
     return $this->client->post($this->path() . $command->path() . '/reject', $data);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/commands#Device-Marks-a-Command-as-Processed Device marks Command as processed} endpoint.
 *
 * @param Command $command ID of the Command being marked as processed
 * @param array $data Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
 public function process($command, $data = null) {
     return $this->client->post($this->path() . $command->path() . '/process', $data);
 }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Read-Device-Metadata Read Device Metadata} endpoint.
 * Get custom metadata of an existing Device.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function metadata($params = array()) {
    return $this->client->get($this->path() . '/metadata', $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Read-Device-Metadata-Field Read Device Metadata Field} endpoint.
 * Get the value of a single custom metadata field from an existing Device.
 *
 * @param string $key The metadata field to be read
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function metadataField($key, $params = array()) {
    return $this->client->get($this->path() . '/metadata/' . $key, $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Update-Device-Metadata Update Device Metadata} endpoint.
 *
 * @param array $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function updateMetadata($params = array()) {
    return $this->client->put($this->path() . '/metadata', $params);
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Update-Device-Metadata-Field Update Device Metadata Field} endpoint.
 *
 * @param string $key The metadata field to be updated
 * @param string $value The value to be updated
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function updateMetadataField($key, $value) {
      return $this->client->put($this->path() . '/metadata/' . $key , array('value' => $value));
  }

/**
 * Method for {@link https://m2x.att.com/developer/documentation/v2/device#Update-Data-Stream-Values Update Data Stream Values} endpoint.
 *
 * @param string $name Stream name to be updated
 * @param array  $params Query parameters passed as keyword arguments. View M2X API Docs for listing of available parameters.
 * @return HttpResponse The API response, see M2X API docs for details
 */
  public function updateSingleStream($name, $params = array()) {
    return $this->client->put($this->path() . '/streams/' . $name . '/value' , $params);
  }

}
