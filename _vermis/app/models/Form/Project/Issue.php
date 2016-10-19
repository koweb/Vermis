<?php

/**
 * =============================================================================
 * @file        Form/Project/Issue.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Issue.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Form_Project_Issue
 * @brief   Issue form.
 */
class Form_Project_Issue extends FreeCode_Form
{
    
    protected $_projectId = null;
    
    public function __construct($projectId, $options = null)
    {
        parent::__construct($options);

        $this->_projectId = $projectId;
        
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
            
        $priority = new Zend_Form_Element_Select('priority');
        $priority
            ->setLabel('priority')
            ->setRequired(true)
            ->setMultiOptions(Project_Issue::$priorityLabels)
            ->setValue(Project_Issue::PRIORITY_NORMAL);
            
        $status = new Zend_Form_Element_Select('status');
        $status
            ->setLabel('status')
            ->setRequired(true)
            ->setMultiOptions(Project_Issue::$statusLabels)
            ->setValue(Project_Issue::STATUS_OPENED);
            
        $componentId = new Zend_Form_Element_Select('component_id');
        $componentId
            ->setLabel('component')
            ->setRequired(true)
            ->setMultiOptions($this->fetchComponentsAsOptions());
            
        $milestoneId = new Zend_Form_Element_Select('milestone_id');
        $milestoneId
            ->setLabel('milestone')
            ->setRequired(true)
            ->setMultiOptions($this->fetchMilestonesAsOptions());
            
        $assigneeId = new Zend_Form_Element_Select('assignee_id');
        $assigneeId
            ->setLabel('assignee')
            ->setRequired(true)
            ->setMultiOptions(
                Doctrine::getTable('Project_Member')
                    ->fetchMembersAsOptions($this->_projectId));

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('description');
            
        $progress = new Zend_Form_Element_Select('progress');
        $progress
            ->setLabel('progress')
            ->setRequired(true)
            ->setMultiOptions($this->getProgressOptions());
            
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $type,
            $title,
            $status,
            $priority,
            $componentId,
            $milestoneId,
            $assigneeId,
            $progress,
            $description,
            $submit
        ));
    }
    
    public function fetchComponentsAsOptions()
    {
        $options = array();
        $options[0] = '- none -';
        $records = Doctrine::getTable('Project_Component')
            ->getProjectComponentsQuery($this->_projectId)
            ->select("c.id, c.name")
            ->execute();
        foreach ($records as $record)
            $options[$record['id']] = $record['name'];
        return $options;
    }
    
    public function fetchMilestonesAsOptions()
    {
        $options = array();
        $options[0] = '- none -';
        $records = Doctrine::getTable('Project_Milestone')
            ->getProjectMilestonesQuery($this->_projectId)
            ->select("m.id, m.name")
            ->execute();
        foreach ($records as $record)
            $options[$record['id']] = $record['name'];
        return $options;
    }
    
    public function getProgressOptions()
    {
        $options = array();
        for ($i = 0; $i <= 100; $i += 10) 
            $options[$i] = $i.'%';
        return $options;
    }

}
