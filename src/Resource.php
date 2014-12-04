<?php

namespace Att\M2X;

abstract class Resource {

/**
 * Retrieves a list of resources
 *
 * @param M2X $client
 * @return array
 */
	public static function index($client) {
		$response = $client->get(static::$path);

		$data = (array) $response->json();

		$class = get_called_class();

		$resources = array();
		foreach (array_shift($data) as $resourceData) {
			$resources[] = new $class($client, $resourceData);
		}

		return $resources;
	}

/**
 * Retrieves a single resource
 *
 * @param M2X $client
 * @param string $id
 * @return Resource
 */
	public static function get($client, $id) {
		$response = $client->get(static::$path . '/' . $id);

		$class = get_called_class();
		return new $class($client, $response->json());
	}
}