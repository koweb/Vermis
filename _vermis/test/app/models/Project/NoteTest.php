<?php

/**
 * =============================================================================
 * @file        Project/NoteTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: NoteTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
        $this->assertTrue(is_array($versions));
        $this->assertEquals(2, count($versions));
        $this->assertEquals('xxx', $versions[0]['content']);
    }
    
}
