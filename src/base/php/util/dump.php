<?php

namespace base;

/**
 * Pretty output of variable.
 * Prints to page!
 *
 * @param data the data/variable to output, mixed
 * @return void
 */
function dump($data){
	print '<pre>';

	if(is_string($data)){
		var_dump(htmlentities($data));
	}
	else{
		var_dump($data);
	}

	print '</pre>';
}
?>
