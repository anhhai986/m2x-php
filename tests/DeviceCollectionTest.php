<?php

use Att\M2X\M2X;
use Att\M2X\Device;
use Att\M2X\DeviceCollection;

class DeviceCollectionTest extends BaseTestCase {

/**
 * testIndex method
 *
 * @return void
 */
  public function testSinglePage() {
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_index_success')));

    $collection = new DeviceCollection($m2x);
    $this->assertEquals(3, $collection->total());

    foreach ($collection as $resource) {
    	$this->assertInstanceOf('Att\M2X\Device', $resource);
    }
  }

/**
 * testParameters method
 *
 * @return void
 */
  public function testParameters() {
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices'), $this->equalTo(array('q' => 'Foo', 'page' => 1)))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_index_success')));
    $params = array('q' => 'Foo');
    $collection = new DeviceCollection($m2x, $params);
  }
}
