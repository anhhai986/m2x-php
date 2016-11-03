<?php

namespace Att\M2X;

use Att\M2X\Command;

class CommandCollection extends ResourceCollection {

/**
 * Name of the collection. This is used for the envelope key in the API.
 *
 * @var string
 */
  public static $name = 'commands';

/**
 * The resource class used in the collection
 *
 * @var string
 */
  protected static $resourceClass = 'Att\M2X\Command';

/**
 * Boolean flag to define if the resource collection
 * is paginated or not.
 *
 * @var boolean
 */
  protected $paginate = true;

/**
 * The parent resource that this collection belongs to
 *
 * @var Resource
 */
  public $parent = null;

/**
 * Resource collection constructor
 *
 * @param M2X $client
 */
  public function __construct(M2X $client, $params = array(), $parent = null) {
    if ($parent) {
      $this->parent = $parent;
    }
    parent::__construct($client, $params);
  }

/**
 * Return the API path for the query
 *
 * @return void
 */
  protected function path() {
     if ($this->parent) {
       return $this->parent->path() . '/commands';
     }
     $class = static::$resourceClass;
     $path = $class::$path;
     return $path;
   }
}
