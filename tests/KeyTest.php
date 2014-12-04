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
		$m2x = new M2X('foo-bar');

		$m2x->request = $this->getMockBuilder('Att\M2X\HttpRequest')
							 ->setMethods(array('request'))
							 ->getMock();

		$m2x->request->method('request')
					 ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/keys/test-key'))
					 ->willReturn(new Att\M2X\HttpResponse($this->_raw('keys_get_success')));

		$result = Key::get($m2x, 'test-key');
		$this->assertInstanceOf('Att\M2X\Key', $result);
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$m2x = new M2X('foo-bar');

		$m2x->request = $this->getMockBuilder('Att\M2X\HttpRequest')
							 ->setMethods(array('request'))
							 ->getMock();

		$m2x->request->method('request')
					 ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/keys'))
					 ->willReturn(new Att\M2X\HttpResponse($this->_raw('keys_index_success')));

		$results = Key::index($m2x);
		$this->assertCount(2, $results);
		foreach ($results as $result) {
			$this->assertInstanceOf('Att\M2X\Key', $result);
		}
	}
}

