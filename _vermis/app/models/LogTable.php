<?php

/**
 * =============================================================================
 * @file        LogTable.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: LogTable.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
