<?php

/**
 * =============================================================================
 * @file        ChangeProcessorTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ChangeProcessorTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
        $this->assertType('array', $p);
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
        $this->assertType('array', $p);
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
        $this->assertType('array', $p);
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
