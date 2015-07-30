<?php
class RouterMock extends base\Router{
	function resolve($route){
		$this->resolveUrl(new base\URI($route), 'GET');
	}
}
?>
