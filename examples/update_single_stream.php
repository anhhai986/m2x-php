<?php

include '../vendor/autoload.php';

use Att\M2X\M2X;
use Att\M2X\Error\M2XException;

CONST API_KEY = "<API-KEY>";
CONST DEVICE_ID = "<DEVICE-ID>";
CONST STREAM_NAME = "<YOUR-STREAM-NAME-HERE>";
CONST STREAM_VALUE = "<YOUR-STREAM-VALUE-HERE>";

$m2x = new M2X(API_KEY);

try {
  $device = $m2x->device(DEVICE_ID);
  // Update Single Stream API
  $response = $device->updateSingleStream(STREAM_NAME, array(
    "value" => STREAM_VALUE
  ));
  if ($response->statusCode == 202) {
     echo "Update single value stream for device is Successful\r\n.";
   }
} catch (M2XException $ex) {
  echo $ex->getMessage();
  echo $ex->response->raw;
}
