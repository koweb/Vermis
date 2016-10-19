<?php

/**
 * =============================================================================
 * @file        FreeCode/PDO/Db.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Db.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_PDO_Db
 * @brief   Zend_Db integration.
 */
class FreeCode_PDO_Db
{

    /**
     * Get instance (singleton).
     * @return FreeCode_PDO_Db_Adapter_Mysql
     */
    public static function getInstance()
    {
        static $instance;
        if (isset($instance))
            return $instance;
        $instance = new FreeCode_PDO_Db_Adapter_Mysql;
        return $instance;
    }
    
}
