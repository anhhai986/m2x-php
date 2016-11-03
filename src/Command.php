<?php

namespace Att\M2X;

use Att\M2X\M2X;

class Command extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  public static $path = '/commands';

/**
 * The Device resource properties
 *
 * @var array
 */
  protected static $properties = array(
    'name', 'id', 'url', 'sent_at'
  );

/**
 * The resource id for the REST URL
 *
 * @return string
 */
  public function id() {
    return $this->id;
  }

  public function refresh() {
    $response = $this->client->get($this->path());
    $this->setData($response->json());
  }

}
