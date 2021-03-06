<?php
/**
 * PSR-4 Compliant Autoloader
 *
 * This will dynamically load classes by resolving the prefix and class name.
 *
 * @param string $class fully qualified class name to load
 **/
spl_autoload_register(function($class) {
	/**
	 * configurable parameters
	 * prefix: the prefix for all the classes ie namespacce
	 * baseDir: the base directory for all classes (default = current directory)
	 **/
	$prefix =  "TaylorSmith\\objectOrientedProject";
	$baseDir = __DIR__;

	//does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get class relative to class name
	$className = substr($class, $len);

	//replace the namespace prefix with the base directory
	//replace namespace separators with directory separators in the relative class name
	//append with .php
	$file = $baseDir . str_replace("\\", "/", $className) . ".php";

	//if the file exists require it
	if(file_exists($file)) {
		require_once($file);
	}
});
