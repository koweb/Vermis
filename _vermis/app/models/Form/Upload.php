<?php

/**
 * =============================================================================
 * @file        Form/Upload.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Upload.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Form_Upload
 * @brief   Upload form.
 */
class Form_Upload extends FreeCode_Form
{
    
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->enableUpload();
        $file = new Zend_Form_Element_File('file');
        $file
            ->setLabel('choose_file')
            ->setRequired(true)
            ->setDestination(UPLOAD_DIR.'/tmp')
            ->addValidator('Size', false, FreeCode_Config::getInstance()->uploadMaxSize);
            
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('upload');

        $this->addElements(array(
            $file,
            $submit
        ));
    }

}
