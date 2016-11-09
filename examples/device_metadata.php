<?php

include '../vendor/autoload.php';

use Att\M2X\M2X;
use Att\M2X\Error\M2XException;

CONST API_KEY = "<API-KEY>";
CONST DEVICE_ID = "<DEVICE-ID>";
CONST COLLECTION_ID = "<COLLECTION-ID>";
CONST DISTRIBUTION_ID = "<DISTRIBUTION-ID>";

function deviceMetadata() {
  try {
    $m2x = new M2X(API_KEY);
    $device = $m2x->device(DEVICE_ID);
    $response = $device->metadata();
    echo "\n\rLoad metadata for device ";
    echo $response->raw();
    $metadata = json_decode($response->raw(), true);
    if (count($metadata) > 0) {
      $response = $device->metadataField($metadata[0]['key']);
      echo "\n\rLoad metadata field for device ";
      echo $response->raw();
    }

    $metadataObj = array("hi" => "hello");
    $response = $device->updateMetadata($metadataObj);
    if ($response->statusCode == 204) {
       echo "\n\rUpdate metadata for device is Successful.";
       $response = $device->updateMetadataField("hi", "test");
       if ($response->statusCode == 204) {
            echo "\n\rUpdate metadata field for device is successful.";
       } else {
            echo "\n\rUpdate metadata field for device Failed. Please try again.";
       }
    } else {
       echo "\n\rUpdate metadata for device Failed. Please try again.";
    }
  }
  catch (M2XException $ex) {
    echo 'Error: ' . $ex->getMessage();
    echo $ex->response->raw;
    break;
   }
}

function collectionMetadata() {
  try {
    $m2x = new M2X(API_KEY);
    $collection = $m2x->collection(COLLECTION_ID);
    $response = $collection->metadata();
    echo "\n\rLoad metadata for collection ";
    echo $response->raw();
    $metadata = json_decode($response->raw(), true);
    if (count($metadata) > 0) {
      $response = $collection->metadataField($metadata[0]['key']);
      echo "\n\rLoad metadata field for collection ";
      echo $response->raw();
    }
    $metadataObj = array("hi" => "hello");
    $response = $collection->updateMetadata($metadataObj);
    if ($response->statusCode == 204) {
       echo "\n\rUpdate metadata for collection is successful.";
       $response = $collection->updateMetadataField("hi", "Test");
       if ($response->statusCode == 204) {
            echo "\n\rUpdate metadata field for collection is successful.";
       } else {
            echo "\n\rUpdate metadata field for collection Failed. Please try again.";
       }
    } else {
       echo "\n\rUpdate metadata for collection Failed. Please try again.";
    }
  }
  catch (M2XException $ex) {
    echo 'Error: ' . $ex->getMessage();
    echo $ex->response->raw;
    break;
   }
}

function distributionMetadata() {
  try {
    $m2x = new M2X(API_KEY);
    $distribution = $m2x->distribution(DISTRIBUTION_ID);
    $response = $distribution->metadata();
    echo $response->raw();
    echo "\n\rLoad metadata for distribution status $response->statusCode";
    $metadata = json_decode($response->raw(), true);
    if (count($metadata) > 0) {
      $response = $distribution->metadataField($metadata[0]['key']);
      echo "\n\rLoad metadata field for distribution ";
      echo $response->raw();
    }

    $metadataObj = array("hi" => "distribution");
    $response = $distribution->updateMetadata($metadataObj);
    if ($response->statusCode == 204) {
       echo "\n\rUpdate metadata for distribution is successful.";
       $response = $distribution->updateMetadataField("hi", "distributions");
       if ($response->statusCode == 204) {
            echo "\n\rUpdate metadata field for distribution is successful.";
       } else {
            echo "\n\rUpdate metadata field for distribution Failed. Please try again.";
       }
    } else {
       echo "\n\rUpdate metadata for distribution Failed. Please try again.";
    }
  }
  catch (M2XException $ex) {
    echo 'Error: ' . $ex->getMessage();
    echo $ex->response->raw;
    break;
   }
}

deviceMetadata();

collectionMetadata();

distributionMetadata();
