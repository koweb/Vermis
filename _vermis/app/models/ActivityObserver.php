<?php

/**
 * =============================================================================
 * @file        ActivityObserver.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ActivityObserver.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   ActivityObserver
 * @brief   Activity observer
 */
class ActivityObserver
{

    protected $_identityId = 1; /// @TODO: default admin account
    
    protected function __construct() 
    {
        if ($identity = FreeCode_Identity::getInstance())
            $this->_identityId = $identity->id;
    }
    
    /**
     * Get instance (singleton).
     * @return  ActivityObserver
     */
    public function getInstance()
    {
        static $instance;
        if (!isset($instance))
            $instance = new self;
        return $instance;
    }
    
    /**
     * Notify project change.
     * @param $project
     * @param $actionType
     * @return  ActivityObserver
     */
    public function notifyProject(Project $project, $actionType)
    {
        Log::append(
            $this->_identityId,
            $project->id,
            $project->id,
            Log::TYPE_PROJECT,
            $actionType,
            $project->name,
            array('project_slug' => $project->slug));

        ActivityMailer::getInstance()->notifyProjectMembers(
            $this->_identityId,
            $project->id,
            $project->id,
            Log::TYPE_PROJECT,
            $actionType,
            $project->name,
            array('project_slug' => $project->slug));
           
        return $this;
    }

    /**
     * Notify component change.
     * @param $project
     * @param $actionType
     * @return  ActivityObserver
     */
    public function notifyComponent(Project_Component $component, $actionType)
    {
        Log::append(
            $this->_identityId,
            $component->project->id,
            $component->id,
            Log::TYPE_COMPONENT,
            $actionType,
            $component->name,
            array(
                'project_slug'      => $component->project->slug,
                'component_slug'    => $component->slug
            ));
        
        ActivityMailer::getInstance()->notifyProjectMembers(
            $this->_identityId,
            $component->project->id,
            $component->id,
            Log::TYPE_COMPONENT,
            $actionType,
            $component->name,
            array(
                'project_slug'      => $component->project->slug,
                'component_slug'    => $component->slug
            ));
            
        return $this;
    }

    /**
     * Notify milestone change.
     * @param $project
     * @param $actionType
     * @return  ActivityObserver
     */
    public function notifyMilestone(Project_Milestone $milestone, $actionType)
    {
        Log::append(
            $this->_identityId,
            $milestone->project->id,
            $milestone->id,
            Log::TYPE_MILESTONE,
            $actionType,
            $milestone->name,
            array(
                'project_slug'      => $milestone->project->slug,
                'milestone_slug'    => $milestone->slug
            ));
        
        ActivityMailer::getInstance()->notifyProjectMembers(
            $this->_identityId,
            $milestone->project->id,
            $milestone->id,
            Log::TYPE_MILESTONE,
            $actionType,
            $milestone->name,
            array(
                'project_slug'      => $milestone->project->slug,
                'milestone_slug'    => $milestone->slug
            ));
            
        return $this;
    }

    /**
     * Notify issue change.
     * @param $project
     * @param $actionType
     * @return  ActivityObserver
     */
    public function notifyIssue(Project_Issue $issue, $actionType, $misc = array())
    {
        /// @TODO: Doctrine bug or i fucked up something :S
        $p = $issue->project->toArray();
        $pName = (empty($p['name']) ? $p['project_name'] : $p['name']);
        $pSlug = (empty($p['slug']) ? $p['project_slug'] : $p['slug']);
        
        Log::append(
            $this->_identityId,
            $issue->project_id,
            $issue->id,
            Log::TYPE_ISSUE,
            $actionType,
            "{$pName}-{$issue->number} # {$issue->title}",
            array(
                'project_slug'      => $pSlug,
                'issue_number'      => $issue->number,
                'issue_slug'        => $issue->slug
            ));
        
        ActivityMailer::getInstance()->notifyProjectMembers(
            $this->_identityId,
            $issue->project->id,
            $issue->id,
            Log::TYPE_ISSUE,
            $actionType,
            "{$pName}-{$issue->number} # {$issue->title}",
            array(
                'project_slug'      => $pSlug,
                'issue_number'      => $issue->number,
                'issue_slug'        => $issue->slug
            ),
            $misc
        );
            
        return $this;
    }

    /**
     * Notify note change.
     * @param $project
     * @param $actionType
     * @return  ActivityObserver
     */
    public function notifyNote(Project_Note $note, $actionType)
    {
        Log::append(
            $this->_identityId,
            $note->project->id,
            $note->id,
            Log::TYPE_NOTE,
            $actionType,
            $note->title,
            array(
                'project_slug' => $note->project->slug,
                'note_slug'    => $note->slug
            ));
        
        ActivityMailer::getInstance()->notifyProjectMembers(
            $this->_identityId,
            $note->project->id,
            $note->id,
            Log::TYPE_NOTE,
            $actionType,
            $note->title,
            array(
                'project_slug' => $note->project->slug,
                'note_slug'    => $note->slug
            ));
            
        return $this;
    }

}
