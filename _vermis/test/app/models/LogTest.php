<?php

/**
 * =============================================================================
 * @file        LogTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: LogTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
