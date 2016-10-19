<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/Doctrine/Unique.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Unique.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Validate_Doctrine_Unique
 * @brief   Unique validator.
 */
class FreeCode_Validate_Doctrine_Unique extends Zend_Validate_Abstract
{

    const VALUE_ALREADY_EXISTS = 'valueAlreadyExists';

    protected $_messageTemplates = array(
        self::VALUE_ALREADY_EXISTS => 'Value already exists'
    );

    protected $_modelName = null;
    protected $_columnName = null;

    /**
     * Constructor.
     * @param   string  $modelName
     * @param   string  $columnName
     */
    public function __construct($modelName, $columnName)
    {
        $this->_modelName = $modelName;
        $this->_columnName = $columnName;
    }

    /**
     * Validation.
     * @param   string  $value 
     * @return  boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);
        $value = addslashes($value);
        
        $record = Doctrine::getTable($this->_modelName)
            ->findByDql("{$this->_columnName} = '{$value}'", array(), Doctrine::HYDRATE_ARRAY);
        if ($record) {
            $this->_error(null);
            return false;
        }
            
        return true;
    }

}
