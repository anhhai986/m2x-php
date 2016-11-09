<?php

include '../vendor/autoload.php';

use Att\M2X\M2X;
use Att\M2X\Error\M2XException;

CONST API_KEY = "10ade758d7839efcc4660fe11a0adcf8";
CONST DEVICE_ID = "7f5bca65b6387c08dd80f5908017d201";

function sendCommand() {
  try {
    $m2x = new M2X(API_KEY);
    // Send a command with the given name to the given target devices.
    $response = $m2x->sendCommand(array(
                                         "name"=> "SAY_COMMAND",
                                         "targets"=> array(
                                             "devices"=> ["7f5bca65b6387c08dd80f5908017d201"])));
     echo $response->statusCode;
    }
   catch (M2XException $ex) {
     echo 'Error: ' . $ex->getMessage();
     echo $ex->response->raw;
     break;
   }
}

function listCommands() {
  try {
    $m2x = new M2X(API_KEY);
    // Retrieve the list of recent commands sent by the current account.
    $commands = $m2x->commands(array('limit'=> 4));
    foreach ($commands as $command) {
       $responseCommand = $m2x->viewCommandDetails($command->id);
       print sprintf("Processing command id = %s name = %s sent at = %s \n\r", $responseCommand->id, $responseCommand->name, $responseCommand->sent_at);
     }
   }
  catch (M2XException $ex) {
    echo 'Error: ' . $ex->getMessage();
    echo $ex->response->raw;
    break;
  }
}

function deviceCommands() {
  try {
    $m2x = new M2X(API_KEY);
    $device = $m2x->device(DEVICE_ID);

    // Retrieve the list of recent commands sent to target device.
    $commands = $device->commands(array('status'=> 'pending','limit'=> 2));

    foreach ($commands as $command) {
        // Get details of a received commands for the device.
        $responseCommand = $device->command($command->id);

      if( $responseCommand->name == 'SAY_COMMAND'){
           echo "\n\rMark the given command as processed....\n\r";
           $device->process($responseCommand);
        }
      else {
           echo "\n\rMark the given command as rejected....\n\r";
           $device->reject($responseCommand);
        }
     }
  }
  catch (M2XException $ex) {
    echo 'Error: ' . $ex->getMessage();
    echo $ex->response->raw;
    break;
  }
}

 sendCommand();

 listCommands();

 deviceCommands();
