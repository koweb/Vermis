<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/Doctrine/UniqueSlug.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: UniqueSlug.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Validate_Doctrine_UniqueSlug
 * @brief   Unique slug validator.
 */
class FreeCode_Validate_Doctrine_UniqueSlug extends FreeCode_Validate_Doctrine_Unique
{

    /**
     * Validation.
     * @param   string  $value 
     * @return  boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);
        $value = FreeCode_String::normalize($value);
        
        $record = Doctrine::getTable($this->_modelName)
            ->findByDql("{$this->_columnName} = '{$value}'", array(), Doctrine::HYDRATE_ARRAY);
        if ($record) {
            $this->_error(null);
            return false;
        }
            
        return true;
    }

}
