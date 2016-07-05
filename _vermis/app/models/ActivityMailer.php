<?php

/**
 * =============================================================================
 * @file        ActivityMailer.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ActivityMailer.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   ActivityMailer
 * @brief   Activity mailer
 */
class ActivityMailer
{
    
    protected $_config = null;
    
    protected function __construct() 
    {
        Application::getInstance()
            ->setupTranslator()
            ->setupRouter();
            
        $this->_config = FreeCode_Config::getInstance();
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
    
    public function notifyProjectMembers(
        $userId,
        $projectId,
        $resourceId,
        $resourceType,
        $action,
        $message = '',
        $params = array(),
        $misc = array())
   {
        if (!$this->_config->mailer || !$this->_config->mailer->enable)
            return false;
        
        $identity = FreeCode_Identity::getInstance();

        $user = Doctrine::getTable('User')->find($userId);
        if (!$user)
            throw new FreeCode_Exception_RecordNotFound('User');
        
        $members = Doctrine::getTable('Project_Member')
            ->getProjectMembersQuery($projectId)
            ->addWhere('u.email_notify = true')
            ->execute();
        
        $titleHeader = $this->_config->mailer->titleHeader;
        $subject = '['.$titleHeader.'] '._T($resourceType).' '.$message.' ('._T($action.' by').' '.$user->name.')';
        
        switch ($action) {
            case Log::ACTION_INSERT:
            case Log::ACTION_ISSUE_CLOSED:
            case Log::ACTION_ISSUE_IN_PROGRESS:
            case Log::ACTION_ISSUE_OPENED:
            case Log::ACTION_ISSUE_RESOLVED:
            case Log::ACTION_UPDATE:
                $history = $this->takeHistory($resourceType, $resourceId);
                break;
            default:
                $history = array();
        }
        
        foreach ($members as $member) {
            // Skip user that have made a change.
            if ($identity && $identity->id == $member['user']['id'])
                continue; 
            
            $mail = new FreeCode_Mail('activity.phtml');
            
            $mail->view->action = $action;
            $mail->view->message = $message;
            $mail->view->resourceType = $resourceType;
            $mail->view->params = $params;
            $mail->view->user = $user;
            $mail->view->misc = $misc;
            $mail->view->changes = array($history);
            
            $mail->addTo($member['user']['email']);
            $mail->setSubject($subject);
            $mail->send();
            unset($mail);
        }
        
        return true;
   }

   /**
    * Send an email to each admin about newly registered user.
    * @param User $user
    * @return boolean
    */
   public function notifyAdminsAboutNewcomer(User $user)
   {
        if (!$this->_config->mailer || !$this->_config->mailer->enable)
            return false;
        
       $admins = Doctrine::getTable('User')
       ->getUsersListQuery()
       ->addWhere("u.role = ?", User::ROLE_ADMIN)
       ->execute();
       foreach ($admins as $admin) {
           $mail = new FreeCode_Mail('newcomer.phtml');
           $mail->view->user = $user;
           $mail->addTo($admin['email']);
           $mail->setSubject('['.$this->_config->mailer->titleHeader.'] New account has been registered');
           $mail->send();
       }
       
       return true;
   }
   
    public function takeHistory($resourceType, $resourceId)
    {
        switch ($resourceType) {
            case Log::TYPE_PROJECT: $tableName = 'Project'; break;
            case Log::TYPE_COMPONENT: $tableName = 'Project_Component'; break;
            case Log::TYPE_ISSUE: $tableName = 'Project_Issue'; break;
            case Log::TYPE_MILESTONE: $tableName = 'Project_Milestone'; break;
            case Log::TYPE_NOTE: $tableName = 'Project_Note'; break;
        }    
        
        $obj = Doctrine::getTable($tableName)->find((int) $resourceId);
        if (!$obj)
            throw new FreeCode_Exception_RecordNotFound("Resource not found!");
        // Return latest changes.
        $changes = ChangeProcessor::process($obj->fetchVersions(2));
        if (count($changes) == 0)
            return $obj->toArray();
        return $changes[0]; 
    }
   
}
