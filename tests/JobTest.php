<?php

use Att\M2X\M2X;
use Att\M2X\Job;

class JobTest extends BaseTestCase {

/**
 * testIndex method
 *
 * @return void
 */
  public function testIndex() {
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/jobs'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('jobs_index_success')));

    $results = $m2x->jobs();
    $this->assertCount(2, $results);
    foreach ($results as $result) {
      $this->assertInstanceOf('Att\M2X\Job', $result);
    }
  }

/**
 * testGet method
 *
 * @return void
 */
  public function testGet() {
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'), $this->equalTo('https://api-m2x.att.com/v2/keys/201512b934abb4fc68dedbc05ef052c6cff8f0'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('keys_get_success')));

    $key = $m2x->key('201512b934abb4fc68dedbc05ef052c6cff8f0');
    $this->assertInstanceOf('Att\M2X\Key', $key);
  }

/**
 * testDeleteDisabled method
 *
 * @expectedException BadMethodCallException
 */
  public function testDeleteDisabled() {
    $m2x = $this->generateMockM2X();
    $m2x->request->expects($this->never())->method('request');

    $job = new Job($m2x, array('id' => 'foobar'));
    $job->delete();
  }

/**
 * testUpdateDisabled method
 *
 * @expectedException BadMethodCallException
 */
  public function testUpdateDisabled() {
    $m2x = $this->generateMockM2X();
    $m2x->request->expects($this->never())->method('request');

    $job = new Job($m2x, array('id' => 'foobar'));
    $job->update(array('title' => 'bar'));
  }

/**
 * testCreateDisabled method
 *
 * @expectedException BadMethodCallException
 */
  public function testCreateDisabled() {
    $m2x = $this->generateMockM2X();
    $m2x->request->expects($this->never())->method('request');

    $job = Job::create($m2x, array('title' => 'bar'));
  }
}
