<?php

use Att\M2X\M2X;
use Att\M2X\Device;
use Att\M2X\Stream;

class StreamTest extends BaseTestCase {

/**
 * testOriginalGetDisabled method
 *
 * @expectedException BadMethodCallException
 *
 * @return void
 */
  public function testOriginalGetDisabled() {
    $m2x = $this->generateMockM2X();
    Stream::get($m2x, 'foo');
  }

/**
 * testGet method
 *
 * @return void
 */
  public function testGet() {
    $m2x = $this->generateMockM2X();

    $m2x->request->expects($this->once())->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/devices/c2b83dcb796230906c70854a57b66b0a/streams/stream_one'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('streams_get_success')));

    $device = new Device($m2x, array('id' => 'c2b83dcb796230906c70854a57b66b0a'));
    $result = $device->stream('stream_one');

    $this->assertEquals('stream_one', $result->name);
    $this->assertSame($device, $result->device);
  }
}
