<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/User/LoginNotExists.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: LoginNotExists.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class FreeCode_Validate_User_LoginNotExists
 * @brief User login validator for User.
 */
class FreeCode_Validate_User_LoginNotExists extends Zend_Validate_Abstract
{

    const LOGIN_ALREADY_IN_USE = 'loginAlreadyInUse';

    protected $_messageTemplates = array(
        self::LOGIN_ALREADY_IN_USE => 'Login is already in use'
    );
    
    protected $_modelName = null;
    
    public function __construct($modelName = 'User')
    {
        $this->_modelName = $modelName;
    }

    public function isValid($value)
    {
        $this->_setValue($value);

        $record = Doctrine::getTable($this->_modelName)
            ->findByDql("login = '{$value}'", array(), Doctrine::HYDRATE_ARRAY);
        if ($record) {
            $this->_error(null);
            return false;
        }
            
        return true;
    }

}
