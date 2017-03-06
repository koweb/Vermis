<?php

/**
 * =============================================================================
 * @file        Form/Project/SimpleIssue.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: SimpleIssue.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Form_Project_SimpleIssue
 * @brief   Issue form.
 */
class Form_Project_SimpleIssue extends FreeCode_Form
{
    
    protected $_userId = null;
    
    public function __construct($userId, $options = null)
    {
        parent::__construct($options);

        $this->_userId = $userId;
        
        $translator = $this->getTranslator();
        $translateItemFunc = function (&$key, $value, $trans) {
                    $key = $trans->translate($value);
                };
                
        array_walk(Project_Issue::$typeLabels, $translateItemFunc, $translator);
        
        $projectId = new Zend_Form_Element_Select('project_id');
        $projectId
            ->setLabel('project')
            ->setRequired(true)
            ->setMultiOptions($this->fetchProjectsAsOptions());
            
        $type = new Zend_Form_Element_Select('type');
        $type
            ->setLabel('type')
            ->setMultiOptions(Project_Issue::$typeLabels)
            ->setValue(Project_Issue::TYPE_TASK)
            ->setRequired(true);
        
        $title = new Zend_Form_Element_Text('title');
        $title
            ->setLabel('title')
            ->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(0, 255, 'UTF-8'));
            
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('description');
            
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $projectId,
            $type,
            $title,
            $description,
            $submit
        ));
    }
    
    public function fetchProjectsAsOptions()
    {
        $options = array();
        $records = Doctrine::getTable('Project')
            ->getAvailableProjectsQuery($this->_userId)
            ->select("p.id, p.name")
            ->execute();
        foreach ($records as $record)
            $options[$record['id']] = $record['name'];
        return $options;
    }
    
}
