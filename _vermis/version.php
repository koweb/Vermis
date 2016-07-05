<?php

/**
 * =============================================================================
 * @file        version.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: version.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

if (!defined('VERMIS_VERSION')) 
    define('VERMIS_VERSION', '1.0');

if (!defined('VERMIS_DB_VERSION')) 
    define('VERMIS_DB_VERSION', 15);

/**
 * SVN_REVISION
 * Do not change this manually!
 */
if (!defined('VERMIS_SVN_REVISION')) 
    define('VERMIS_SVN_REVISION', 'r130-20110130');
