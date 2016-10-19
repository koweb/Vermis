<?php

/**
 * =============================================================================
 * @file        FreeCode/Doctrine/Template/Meta.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Meta.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
