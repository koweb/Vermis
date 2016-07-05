<?php

/**
 * =============================================================================
 * @file        routes.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: routes.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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

