<?php

/**
 * =============================================================================
 * @file        Project/Issues/FilesController.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: FilesController.php 119 2011-01-29 23:37:20Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_Issues_FilesController
 * @brief   Issues files controller.
 */
class Project_Issues_FilesController extends Project_Controller
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
    
    public function uploadAction()
    {
        $form = new Form_Upload();
        
        if ($this->isPostRequest()) {
            if ($data = $this->validateForm($form)) {
                
                $f = $data['files']['file'];
                
                $file = new Project_Issue_File;
                $file->save();

                $diskName = $file->id.'-'.$f['md5'];
                $path = UPLOAD_ISSUES_DIR.'/'.$diskName;
                @rename($f['path'], $path);
                
                if (!file_exists($path))
                    throw new FreeCode_Exception_IOError("cannot_move_uploaded_file");
                
                $file->real_name = $f['fileName'];
                $file->size = $f['size'];
                $file->mime_type = $f['type'];
                $file->md5 = $f['md5'];
                $file->disk_name = $diskName;
                $file->author_id = $this->_identity->id;
                $file->issue_id = $this->_issue->id;
                $file->save();

                $this->view->success = true;
                $this->_flashMessages->addSuccess("file_has_been_uploaded");
                
            } else {
                $this->_flashMessages->addError("upload_filed");
                $this->view->success = false;
            }
        }

        $this->goBack();
    }
    
    public function downloadAction()
    {
        $this->disableLayout();
        $this->disableView();
        $file = $this->fetchFile();
        $file->download();
    }
    
    public function deleteAction()
    {
        $file = $this->fetchFile();
        $file->delete();
        $this->_flashMessages->addSuccess("file_has_been_deleted");
        $this->goBack();
    }
    
    public function fetchFile()
    {
        $id = (int) $this->_request->getParam('file_id');
        $file = Doctrine::getTable('Project_Issue_File')->find($id);
        if (!$file)
            throw new FreeCode_Exception_RecordNotFound('Project_Issue_File');
        if ($file->issue_id != $this->_issue->id)
            throw new FreeCode_Exception_AccessDenied();
        return $file;
    }
    
}
