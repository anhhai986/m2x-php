<?php

namespace Att\M2X;

class HttpResponse {

/**
 * The HTTP status code
 *
 * @var integer
 */
	public $statusCode;

/**
 * The response headers
 *
 * @var array
 */
	public $headers = array();

/**
 * The response body
 *
 * @var string
 */
	public $body = '';

/**
 * Parse the CURL response data
 *
 * @param string $response
 */
	public function __construct($response) {
		$pattern = '#HTTP/\d\.\d.*?$.*?\r\n\r\n#ims';

		preg_match_all($pattern, $response, $matches);
		$headers_string = array_pop($matches[0]);
		$headers = explode("\r\n", str_replace("\r\n\r\n", '', $headers_string));

		$status = array_shift($headers);
		preg_match('#HTTP/(\d\.\d)\s(\d\d\d)\s(.*)#', $status, $matches);
		$this->statusCode = (int) $matches[2];

		foreach ($headers as $header) {
			preg_match('#(.*?)\:\s(.*)#', $header, $matches);
			$this->headers[$matches[1]] = $matches[2];
		}

		$this->body = str_replace($headers_string, '', $response);
	}

/**
 * Returns the json encoded data object
 *
 * @return object
 */
	public function json() {
		return json_decode($this->body);
	}
}