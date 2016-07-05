<?php

/**
 * =============================================================================
 * @file        FreeCode/PDO/Db.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Db.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
    public function getInstance()
    {
        static $instance;
        if (isset($instance))
            return $instance;
        $instance = new FreeCode_PDO_Db_Adapter_Mysql;
        return $instance;
    }
    
}
