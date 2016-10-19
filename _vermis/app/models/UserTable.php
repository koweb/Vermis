<?php

/**
 * =============================================================================
 * @file        UserTable.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UserTable.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   UserTable
 * @brief   Table for User model.
 */
class UserTable extends FreeCode_UserTable
{
	
    /**
     * @brief   Get users list.
     * @return  Doctrine_Query
     */
    public function getUsersListQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $query = Doctrine_Query::create();
        $query
            ->select("u.*")
            ->from("User u")
            ->orderBy("u.role ASC, u.login ASC, u.name ASC, u.email ASC")
            ->setHydrationMode($hydrationMode);
        return $query;
    }
    
    /**
     * Fetch users as options.
     * @param int $projectId
     * @return array
     */
    public function fetchUsersAsOptions()
    {
        $options = array();
        $options[0] = '- any -';
        $records = $this->getUsersListQuery()
            ->select("id, name")
            ->execute();
        foreach ($records as $record)
            $options[$record['id']] = $record['name'];
        return $options;
    }
    
}
