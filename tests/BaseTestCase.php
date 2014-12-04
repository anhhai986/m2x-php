<?php

abstract class BaseTestCase extends PHPUnit_Framework_TestCase {
	
/**
 * Returns a raw mock response
 *
 * @param string $name
 * @return string
 */
	protected function _raw($name) {
		return file_get_contents(__DIR__ . '/responses/' . $name . '.txt');
	}
}