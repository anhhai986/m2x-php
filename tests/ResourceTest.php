<?php

use Att\M2X\M2X;
use Att\M2X\Resource;

/**
 * Test class for unit testing the abstract Resource class
 *
 */
class MockResource extends Resource {

/**
 * Path of the resource
 *
 * @var string
 */
  protected static $path = '/foo';

/**
 * Resource properties
 *
 * @var array
 */
  protected static $properties = array(
    'name', 'description', 'foo', 'bar'
  );

/**
 * Helper method to retrieve a protected instance variable
 *
 * @param string $name
 * @return mied
 */
  public function getProtected($name) {
    return $this->{$name};
  }
}

class ResourceTest extends BaseTestCase {

/**
 * testMagickMethods method
 *
 * @return void
 */
  public function testMagicMethods() {
    $m2x = $this->generateMockM2X();

    $data = new stdClass();
    $data->name = 'Test Resource';
    $data->description = 'Foo Description';
    $data->foo = 'abc123';
    $data->bar = 10005;

    $resource = new MockResource($m2x, $data);

    $this->assertEquals('Test Resource', $resource->name);
    $this->assertEquals(10005, $resource->bar);

    $resource->name = 'Edited Name';
    $result = $resource->getProtected('data');
    $this->assertEquals('Edited Name', $result['name']);
    $this->assertEquals('Edited Name', $resource->name);
  }
}
