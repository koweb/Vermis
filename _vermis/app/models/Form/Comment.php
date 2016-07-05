<?php

/**
 * =============================================================================
 * @file        Form/Comment.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Comment.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
