<?php

/**
 * =============================================================================
 * @file        FreeCode/PDO/Db/Adpater/Mysql.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Mysql.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_PDO_Db_Adapter_Mysql
 * @brief   Zend_Db integration.
 */
class FreeCode_PDO_Db_Adapter_Mysql extends Zend_Db_Adapter_Pdo_Mysql
{

    /**
     * Override default constructor with empty config.
     */
    public function __construct()
    {
        $options = array(
            'dbname' => '',
            'username' => '',
            'password' => ''
        );
        parent::__construct($options);
    }
    
    /**
     * Override default connection setup.
     * @see extern/Zend/Db/Adapter/Pdo/Zend_Db_Adapter_Pdo_Mysql#_connect()
     */
    protected function _connect()
    {
        $this->_connection = FreeCode_PDO_Manager::getInstance()
            ->getCurrentConnection();
    }
    
}
