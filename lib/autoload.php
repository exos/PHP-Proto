<?php

function classes_autoload ($class) {

	$classPath = explode('\\',$class);

	$file = dirname(__FILE__) . "/" . strtolower(implode('/',$classPath)) .".php";

	if (file_exists($file)) {
		require_once($file);
	}
}

spl_autoload_register('classes_autoload');
