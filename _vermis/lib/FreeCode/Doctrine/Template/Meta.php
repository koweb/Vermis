<?php

/**
 * =============================================================================
 * @file        FreeCode/Doctrine/Template/Meta.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Meta.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Doctrine_Template_Meta
 * @brief   Meta header template for doctrine
 */
class FreeCode_Doctrine_Template_Meta extends Doctrine_Template
{

    public function setTableDefinition()
    {
        $this->hasColumn('meta_keywords', 'string', 255, array(
            'notnull' => true,
            'default' => ''
        ));
        
        $this->hasColumn('meta_description', 'string', 255, array(
            'notnull' => true,
            'default' => ''
        ));
    }
    
}
