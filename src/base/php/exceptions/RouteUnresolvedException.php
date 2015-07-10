<?php

namespace base;

/**
 * Exception thrown when a route cannot be resolved an not 404 page is set.
 *
 * @author Marvin Blum
 */
class RouteUnresolvedException extends \Exception{
	const MESSAGE = 'The URL could not be resolved to a route: ';
	const CODE = 2;

	function __construct($url = ''){
		\Exception::__construct(RouteUnresolvedException::MESSAGE.$url, RouteUnresolvedException::CODE);
	}
}
?>
