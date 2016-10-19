<?php

/**
 * =============================================================================
 * @file        Project/Issues/CommentsController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: CommentsController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Project_Issues_CommentsController
 * @brief   Issues comments controller.
 */
class Project_Issues_CommentsController extends Project_Controller
{

    protected $_issue = null;
    
    public function init()
    {
        parent::init();
        $number = (int) $this->_request->getParam('issue_number');
        $this->_issue = Doctrine::getTable('Project_Issue')
            ->fetchIssue($this->_project->id, $number);
        if (!$this->_issue)
            throw new FreeCode_Exception_RecordNotFound('Project_Issue');
    } 
    
    public function addAction()
    {
        $form = new Form_Comment;
        
        if ($this->isPostRequest()) {
            if ($data = $this->validateForm($form)) {
                $comment = new Project_Issue_Comment;
                $comment->content = stripslashes($data['content']);
                $comment->author_id = $this->_identity->id;
                $comment->issue_id = $this->_issue->id;
                $comment->save();
                
                $this->view->success = true;
                $this->_flashMessages->addSuccess("comment_has_been_saved");
                
            } else {
                $this->view->success = false;
            }
        }
        
        $this->goBack();
    }
    
    public function deleteAction()
    {
        $id = (int) $this->_request->getParam('comment_id');
        $comment = Doctrine::getTable('Project_Issue_Comment')->find($id);
        if (!$comment)
            throw new FreeCode_Exception_RecordNotFound('Project_Issue_Comment');
        $comment->delete();
        $this->_flashMessages->addSuccess("comment_has_been_deleted");
        $this->goBack();
    }
    
}
