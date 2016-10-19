<?php

/**
 * =============================================================================
 * @file        routes.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: routes.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

$files = array(
    'routes.default.php',
    'routes.project.php'
);

$routes = array();
foreach ($files as $file) {
    $array = @include $file;
    $routes = array_merge($routes, $array);
}
return $routes;

