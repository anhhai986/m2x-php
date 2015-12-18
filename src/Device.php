<?php

namespace Att\M2X;

use Att\M2X\Stream;
use Att\M2X\StreamCollection;

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
 * @return string
 */
  public function id() {
    return $this->id;
  }

/**
 * Get location details of the device, will return False if no
 * location details are available. Otherwise it will return
 * an array with the details.
 *
 * @link https://m2x.att.com/developer/documentation/v2/device#Read-Device-Location
 *
 * @return array|boolean
 */
  public function location() {
    $response = $this->client->get(self::$path . '/' . $this->id . '/location');
    
    if ($response->statusCode == 204) {
      return False;
    }

    return $response->json();
  }

/**
 * Update the current location of the specified device.
 *
 * @link https://m2x.att.com/developer/documentation/v2/device#Update-Device-Location
 *
 * @param array $data
 * @return Device
 */
  public function updateLocation($data) {
    $response = $this->client->put(self::$path . '/' . $this->id . '/location', $data);
    return $this;
  }

/**
 * Retrieve list of data streams associated with the device
 *
 * @link https://m2x.att.com/developer/documentation/v2/device#List-Data-Streams
 *
 * @return StreamCollection
 */
  public function streams() {
    return new StreamCollection($this->client, $this);
  }

/**
 * Get details of a specific data Stream associated with the device
 *
 * @link https://m2x.att.com/developer/documentation/v2/device#View-Data-Stream
 *
 * @param string $name
 * @return Stream
 */
  public function stream($name) {
    return Stream::getStream($this->client, $this, $name);
  }

/**
 * Update a data stream associated with the Device, if a
 * stream with this name does not exist it gets created.
 *
 * @link https://m2x.att.com/developer/documentation/v2/device#Create-Update-Data-Stream
 *
 * @param string $name
 * @param array $data
 * @return Stream
 */
  public function updateStream($name, $data = array()) {
    return Stream::createStream($this->client, $this, $name, $data);
  }

/**
 * Post Device Updates (Multiple Values to Multiple Streams)
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
 * @link https://m2x.att.com/developer/documentation/v2/device#Post-Device-Updates--Multiple-Values-to-Multiple-Streams
 *
 * @param array $values
 * @return HttpResponse
 */
  public function postUpdates($values) {
    $data = array('values' => $values);
    return $this->client->post($this->path() . '/updates', $data);
  }

/** Post Device Update (Single Value to Multiple Streams)
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
 * @link https://m2x.att.com/developer/documentation/v2/device#Post-Device-Update--Single-Values-to-Multiple-Streams-
 *
 * @param array $values
 * @return HttpResponse
 */
  public function postUpdate($params) {
    return $this->client->post($this->path() . '/update', $params);
  }

/**
 * List Values from all Data Streams of a Device
 *
 * @link https://m2x.att.com/developer/documentation/v2/device#List-Values-from-all-Data-Streams-of-a-Device
 *
 * @param array $params
 * @return array
 */
  public function values($params = array()) {
    $response = $this->client->get($this->path() . '/values', $params);
    return $response->json();
  }

/**
 * Export Values from all Data Streams of a Device
 *
 * @link https://m2x.att.com/developer/documentation/v2/device#Export-Values-from-all-Data-Streams-of-a-Device
 *
 * @param array $params
 * @return HttResponse
 */
  public function valuesExport($params = array()) {
    return $this->client->get($this->path() . '/values/export.csv', $params);
  }

/**
 * Search Values from all Data Streams of a Device
 *
 * @link https://m2x.att.com/developer/documentation/v2/device#Search-Values-from-all-Data-Streams-of-a-Device
 *
 * @param array $params
 * @return array
 */
  public function valuesSearch($params) {
    $response = $this->client->get($this->path() . '/values/search', array(), $params);
    return $response->json();
  }

/**
 * Retrieve list of HTTP requests received lately by the specified
 * device (up to 100 entries).
 *
 * @link https://m2x.att.com/developer/documentation/v2/device#View-Request-Log
 *
 * @return array
 */
  public function log() {
    $response = $this->client->get($this->path() . '/log');
    return current($response->json());
  }
}
