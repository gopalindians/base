<?php

namespace base;

/**
 * HTTP method enum.
 *
 * @author Marvin Blum
 */
class HttpMethod{
	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const DELETE = 'DELETE';
	const HEAD = 'HEAD';
	const TRACE = 'TRACE';
	const CONNECT = 'CONNECT';

	/**
	 * Returns all available HTTP methods.
	 *
	 * @return array containing all available HTTP methods as strings
	 */
	static function ALL(){
		return array(self::GET, self::POST, self::PUT, self::DELETE, self::HEAD, self::TRACE, self::CONNECT);
	}
}
?>
