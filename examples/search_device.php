<?php

include '../vendor/autoload.php';

use Att\M2X\M2X;

CONST API_KEY = "<API-KEY>";

try {
  $m2x = new M2X(API_KEY);
  $data = array("status" => "enabled", "limit" => "1");
  $response = $m2x->searchDevices($data);
  echo  $response->raw();
} catch (M2XException $ex) {
  echo 'Error: ' . $ex->getMessage();
  echo $ex->response->raw;
  break;
}
