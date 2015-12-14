<?php

namespace Att\M2X;

use Att\M2X\Distribution;

class DistributionCollection extends ResourceCollection {

/**
 * Name of the collection. This is used for the envelope key in the API.
 *
 * @var string
 */
  public static $name = 'distributions';

/**
 * The resource class used in the collection
 *
 * @var string
 */
  protected static $resourceClass = 'Att\M2X\Distribution';

}
