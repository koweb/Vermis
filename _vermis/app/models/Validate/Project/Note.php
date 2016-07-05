<?php

/**
 * =============================================================================
 * @file        Validate/Project/Note.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Note.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Validate_Project_Note
 * @brief Validator for note title and slug.
 */
class Validate_Project_Note extends Zend_Validate_Abstract
{

    const NOTE_EXISTS = 'noteExists';

    protected $_messageTemplates = array(
        self::NOTE_EXISTS => 'Note already exists'
    );
    
    protected $_projectId = null;
    
    public function __construct($projectId)
    {
        $this->_projectId = $projectId;
    }

    public function isValid($value)
    {
        $this->_setValue($value);

        if (Doctrine::getTable('Project_Note')->noteExists(
                $this->_projectId,
                FreeCode_String::normalize($value)
            )) {
            $this->_error(null);
            return false;
        }
            
        return true;
    }

}
