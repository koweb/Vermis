<?php

/**
 * =============================================================================
 * @file        FreeCode/Form/Decorator/CustomXhtml.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: CustomXhtml.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Form_Decorator_CustomXhtml
 * @brief   Custom form decorator.
 */
class FreeCode_Form_Decorator_CustomXhtml extends Zend_Form_Decorator_Abstract
{

    /**
     * Render element.
     * @param   string  $content
     * @return  string
     */
    public function render($content)
    {
        $element = $this->getElement();
        if (!$element instanceof Zend_Form_Element || $element->getView() === null)
            return $content;

        $class = 'container '.$this->_getElementClass();
        $id = $this->_getElementId();

        if (    $element instanceof Zend_Form_Element_Submit ||
                $element instanceof Zend_Form_Element_Reset) {
            $label = '';

        } else {
            $label = $this->_renderLabel();
        }

        $input = $this->_renderInput();
        $errors = $this->_renderErrors();
        $description = $this->_renderDescription();

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();

        $content = '<div class="box">'.$content.'</div>';

        switch ($placement) {
            case self::PREPEND:
                $input = $input.$separator.$content;
            case self::APPEND:
                $input = $content.$separator.$input;
        }

        $html =
            '<div id="'.$id.'" class="'.$class.'">'.
            $label.
            $input.
            $errors.
            $description.
            '</div>';

        return $html;
    }

    /**
     * Render element label.
     * @return  string
     */
    protected function _renderLabel()
    {
        $element = $this->getElement();
        $label = $element->getLabel();
        if ($translator = $element->getTranslator()) {
            $label = $translator->translate($label);
        }
        
        if (empty($label))
        	return '';
        
        //$label .= ($element->isRequired() ? '*' : ':');
        $label .= ':';

        $attribs = array();
        if ($element->isRequired()) {
            $attribs['class'] = 'label required';
        } else {
            $attribs['class'] = 'label';
        }

        return $element->getView()->formLabel($element->getName(), $label, $attribs);
    }

    /**
     * Render input tag.
     * @return  string
     */
    protected function _renderInput()
    {
        $element = $this->getElement();
        $class = $this->_getElementClass();

        // helper WTF?
        $attribs = $element->getAttribs();
        unset($attribs['helper']);

        // Set class.
        $attribs['class'] = 'element '.$class;

        if ($element instanceof Zend_Form_Element_Submit) {
            $helper = 'formButton';
            $attribs['content'] = $element->getLabel();
            $attribs['type'] = 'submit';

        } else if ($element instanceof Zend_Form_Element_Reset) {
            $helper = 'formButton';
            $attribs['content'] = $element->getLabel();
            $attribs['type'] = 'reset';

        } else if ($element instanceof Zend_Form_Element_Captcha) {
            return '';

        } else {
            $helper = $element->helper;
        }

        // Value hack.
        if ($element instanceof Zend_Form_Element_File) {
            $value = null;

        } else {
            $value = $element->getValue();
        }

        $html = $element->getView()->$helper(
            $element->getName(),
            $value,
            $attribs,
            $element->options
        );

        // XHTML bugfix.
        if (substr($html, -2, 2) != '/>' && !strstr($html, '</'))
            $html = substr($html, 0, -1).'/>';

        return '<div class="box '.$class.'">'.$html.'</div>';
    }

    /**
     * Render element errors.
     * @return  string 
     */
    protected function _renderErrors()
    {
        $element = $this->getElement();
        $messages = $element->getMessages();
        if (empty($messages))
            return '';
        // Old style.
        //return '<div class="errors">'.$element->getView()->formErrors($messages).'</div>';
        $html = '<div class="errors">';
        foreach ($messages as $key => $msg)
            $html .= nl2br($msg).'<br />';
        $html .= '</div>';
        return $html;
    }

    /**
     * Render element description.
     * @return  string
     */
    protected function _renderDescription()
    {
        $element = $this->getElement();
        $description = $element->getDescription();
        if (empty($description))
            return '';
        return '<div class="description">'.nl2br(_T($description)).'</div>';
    }

    /**
     * Get element class.
     * @return  string
     */
    protected function _getElementClass()
    {
        $class = get_class($this->getElement());
        $class = str_replace('Zend_Form_Element_', '', $class);
        return strtolower($class);
    }

    /**
     * Get element id.
     * @return  string
     */
    protected function _getElementId()
    {
        $name = $this->getElement()->getName();
        return $name.'_container';
    }

}
