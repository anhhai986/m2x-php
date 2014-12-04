<?php

namespace Att\M2X;

class Key extends Resource {

/**
 * REST path of this resource
 *
 * @var string
 */
	protected static $path = '/keys';

/**
 * Name of the key
 *
 * @var string
 */
	public $name;

/**
 * Key of the key
 *
 * @var string
 */
	public $key;

/**
 * Create object from API data
 *
 * @param M2X $client
 * @param stdClass $data
 */
	public function __construct($client, $data) {
		$this->name = $data->name;
		$this->key = $data->key;
	}
}