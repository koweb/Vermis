<?php

/**
 * =============================================================================
 * @file        Project/NoteTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NoteTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_NoteTest
 */
class Project_NoteTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_note = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_note = Doctrine::getTable('Project_Note')->find(1);
    }

    public function testIncomplete()
    {
        /// @TODO: Process isolation bug!
        //$this->markTestIncomplete();
    }
    
    public function testFetchVersions()
    {
        $this->_note->content = 'xxx';
        $this->_note->save();
        
        $versions = $this->_note->fetchVersions();
        $this->assertType('array', $versions);
        $this->assertEquals(2, count($versions));
        $this->assertEquals('xxx', $versions[0]['content']);
    }
    
}
