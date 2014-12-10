<?php

namespace Att\M2X;

use Att\M2X\Stream;
use Att\M2X\StreamCollection;
use Att\M2X\Trigger;
use Att\M2X\TriggerCollection;

class Device extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = '/devices';

/**
 * The Key resource properties
 *
 * @var array
 */
  protected static $properties = array(
  	'name', 'description', 'visibility', 'groups'
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
 * @return StreamCollection
 */
  public function streams() {
    return new StreamCollection($this->client, $this);
  }

/**
 * Get details of a specific data Stream associated with the device
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
 * @param string $name
 * @param array $data
 * @return Stream
 */
  public function updateStream($name, $data = array()) {
    return Stream::createStream($this->client, $this, $name, $data);
  }

/**
 * Retrieve list of triggers associated with the device
 *
 * @return TriggerCollection
 */
  public function triggers() {
    return new TriggerCollection($this->client, $this);
  }

/**
 * Get details of a specific trigger associated with the device
 *
 * @param string $id
 * @return Trigger
 */
  public function trigger($id) {
    return Trigger::getTrigger($this->client, $this, $id);
  }

/**
 * Create a trigger associated with the Device.
 *
 * @param array $data
 * @return Stream
 */
  public function createTrigger($data = array()) {
    return Trigger::createTrigger($this->client, $this, $data);
  }
}
