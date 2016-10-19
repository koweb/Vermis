<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Memory/Session.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Session.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Memory_Session
 * @brief   Grid memory.
 */
class FreeCode_Grid_Memory_Session extends FreeCode_Grid_Memory_Abstract
{

    /**
     * Remember grid settings.
     * @return void
     */
    public function remember()
    {
        $grid = $this->getGrid();
        $session = new Zend_Session_Namespace('grid_'.$grid->getId());
        $session->options = $grid->getOptions();
    }
    
    /**
     * Restore grid settings.
     * @return void
     */
    public function restore()
    {
        $grid = $this->getGrid();
        $session = new Zend_Session_Namespace('grid_'.$grid->getId());
        $grid->setOptions($session->options);
    }
    
}
