<?php

namespace Att\M2X;

use Att\M2X\Collection;

class CollectionCollection extends ResourceCollection {

/**
 * Name of the collection. This is used for the envelope key in the API.
 *
 * @var string
 */
  public static $name = 'collections';

/**
 * This collections endpoint is not a paginated resource.
 *
 * @var boolean
 */
  protected $paginate = false;

/**
 * The resource class used in the collection
 *
 * @var string
 */
  protected static $resourceClass = 'Att\M2X\Collection';
}
