<?php

/**
 * =============================================================================
 * @file        Project/ComponentsController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ComponentsController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Project_ComponentsController
 * @brief   Components controller.
 */
class Project_ComponentsController extends Project_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'components';
        $this->view->headTitle()->prepend(_T('components'));
        $this->_breadCrumbs->addCrumb('components', 
            array('project_slug' => $this->_project->slug), 
            'project/components');
    }
    
    public function indexAction()
    {
        $componentsGrid = new Grid_Project_Components(
            array(
            	'projectId' => $this->_project->id,
            	'projectSlug' => $this->_project->slug
            ), 
            'project_components'.$this->_project->slug
        );
        $componentsGrid 
            ->restore()
            ->import();
        $this->view->componentsGrid = $componentsGrid;
    }
    
    public function newAction()
    {
        $this->_denyEditingForObservers();
        
        $this->_breadCrumbs->addCrumb('create_a_new_component');
        
        $form = new Form_Project_Component;
        $this->view->form = $form;
        
        $form->name->addValidator(new Validate_Project_Component($this->_project->id));

        if ($this->isPostRequest()) {
            if ($data = $this->validateForm($form)) {
                $component = new Project_Component;
                $component->setArray($data);
                $component->project_id = $this->_project->id;
                $component->description = stripslashes($data['description']);
                $component->name = stripslashes($data['name']);
                $component->author_id = $this->getIdentity()->id;
                $component->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("component_has_been_created");
                $this->goToAction(
                    array(
                        'project_slug' => $this->_project->slug,
                        'component_slug' => $component->slug
                    ), 
                    'project/components/show');
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function showAction()
    {
        $component = $this->fetchComponent();
        $this->view->component = $component;

        $params = array(
            'projectId' => $this->_project->id,
            'projectSlug' => $this->_project->slug,
            'componentId' => $component->id,
            'componentSlug' => $component->slug
        );
        
        if ($this->_identity) {
            $params['userId'] = $this->_identity->id;
        }
        
        $issuesGrid = new Grid_Project_Issues_Component(
            $params,
            'project_issues_component'.$this->_project->slug
        );
        $issuesGrid
            ->restore()
            ->import();
        $this->view->issuesGrid = $issuesGrid;
    }
    
    public function editAction()
    {
        $this->_denyEditingForObservers();
        
        $this->_breadCrumbs->addCrumb('edit');
        
        $component = $this->fetchComponent();
        $this->view->component = $component;
        
        $form = new Form_Project_Component;
        $this->view->form = $form;
        $form->populate($component->toArray());
        
        if ($this->isPostRequest()) {
            $data = $this->_request->getPost();
            
            if ($component->name != $data['name'])
                $form->name->addValidator(new Validate_Project_Component($this->_project->id));
            
            if ($data = $this->validateForm($form)) {
                $component->setArray($data);
                $component->description = stripslashes($data['description']);
                $component->name = stripslashes($data['name']);
                $component->changer_id = $this->getIdentity()->id;
                $component->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("changes_have_been_saved");
                $this->goToAction(
                    array(
                        'project_slug' => $this->_project->slug,
                        'component_slug' => $component->slug
                    ), 
                    'project/components/show');
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function deleteAction()
    {
        $component = $this->fetchComponent();
        $component->delete();
        $this->_flashMessages->addSuccess("component_has_been_deleted");
        $this->goToAction(array('project_slug' => $this->_project->slug), 
            'project/components');
    }
    
    public function historyAction()
    {
        $component = $this->fetchComponent();
        $this->view->component = $component;
        
        $this->_breadCrumbs->addCrumb('history');
        
        $versions = $component->fetchVersions();
        $this->view->changes = ChangeProcessor::process($versions);
    }
    
    public function fetchComponent()
    {
        $slug = $this->_request->getParam('component_slug');
        $component = Doctrine::getTable('Project_Component')
            ->fetchComponent($this->_project->id, $slug);
        if (!$component)
            throw new FreeCode_Exception_RecordNotFound('Project_Component');
        $this->_breadCrumbs->addCrumb($component->name,
            array(
                'project_slug' => $this->_project->slug, 
                'component_slug' => $component->slug
            ),
            'project/components/show');
        $this->view->headTitle()->prepend($component->name);
        return $component;
    }
}
