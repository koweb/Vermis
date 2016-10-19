<?php

/**
 * =============================================================================
 * @file        FreeCode/Form/Decorator/CustomDisplayGroup.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: CustomDisplayGroup.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
