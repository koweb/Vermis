<?php

/**
 * =============================================================================
 * @file        bootstrap.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: bootstrap.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
