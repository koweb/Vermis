<?php

/**
 * =============================================================================
 * @file        FreeCode/PDO/Db/Adpater/Mysql.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Mysql.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
