<?php

use Att\M2X\M2X;

class M2XTest extends PHPUnit_Framework_TestCase {
 
 /**
  * testInit method
  *
  * @return void
  */
	public function testBasics() {
		$m2x = new M2X('foo-bar');
		$this->assertEquals('foo-bar', $m2x->apiKey());

		$result = $m2x->endpoint();
		$this->assertEquals('https://api-m2x.att.com/v2', $result);
 	}

/**
 * testStatus method
 *
 * @return void
 * @todo Create mock
 */
 	public function testStatusSuccess() {
		$m2x = new M2X('foo-bar');

		$stub = $this->getMockBuilder('Att\M2X\HttpRequest')
					 ->setMethods(array('request'))
					 ->getMock();

		$raw = file_get_contents(__DIR__ . '/responses/status_success.txt');
		$stub->method('request')->willReturn(new Att\M2X\HttpResponse($raw));
		$m2x->request = $stub;

		$response = $m2x->status();
		$expected = '{"api":"OK","triggers":"OK"}';
		$this->assertSame(200, $response->statusCode);
		$this->assertEquals($expected, $response->body);
	}
}