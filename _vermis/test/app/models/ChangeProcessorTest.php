<?php

/**
 * =============================================================================
 * @file        ChangeProcessorTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ChangeProcessorTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   ChangeProcessorTest
 */
class ChangeProcessorTest extends Test_PHPUnit_TestCase 
{

    public function testProcess1()
    {
        $p = ChangeProcessor::process(array());
        $this->assertTrue(is_array($p));
        $this->assertTrue(empty($p));
    }
    
    public function testProcess2()
    {
        $changes = array(
            array(
                'id' => 123,
                'col1' => 'abc',
                'col2' => 'def'
            )
        );
        
        $p = ChangeProcessor::process($changes);
        $this->assertTrue(is_array($p));
        $this->assertEquals(1, count($p));
        
        $this->assertEquals(3, count($p[0]));
        $this->assertEquals(123, $p[0]['id']);
        $this->assertEquals('abc', $p[0]['col1']);
        $this->assertEquals('def', $p[0]['col2']);
    }
    
    public function testProcess3()
    {
        $changes = array(
            array(
                'id' => 123,
                'col1' => 'abc',
                'col2' => 'def',
                'version' => 2, 
            ),
            array(
                'id' => 123,
                'col1' => 'xxx',
                'col2' => 'def',
                'version' => 1
            ),
        );
        
        $p = ChangeProcessor::process($changes);
        $this->assertTrue(is_array($p));
        $this->assertEquals(2, count($p));
        
        $this->assertEquals(3, count($p[0]));
        $this->assertEquals(123, $p[0]['id']);
        $this->assertEquals('abc', $p[0]['col1']);

        $this->assertEquals(4, count($p[1]));
        $this->assertEquals(123, $p[1]['id']);
        $this->assertEquals('xxx', $p[1]['col1']);
        $this->assertEquals('def', $p[1]['col2']);
    }
    
}
