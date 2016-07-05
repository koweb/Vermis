<?php

/**
 * =============================================================================
 * @file        Project/NotesController.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NotesController.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_NotesController
 * @brief   Notes controller.
 */
class Project_NotesController extends Project_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'notes';
        $this->view->headTitle()->prepend(_T('notes'));
        $this->_breadCrumbs->addCrumb('notes', 
            array('project_slug' => $this->_project->slug), 
            'project/notes');
    }
    
    public function indexAction()
    {
        $notesGrid = new Grid_Project_Notes(
            array(
            	'projectId' => $this->_project->id,
            	'projectSlug' => $this->_project->slug
            ),
            'project_notes'.$this->_project->slug
        );
        $notesGrid
            ->restore()
            ->import();
        $this->view->notesGrid = $notesGrid;
    }
    
    public function newAction()
    {
        $this->_denyEditingForObservers();
        
        $this->_breadCrumbs->addCrumb('create_a_new_note');
        
        $form = new Form_Project_Note;
        $this->view->form = $form;
        
        $form->title->addValidator(new Validate_Project_Note($this->_project->id));

        if ($this->isPostRequest()) {
            if ($data = $this->validateForm($form)) {
                $note = new Project_Note;
                $note->setArray($data);
                $note->project_id = $this->_project->id;
                $note->content = stripslashes($data['content']);
                $note->title = stripslashes($data['title']);
                $note->author_id = $this->getIdentity()->id;
                $note->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("note_has_been_created");
                $this->goToAction(
                    array(
                        'project_slug' => $this->_project->slug,
                        'note_slug' => $note->slug
                    ), 
                    'project/notes/show');
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function showAction()
    {
        $note = $this->fetchNote();
        $this->view->note = $note;
    }
    
    public function editAction()
    {
        $this->_denyEditingForObservers();
        
        $this->_breadCrumbs->addCrumb('edit');
        
        $note = $this->fetchNote();
        $this->view->note = $note;
        
        $form = new Form_Project_Note;
        $this->view->form = $form;
        $form->populate($note->toArray());
        
        if ($this->isPostRequest()) {
            $data = $this->_request->getPost();
            
            if ($note->title != $data['title'])
                $form->title->addValidator(new Validate_Project_Note($this->_project->id));
            
            if ($data = $this->validateForm($form)) {
                $note->setArray($data);
                $note->content = stripslashes($data['content']);
                $note->title = stripslashes($data['title']);
                $note->changer_id = $this->getIdentity()->id;
                $note->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("changes_have_been_saved");
                $this->goToAction(
                    array(
                        'project_slug' => $this->_project->slug,
                        'note_slug' => $note->slug
                    ), 
                    'project/notes/show');
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function deleteAction()
    {
        $note = $this->fetchNote();
        $note->delete();
        $this->_flashMessages->addSuccess("note_has_been_deleted");
        $this->goToAction(array('project_slug' => $this->_project->slug), 
            'project/notes');
    }
    
    public function historyAction()
    {
        $note = $this->fetchNote();
        $this->view->note = $note;
        
        $this->_breadCrumbs->addCrumb('History');
        
        $versions = $note->fetchVersions();
        $this->view->changes = ChangeProcessor::process($versions);
    }
    
    public function fetchNote()
    {
        $slug = $this->_request->getParam('note_slug');
        $note = Doctrine::getTable('Project_Note')
            ->fetchNote($this->_project->id, $slug);
        if (!$note)
            throw new FreeCode_Exception_RecordNotFound('Project_Note');
        $this->_breadCrumbs->addCrumb($note->title,
            array(
                'project_slug' => $this->_project->slug, 
                'note_slug' => $note->slug
            ),
            'project/notes/show');
        $this->view->headTitle()->prepend($note->title);
        return $note;
    }
    
}
