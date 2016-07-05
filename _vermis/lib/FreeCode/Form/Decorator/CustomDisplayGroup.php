<?php

/**
 * =============================================================================
 * @file        FreeCode/Form/Decorator/CustomDisplayGroup.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: CustomDisplayGroup.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Form_Decorator_CustomDisplayGroup
 * @brief   Custom form decorator.
 */
class FreeCode_Form_Decorator_CustomDisplayGroup extends Zend_Form_Decorator_Abstract
{

    /**
     * Render display group.
     * @param   string  $content
     * @return  string
     */
    public function render($content)
    {
        $element = $this->getElement();
        if ($element->getView() === null)
            return $content;

        $id = $element->getName();
        $attribs = $element->getAttribs();

        $class = (isset($attribs['class']) ? ' '.$attribs['class'] : '');

        if (isset($attribs['legend']))
            $legend = '<div id="'.$id.'_legend" class="legend">'.FreeCode_Translator::_($attribs['legend']).'</div>';
        else
            $legend = '';
            
        $content = '<div id="'.$id.'_elements" class="elements">'.$content.'</div>';
            
        $html =
            '<div id="'.$id.'" class="display_group'.$class.'">'.
            $legend.
            $content.
            '</div>';

        return $html;
    }

}
