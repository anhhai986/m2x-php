<?php

use Att\M2X\M2X;
use Att\M2X\Collection;

class CollectionTest extends BaseTestCase {

/**
 * testGet method
 *
 * @return void
 */
  public function testGet() {
    $m2x = $this->generateMockM2X();

    $m2x->request->expects($this->once())->method('request')
           ->with($this->equalTo('GET'),
                  $this->equalTo('https://api-m2x.att.com/v2/collections/6ff63016978318b79631a3e7676e8423'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('collections_get_success')));

    $collection = $m2x->collection('6ff63016978318b79631a3e7676e8423');
    $this->assertInstanceOf('\Att\M2X\Collection', $collection);

    $this->assertEquals('First Child Collection', $collection->name);
  }

/**
 * testCreate method
 *
 * @return void
 */
  public function testCreate() {
    $m2x = $this->generateMockM2X();

    $data = array(
      'name' => 'Test Collection'
    );

    $m2x->request->expects($this->once())->method('request')
           ->with($this->equalTo('POST'),
                  $this->equalTo('https://api-m2x.att.com/v2/collections'),
                  $this->equalTo(array()),
                  $this->equalTo($data))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('collections_post_success')));

    $result = $m2x->createCollection($data);
    $this->assertInstanceOf('Att\M2X\Collection', $result);
    $this->assertEquals('Test Collection', $result->name);
  }

/**
 * testAddDevice method
 *
 * @return void
 */
  public function testAddDevice() {
    $m2x = $this->generateMockM2X();

    $m2x->request->expects($this->once())->method('request')
           ->with($this->equalTo('PUT'),
                  $this->equalTo('https://api-m2x.att.com/v2/collections/d447a2c499bc009d96a7d693a2e5b909/devices/12f74d5878561bf1c19ea8942515c466'),
                  $this->equalTo(array()))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('collections_add_device_success')));

    $collection = new Collection($m2x, array('id' => 'd447a2c499bc009d96a7d693a2e5b909'));
    $result = $collection->addDevice('12f74d5878561bf1c19ea8942515c466');
    $this->assertInstanceOf('Att\M2X\HttpResponse', $result);
  }

/**
 * testRemoveDevice method
 *
 * @return void
 */
  public function testRemoveDevice() {
    $m2x = $this->generateMockM2X();

    $m2x->request->expects($this->once())->method('request')
           ->with($this->equalTo('DELETE'),
                  $this->equalTo('https://api-m2x.att.com/v2/collections/d447a2c499bc009d96a7d693a2e5b909/devices/12f74d5878561bf1c19ea8942515c466'),
                  $this->equalTo(array()))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('collections_remove_device_success')));

    $collection = new Collection($m2x, array('id' => 'd447a2c499bc009d96a7d693a2e5b909'));
    $result = $collection->removeDevice('12f74d5878561bf1c19ea8942515c466');
    $this->assertInstanceOf('Att\M2X\HttpResponse', $result);
  }
}
