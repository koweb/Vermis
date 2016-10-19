<?php

/**
 * =============================================================================
 * @file        Grid/Project/Members.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Members.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class Grid_Project_Members
 * @brief Members grid.
 */
class Grid_Project_Members extends Grid 
{
    
    public function __construct(array $params, $id = 'members')
    {
        parent::__construct($id);
        
        $name = new FreeCode_Grid_Column('name');
        $name
            ->setTitle('display_name')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_UserLink);
        
        $role = new FreeCode_Grid_Column('role');
        $role
            ->setTitle('role')
            ->setSortable(true);
            
        $userId = new FreeCode_Grid_Column('user_id');
        $userId->setHidden(true);
            
        $this
            ->setImporter(new Grid_Importer_Project_Members($params))
            ->addColumns(array(
                $name,
                $role,
                $userId
            ))
            ->setSortColumn('name')
            ->setSortOrder('asc')
            ->setAjaxAction($this->getView()->url(
                array('project_slug' => $params['projectSlug']), 
                'project/grid'))
            ->setExportAction($this->getView()->url(
                array('project_slug' => $params['projectSlug']), 
                'project/grid/export'));
                
        $this->getToolbar('top')->getElement('title')
            ->setCaption('Project members');  
            
        if (isset($params['userId'])) {
            $user = Doctrine::getTable('User')->find((int) $params['userId']);
            if (!$user)
                throw new FreeCode_Exception_RecordNotFound("User");
            
            if ($user->isAdmin()) {
                $this
                    ->enableMultiselect(true)
                    ->setMultiselectColumn('user_id');
        
                    $removeButton = new FreeCode_Grid_Button_Multiselect('remove');
                    $removeButton
                        ->setCaption('remove')
                        ->setHref($this->getView()->url(
                            array('project_slug' => $params['projectSlug']),
                			'project/members/delete'
                        ))
                        ->setFloat(FreeCode_Grid_Element::FLOAT_LEFT);
                    $this->getToolbar('bottom')->addElement($removeButton);
            }
        }
    }
    
}
