<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/User/EmailNotExists.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: EmailNotExists.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class FreeCode_Validate_User_EmailNotExists
 * @brief User email validator for User.
 */
class FreeCode_Validate_User_EmailNotExists extends Zend_Validate_Abstract
{

    const EMAIL_ALREADY_IN_USE = 'emailAlreadyInUse';

    protected $_messageTemplates = array(
        self::EMAIL_ALREADY_IN_USE => 'Email is already in use'
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
            ->findByDql("email = '{$value}'", array(), Doctrine::HYDRATE_ARRAY);
        if ($record) {
            $this->_error(null);
            return false;
        }
            
        return true;
    }

}
