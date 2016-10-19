<?php

/**
 * =============================================================================
 * @file        FreeCode/Form.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Form.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Form
 * @brief   FreeCode base form.
 */
class FreeCode_Form extends Zend_Form
{

    protected $_isUploadEnabled = false;
    protected $_cssClasses = array();

    /**
     * Constructor.
     * @param   array   $options    
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
        
        $this->addElementPrefixPath('FreeCode_Form_Decorator', 'FreeCode/Form/Decorator/', 'decorator');
        $this->addDisplayGroupPrefixPath('FreeCode_Form_Decorator', 'FreeCode/Form/Decorator/');
        
        $this->setTranslator(FreeCode_Translator::getInstance());
    }

    /**
     * Overloaded to remove HtmlTag decorator.
     * @return  void
     */
    public function loadDefaultDecorators()
    {
        parent::loadDefaultDecorators();
        // Remove default stupid <dl> tag.
        $this->removeDecorator('HtmlTag');
    }

    /**
     * Render form, add custom decorators.
     * @param   Zend_View_Interface $view   
     * @return  void
     */
    public function render(Zend_View_Interface $view = null)
    {
        // Find all Zend_Form_Element_File instances.
        $fileElements = array();
        $elements = $this->getElements();
        foreach ($elements as $element) {
            if ($element instanceof Zend_Form_Element_File)
                $fileElements[] = $element->getName();
        }
        
        // Set decorators, exclude 'file' elements.
        $this->setElementDecorators(array('CustomXhtml'), $fileElements, false);

        $classes = '';
        foreach ($this->_cssClasses as $key => $class)
            $classes .= ' '.$class;
            
        $objClass = strtolower(get_class($this));
            
        $content = parent::render($view);
        return '<div id="'.$objClass.'" class="freecode_form'.$classes.'">'.$content.'</div>';
    }

    /**
     * Enable upload in form.
     * @note    Needed by FreeCode_Base_Controller.
     * @return  void
     */
    public function enableUpload()
    {
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->_isUploadEnabled = true;
    }

    /**
     * Returns true if upload is enabled, otherwise false.
     * @return  boolean
     */
    public function isUploadEnabled()
    {
        return $this->_isUploadEnabled;
    }

    /**
     * Receive upload from file element.
     * @param   Zend_Form_Element_File  $element    
     * @return  void
     */
    public function receiveUpload(Zend_Form_Element_File $element)
    {
        if (!$element->receive())
            throw new Exception("Upload from element '{$element->getName()}' failed!");
    }

    /**
     * Overloaded for adding custom decorators to display group.
     * @param   array   $elements   
     * @param   mixed   $name       
     * @param   mixed   $options    
     * @return  void
     */
    public function addDisplayGroup(array $elements, $name, $options = null)
    {
        $return = parent::addDisplayGroup($elements, $name, $options);
        
        $displayGroup = $this->getDisplayGroup($name);
        $displayGroup->removeDecorator('Fieldset');
        $displayGroup->removeDecorator('HtmlTag');
        $displayGroup->removeDecorator('DtDdWrapper');
        $displayGroup->addDecorator('CustomDisplayGroup');
        
        return $return;
    }
    
    /**
     * Add custom CSS class to form.
     * @param   string  $className  CSS class name.
     * @return  FreeCode_Form
     */
    public function addCssClass($className)
    {
        $this->_cssClasses[$className] = $className;
        return $this;
    }
    
    /**
     * Remove custom CSS class from form.
     * @param   string  $className  CSS class name.
     * @return  FreeCode_Form
     */
    public function removeCssClass($className)
    {
        unset($this->_cssClasses[$className]);
        return $this;
    }
    
    /**
     * Get CSS classes.
     * @return array
     */
    public function getCssClasses()
    {
        $temp = array();
        foreach ($this->_cssClasses as $key => $class)
            $temp[] = $class;
        return $temp;
    }
    
    /**
     * Set CSS classes.
     * @param   array   $classes
     * @return  FreeCode_Form
     */
    public function setCssClasses(array $classes)
    {
        $temp = array();
        foreach ($classes as $class)
            $temp[$class] = $class;
        $this->_cssClasses = $temp;
        return $this;
    }
    
}
