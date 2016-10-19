<?php

/**
 * =============================================================================
 * @file        Validate/Project/Milestone.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Milestone.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
