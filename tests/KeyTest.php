<?php

use Att\M2X\M2X;
use Att\M2X\Key;

class KeyTest extends BaseTestCase {

/**
 * testGet method
 *
 * @return void
 */
  public function testGet() {
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/keys/test-key'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('keys_get_success')));

    $key = Key::get($m2x, 'test-key');
    $this->assertInstanceOf('Att\M2X\Key', $key);

    //Check the property values
    $expected = array(
      'name' => 'Raspberry PI',
      'key' => 'test-key',
      'master' => true,
      'stream' => null,
      'expires_at' => null,
      'expired' => false,
      'origin' => null,
      'permissions' => array(
        'GET', 'POST', 'DELETE'
      ),
      'device_access' => 'public'
    );
    $this->assertEquals($expected, $key->data());
    $this->assertEquals('Raspberry PI', $key->name);
  }

/**
 * testIndex method
 *
 * @return void
 */
  public function testIndex() {
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/keys'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('keys_index_success')));

    $results = Key::index($m2x);
    $this->assertCount(2, $results);
    foreach ($results as $result) {
      $this->assertInstanceOf('Att\M2X\Key', $result);
    }
  }

/**
 * testCreateSuccess method
 *
 * @return void
 */
  public function testCreateSuccess() {
    $m2x = $this->generateMockM2X();
    $m2x->request->method('request')
           ->with($this->equalTo('POST'), $this->equalTo('https://api-m2x.att.com/v2/keys'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('keys_post_success')));

    $data = array(
      'name' => 'Test Key',
      'permissions' => array('GET'),
      'feed' => null,
      'stream' => null,
      'expires_at' => null
    );
    $key = Key::create($m2x, $data);
    $this->assertInstanceOf('Att\M2X\Key', $key);
  }

/**
 * testCreateValidationError method
 *
 * @expectedException Att\M2X\Error\M2XException
 * @expectedExceptionMessage Validation Failed
 *
 * @return void
 */
  public function testCreateValidationError() {
    $m2x = $this->generateMockM2X();
    $m2x->request->method('request')
           ->with($this->equalTo('POST'), $this->equalTo('https://api-m2x.att.com/v2/keys'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('keys_post_validation')));

    $data = array(
      'name' => 'Missing Permissions'
    );

    $key = Key::create($m2x, $data);
  }
}
