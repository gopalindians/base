<?php

namespace base;

/**
 * Exception thrown when a path can not be parsed.
 *
 * @author Marvin Blum
 */
class RoutePathException extends \Exception{
	const MESSAGE = 'Could not parse URL, resolving route is not possible.';
	const CODE = 1;

	function __construct(){
		parent::__construct(self::MESSAGE, self::CODE);
	}
}
?>
