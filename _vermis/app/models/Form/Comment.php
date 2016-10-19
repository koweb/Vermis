<?php

/**
 * =============================================================================
 * @file        Form/Comment.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Comment.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Form_Comment
 * @brief   Comment form.
 */
class Form_Comment extends FreeCode_Form
{
    
    public function __construct($options = null)
    {
        parent::__construct($options);

        $content = new Zend_Form_Element_Textarea('content', array('rows' => 8));
        $content
            ->setLabel('content')
            ->setRequired(true);
            
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $content,
            $submit
        ));

    }

}
