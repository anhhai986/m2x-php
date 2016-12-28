<?php

include '../vendor/autoload.php';

use Att\M2X\M2X;
use Att\M2X\Error\M2XException;

$api_key = "<API KEY HERE>";

$m2x = new M2X($api_key);

try {
  // Iterate over list of devices
  $params = array(
    "limit" => 3 //Variable to limit the number of devices per page.
  );

  $devices = $m2x->devices($params);
  echo "Total Number of Devices:" . $devices->count() . "\n";
  while($devices->valid()) {
    echo "Current Page:" . $devices->page() . "\t";
    $device = $devices->current();
    $deviceName = $device->name;
    echo "deviceName:" . $deviceName . "\n";
    $devices->next();
  }
}
catch (M2XException $ex) {
  echo $ex->getMessage();
  echo $ex->response->raw;
  break;
}
