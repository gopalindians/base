<?php

class Model{
	static function toJson($obj){
		return json_encode(get_object_vars($obj));
	}

	static function fromJson($obj){
		// TODO: automatically create the correct instance and initialize

		return json_decode($obj);
	}
}
?>
