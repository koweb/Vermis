<?php

/**
 * =============================================================================
 * @file        LogTable.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: LogTable.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   LogTable
 * @brief   Table for Log model.
 */
class LogTable extends FreeCode_Doctrine_Table
{

    /**
     * Get log query.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getLogQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine_Query::create()
            ->select("l.*, u.login, u.name, u.slug, p.name, p.slug")
            ->from("Log l, l.user u, l.project p")
            ->orderBy("l.id DESC")
            ->setHydrationMode($hydrationMode);
    }
    
}
