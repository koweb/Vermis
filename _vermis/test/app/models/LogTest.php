<?php

/**
 * =============================================================================
 * @file        LogTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: LogTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   LogTest
 */
class LogTest extends Test_PHPUnit_DbTestCase 
{
    
    public function testAppend()
    {
        $user = Doctrine::getTable('User')->find(1);
        $project = Doctrine::getTable('Project')->find(1);
        
        Log::append(
            $user->id,
            $project->id,
            123,
            Log::TYPE_PROJECT,
            Log::ACTION_NOTICE,
            'abc',
            array(1, 2, 3)
        );
        
        $query = Doctrine::getTable('Log')->getLogQuery()->limit(1);
        $records = $query->execute();
        
        $this->assertTrue(isset($records[0]));
        $log = $records[0];
        
        $this->assertEquals($user->id, $log['user_id']);
        $this->assertEquals($project->id, $log['project_id']);
        $this->assertEquals(123, $log['resource_id']);
        $this->assertEquals(Log::TYPE_PROJECT, $log['resource_type']);
        $this->assertEquals(Log::ACTION_NOTICE, $log['action']);
        $this->assertEquals('abc', $log['message']);
        $this->assertEquals(3, count(unserialize($log['params'])));
    }
    
}
