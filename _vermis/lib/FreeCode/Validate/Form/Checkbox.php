<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/Form/Checkbox.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Checkbox.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Validate_Form_Checkbox
 * @brief   Checkbox validator.
 */
class FreeCode_Validate_Form_Checkbox extends Zend_Validate_Abstract
{

    const CHECKBOX_NOT_CHECKED = 'checkboxNotChecked';

    protected $_messageTemplates = array(
        self::CHECKBOX_NOT_CHECKED => 'Checkbox is not checked'
    );

    /**
     * Validation.
     * @param   string  $value 
     * @return  boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        if ($value != '1') {
            $this->_error(null);
            return false;
        }

        return true;
    }

}
