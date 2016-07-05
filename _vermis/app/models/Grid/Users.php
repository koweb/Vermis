<?php

/**
 * =============================================================================
 * @file        Grid/Users.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Users.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Users
 * @brief Users grid.
 */
class Grid_Users extends Grid 
{
    
    public function __construct($id = 'users')
    {
        parent::__construct($id);
        
        $login = new FreeCode_Grid_Column('login');
        $login
            ->setTitle('username')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_UserLink);
        
        $name = new FreeCode_Grid_Column('name');
        $name
            ->setTitle('display_name')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_UserLink);
        
        $email = new FreeCode_Grid_Column('email');
        $email
            ->setTitle('email')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_MailTo);

        $createTime = new FreeCode_Grid_Column('create_time');
        $createTime
            ->setTitle('created_at')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_Date);

        $this
            ->setImporter(new Grid_Importer_Users)
            ->addColumns(array(
                $login,
                $name,
                $email,
                $createTime
            ))
            ->setSortColumn('login')
            ->setSortOrder('asc')
            ->setAjaxAction($this->getView()->url(array(), 'grid'))
            ->setExportAction($this->getView()->url(array(), 'grid/export'));

        $this
            ->getToolbar('top')
            ->getElement('title')
            ->setCaption('users');
    }
    
}
