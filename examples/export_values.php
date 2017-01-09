<?php

include '../vendor/autoload.php';

use Att\M2X\M2X;
use Att\M2X\Error\M2XException;

$api_key = "<API KEY HERE>";
$device_id = "<DEVICE>";

$m2x = new M2X($api_key);

try {
  //Export Values from all Data streams of a device
  $params = array(
    "limit" => 5 //Maximum number of values to return (optional).
  );
  $device = $m2x->device($device_id);
  $response = $device->valuesExport($params);
  $response_headers = $response->headers();

  $location = $response_headers["Location"];
  echo "The Job Location is:" . $location . "\n";
  $jobid = end(split("/", $location));

  while(true) {
    $response = $m2x->job($jobid);
    $state = $response->data()["state"];

    if ($state == "complete") {
      echo "The job has been completed! You can download the result from " . $response->data()["result"]["url"] . "\n";
      break;
    } elseif ($state == "failed") {
      echo "Job has failed to complete \n";
      break;
    } else {
      echo "Job state is " . $state . ", waiting for completion...\n";
      sleep(5);
    }
  }
}
catch (M2XException $ex) {
  echo $ex->getMessage();
  echo $ex->response->raw;
}
