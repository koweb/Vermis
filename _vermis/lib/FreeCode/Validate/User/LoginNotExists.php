<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/User/LoginNotExists.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: LoginNotExists.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
