<?php
class RouterMock extends base\Router{
	function resolve($route){
		$this->resolveUrl($route, 'GET');
	}
}
?>
