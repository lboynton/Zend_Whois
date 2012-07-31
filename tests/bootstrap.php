<?php

/*
 * Set error reporting to the level to which Zend Framework code must comply.
 */
error_reporting(E_ALL | E_STRICT);

/*
 * Determine the root, library, and tests directories of the framework
 * distribution.
 */
$root = realpath(dirname(dirname(__FILE__)));
$library = "$root/library";
$tests = "$root/tests";

/*
 * Prepend the Zend Framework library/ and tests/ directories to the
 * include_path. This allows the tests to run out of the box and helps prevent
 * loading other copies of the framework code and tests that would supersede
 * this copy.
 */
$path = array(
	$library,
	$tests,
	get_include_path()
);
set_include_path(implode(PATH_SEPARATOR, $path));

/*
 * Load the user-defined test configuration file, if it exists; otherwise, load
 * the default configuration.
 */
if (is_readable($tests . DIRECTORY_SEPARATOR . 'TestConfiguration.php'))
{
	require_once $tests . DIRECTORY_SEPARATOR . 'TestConfiguration.php';
}
else
{
	require_once $tests . DIRECTORY_SEPARATOR . 'TestConfiguration.php.dist';
}

/*
 * Unset global variables that are no longer needed.
 */
unset($root, $library, $tests, $path);

// Suppress DateTime warnings
date_default_timezone_set(@date_default_timezone_get());

// Use Zend Autoloader for autoloading classes
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Lboy_');