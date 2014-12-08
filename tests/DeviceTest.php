<?php

use Att\M2X\M2X;
use Att\M2X\Device;

class DeviceTest extends BaseTestCase {

/**
 * testIndex method
 *
 * @return void
 */
  public function testIndex() {
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_index_success')));

    $results = Device::index($m2x);
  }
}
