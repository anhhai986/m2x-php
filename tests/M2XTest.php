<?php

use Att\M2X\M2X;

class M2XTest extends BaseTestCase {
 
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
 */
   public function testStatusSuccess() {
    $m2x = new M2X('foo-bar');

    $m2x->request = $this->getMockBuilder('Att\M2X\HttpRequest')
               ->setMethods(array('request'))
               ->getMock();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/status'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('status_success')));

    $response = $m2x->status();
    $expected = '{"api":"OK","triggers":"OK"}';
    $this->assertSame(200, $response->statusCode);
    $this->assertEquals($expected, $response->body);
  }

/**
 * testGet method
 *
 * @return void
 */
  public function testGet() {
    $m2x = new M2X('abc123');

    $m2x->request = $this->getMockBuilder('Att\M2X\HttpRequest')
                         ->setMethods(array('header'))
                         ->getMock();

    $m2x->request->expects($this->at(0))
                 ->method('header')
                 ->with($this->equalTo('X-M2X-KEY'), $this->equalTo('abc123'));

    $m2x->get('/status');
  }
}
