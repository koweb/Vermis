<?php

/**
 * =============================================================================
 * @file        bootstrap.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: bootstrap.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

$rootDir = dirname(dirname(__FILE__));
require_once $rootDir.'/bootstrap.php';
//require_once 'PHPUnit/Framework.php';

/*
 * Append include path.
 */
$pathes = array(
    '/app/controllers/Default',
    '/test',
    '/test/app/controllers',
    '/test/app/models',
	'/test/selenium'
);

$includePath = '';
foreach ($pathes as $path) {
    $includePath .= ROOT_DIR.$path.PATH_SEPARATOR;
}

set_include_path(
    '.'.PATH_SEPARATOR.
    $includePath.
    get_include_path()
);

FreeCode_Test::enable();

// Start session before phpunit cli runner will print to the output.
Zend_Session::$_unitTestEnabled = true;
Zend_Session::start();
