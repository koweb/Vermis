<?php

/**
 * =============================================================================
 * @file        Form/Upload.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Upload.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
