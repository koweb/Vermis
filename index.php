<?php

/**
 * =============================================================================
 * @file        index.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: index.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

$rootDir = dirname(__FILE__);
require_once $rootDir.'/_vermis/bootstrap.php';

function __debug(Exception $exc)
{
    ?>

<html>
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<title>Fatal Error</title>
</head>
<body style="border:0; margin:0; padding:0; width:100%; height:100%; font:13px Arial,Tahoma,helvetica,sans-serif; background:#efefef; color:#000000;">
<div style="height:70px; background:#b70606; color:#ffffff; line-height:70px; font-size:30px; font-weight:bold; padding:0 20px;">Error</div>
<div style="padding:10px 20px;">
    <div style="font-weight:bold; font-size:16px; color:#aaaaaa; line-height:32px; letter-spacing:1px;">Error:</div>
    <div style="font-size:22px; font-weight:bold; color:#000000; padding:4px 20px;"><?= get_class($exc) ?>: <?= $exc->getMessage() ?></div>
    <div style="font-weight:bold; font-size:16px; color:#aaaaaa; line-height:32px; letter-spacing:1px;">Backtrace:</div>
    <div style="padding:4px 20px;">
        <pre><?= $exc->getTraceAsString() ?></pre>
    </div>
    <div style="font-weight:bold; font-size:16px; color:#aaaaaa; line-height:32px; letter-spacing:1px;">Uptime:</div>
    <div style="font-size:16px; font-weight:bold; color:#000000; padding:4px 20px;"><?= FreeCode_Application::getInstance()->getUptime() ?></div>
</div>
<div style="text-align:center; padding:20px; font-size:10px; color:#444444;">&copy; <?= date('Y') ?> <a href="https://github.com/koweb/Vermis">Cask Code, KOWeb</a></div>
</body>
</html>

    <?php   
}

function __setupTip(FreeCode_Exception_SetupError $exc) 
{
    ?>

<html>
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<title>Setup Error</title>
</head>
<body style="border:0; margin:0; padding:0; width:100%; height:100%; font:13px Arial,Tahoma,helvetica,sans-serif; background:#ffffff; color:#000000;">
<div style="padding:10px 20px;">
    <div style="font-size:22px; font-weight:bold; color:#666666; padding:4px 20px; text-align:center;"><span style="font-size:2em; padding:0 20px; color:red;">:(</span> <?= $exc->getMessage() ?></div>
	<div style="font-size:16px; font-weight:normal; color:#000000; text-align:center"><?= $exc->getTip() ?></div>
</div>
<div style="text-align:center; padding:20px; font-size:10px; color:#444444;">&copy; <?= date('Y') ?> <a href="https://github.com/koweb/Vermis">Cask Code, KOWeb</a></div>
</body>
</html>

    <?php   
}

try {
    
    $app = Application::getInstance();
    $app->execute();

} catch (FreeCode_Exception_SetupError $exc) {  
    __setupTip($exc);

} catch (Exception $exc) {
    __debug($exc);
    die(-1);
}
?>
