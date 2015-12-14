<?php

use Att\M2X\M2X;
use Att\M2X\Distribution;
use Att\M2X\DistributionCollection;

class CollectionCollectionTest extends BaseTestCase {

/**
 * testIndexWithNoCollections method
 *
 * @return void
 */
  public function testIndexWithNoCollections() {
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'),
                  $this->equalTo('https://api-m2x.att.com/v2/collections'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('collections_empty_success')));

    $result = $m2x->collections();

    $this->assertEquals(0, $result->count());
  }

/**
 * testIndex method
 *
 * @return void
 */
  public function testSinglePage() {
    $m2x = $this->generateMockM2X();

    $m2x->request->method('request')
           ->with($this->equalTo('GET'),
                  $this->equalTo('https://api-m2x.att.com/v2/collections'))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('collections_index_success')));

    $result = $m2x->collections();
    $this->assertCount(6, $result);
    $this->assertInstanceOf('Att\M2X\Collection', $result->current());
  }

/**
 * testParameters method
 *
 * @return void
 */
  public function testParameters() {
    $m2x = $this->generateMockM2X();

    $parentId = '80182f34f5eb5aeb75a7d82b92398715';

    $m2x->request->method('request')
           ->with($this->equalTo('GET'),
                  $this->equalTo('https://api-m2x.att.com/v2/collections'),
                  $this->equalTo(array('parent' => $parentId)))
           ->willReturn(new Att\M2X\HttpResponse($this->_raw('collections_parent_index_success')));

    $result = $m2x->collections(array('parent' => $parentId));
    $this->assertCount(2, $result);

    $result->next();
    $collection = $result->current();
    $this->assertEquals('Second Child Collection', $collection->name);
    $this->assertEquals(1, $collection->collections);

  }
}
