<?php

/**
 * =============================================================================
 * @file        Validate/Project/Milestone.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Milestone.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Validate_Project_Milestone
 * @brief Validator for milestone name and slug.
 */
class Validate_Project_Milestone extends Zend_Validate_Abstract
{

    const MILESTONE_EXISTS = 'milestoneExists';

    protected $_messageTemplates = array(
        self::MILESTONE_EXISTS => 'Milestone already exists'
    );
    
    protected $_projectId = null;
    
    public function __construct($projectId)
    {
        $this->_projectId = $projectId;
    }

    public function isValid($value)
    {
        $this->_setValue($value);

        if (Doctrine::getTable('Project_Milestone')->milestoneExists(
                $this->_projectId,
                FreeCode_String::normalize($value)
            )) {
            $this->_error(null);
            return false;
        }
            
        return true;
    }

}
