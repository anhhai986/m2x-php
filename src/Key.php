<?php

namespace Att\M2X;

class Key extends Resource {

/**
 * REST path of the resource
 *
 * @var string
 */
  protected static $path = '/keys';

/**
 * The Key resource properties
 *
 * @var array
 */
  protected static $properties = array(
    'name', 'key', 'master', 'stream', 'expires_at',
    'expired', 'origin', 'permissions', 'device_access'
  );

}
