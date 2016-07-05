<?php

/**
 * =============================================================================
 * @file        GridController.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: GridController.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   GridController
 * @brief   Grid controller.
 */
class GridController extends FreeCode_Grid_Controller
{

    public function init()
    {
        parent::init();

        $params = array();
        if ($this->_identity) {
            if (!$this->_identity->isAdmin())
                $params['userId'] = $this->_identity->id;
        } else {
            $params['publicOnly'] = true;
        }
        
        $this
            ->registerGrid(new Grid_Projects($params))
            ->registerGrid(new Grid_Project_Issues_Search($params))
            ;
            
        if ($this->_identity) {
            
            $this->registerGrid(new Grid_Users);
            
            $params = array(
                'userId' => $this->_identity->id,
                'userSlug' => $this->_identity->slug
            );
            $this->registerGrid(new Grid_Project_Issues_My($params, 'issues_my_dashboard'));
        }
        
        $this
            ->registerGrid(new Grid_Project_Issues_Latest($params, 'issues_latest_dashboard'))
            ->registerGrid(new Grid_Project_Issues_Navigator($params, 'issues_navigator_dashboard'));
            
        $userSlug = $this->_request->getParam('user_slug');
        if (!empty($userSlug)) {
            $user = Doctrine::getTable('User')->findOneBySlug($userSlug);
            if (!$user)
                throw new FreeCode_Exception_RecordNotFound("User");
            $params = array(
                'userId' => $user->id,
                'userSlug' => $user->slug,
                'identityId' => $this->_identity->id
            );    
            $this
                ->registerGrid(new Grid_Project_Issues_Assigned($params))
                ->registerGrid(new Grid_Project_Issues_Reported($params));
        }
    }

}
