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
  	$this->markTestIncomplete('Needs to test integration with the collection');
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_index_success')));

    $results = Device::index($m2x);
  }

/**
 * testGet method
 *
 * @return void
 */
  public function testGet() {
    $m2x = $this->generateMockM2X();

    $m2x->request->expects($this->once())->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices/2dd1c43521cef93109a3e8a75d4d5a88'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_get_success')));

    $result = $m2x->device('2dd1c43521cef93109a3e8a75d4d5a88');

    $this->assertEquals('2dd1c43521cef93109a3e8a75d4d5a88', $result->id());
    $this->assertEquals('Test Blueprint', $result->name);
  }

/**
 * testLocationNoData method
 *
 * @return void
 */
  public function testLocationNoData() {
    $m2x = $this->generateMockM2X();

    $m2x->request->expects($this->at(0))->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices/2dd1c43521cef93109a3e8a75d4d5a88'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_get_success')));

    $m2x->request->expects($this->at(1))->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices/2dd1c43521cef93109a3e8a75d4d5a88/location'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_location_get_no_data')));

    $result = $m2x->device('2dd1c43521cef93109a3e8a75d4d5a88');
    $this->assertFalse($result->location());
  }

/**
 * testLocationSuccess method
 *
 * @return void
 */
  public function testLocationSuccess() {
    $m2x = $this->generateMockM2X();

    $m2x->request->expects($this->at(0))->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices/2dd1c43521cef93109a3e8a75d4d5a88'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_get_success')));

    $m2x->request->expects($this->at(1))->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices/2dd1c43521cef93109a3e8a75d4d5a88/location'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_location_get_success')));

    $device = $m2x->device('2dd1c43521cef93109a3e8a75d4d5a88');
    $location = $device->location();
    $this->assertNotEmpty($location);
    $this->assertEquals('Storage Room', $location['name']);
  }

/**
 * testUpdateLocation method
 *
 * @return void
 */
  public function testUpdateLocation() {
    $data = array('name' => 'foo', 'latitude' => 51.178844, 'longitude' => -1.826189);

    $m2x = $this->generateMockM2X();

    $m2x->request->expects($this->once())->method('request')
           ->with($this->equalTo('PUT'), $this->equalTo('https://api-m2x.att.com/v2/devices/foobar/location'), $this->equalTo($data))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_update_location_success')));


    $device = new Device($m2x, array('id' => 'foobar'));
    $result = $device->updateLocation($data);
    $this->assertSame($device, $result);
  }

/**
 * testCreate method
 *
 * @return void
 */
  public function testCreate() {
    $data = array(
      'name' => 'Foo Bar',
      'visibility' => 'public'
    );

    $m2x = $this->generateMockM2X();

    $m2x->request->expects($this->once())->method('request')
           ->with($this->equalTo('POST'), $this->equalTo('https://api-m2x.att.com/v2/devices'), $this->equalTo($data))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('devices_post_success')));

    $result = $m2x->createDevice($data);
    $this->assertInstanceOf('Att\M2X\Device', $result);
  }
}
