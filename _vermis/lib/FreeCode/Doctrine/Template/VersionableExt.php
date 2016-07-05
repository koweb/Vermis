<?php

/**
 * =============================================================================
 * @file        FreeCode/Doctrine/Template/VersionableExt.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: VersionableExt.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Doctrine_Template_VersionableExt
 * @brief   Versionable extensions for doctrine. 
 */
class FreeCode_Doctrine_Template_VersionableExt extends Doctrine_Template
{
    
    public function getVersionsQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $invoker = $this->getInvoker();
        $class = get_class($invoker).'Version';
        
        return Doctrine_Query::create()
            ->select("v.*")
            ->from("{$class} v")
            ->addWhere("v.id = ?", $invoker->id)
            ->orderBy("v.version DESC")
            ->setHydrationMode($hydrationMode);
    }
    
}
