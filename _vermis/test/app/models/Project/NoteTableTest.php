<?php

/**
 * =============================================================================
 * @file        Project/NoteTableTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: NoteTableTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_NoteTableTest
 */
class Project_NoteTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    protected $_project = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_table = Doctrine::getTable('Project_Note');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('Project1');   
    }
    
    public function testTable()
    {
        $this->assertTrue($this->_table instanceof Project_NoteTable);
    }
    
    public function testGetProjectNotesQuery()
    {
        $query = $this->_table->getProjectNotesQuery($this->_project->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $notes = $query->execute();
        $this->assertEquals(3, count($notes));
        $this->assertEquals('note 1', $notes[0]['title']);
        foreach ($notes as $note) {
            $this->assertEquals($this->_project->id, $note['project_id']);
        }
    }
    
    public function testNoteExists()
    {
        $this->assertTrue($this->_table->noteExists($this->_project->id, 'note-1'));
        $this->assertFalse($this->_table->noteExists($this->_project->id, 'note-4'));
    }
    
    public function testFetchNote()
    {
        $note = $this->_table->fetchNote($this->_project->id, 'note-1');
        $this->assertTrue($note instanceof Project_Note);
        $this->assertEquals('note 1', $note->title);     
    }
    
    public function testFetchNoteId()
    {
        $id = $this->_table->fetchNoteId($this->_project->id, 'note-1');
        $note = $this->_table->find($id);
        $this->assertTrue($note instanceof Project_Note);
        $this->assertEquals('note 1', $note->title);     
    }
    
}
