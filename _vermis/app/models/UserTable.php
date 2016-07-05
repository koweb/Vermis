<?php

/**
 * =============================================================================
 * @file        UserTable.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: UserTable.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
