<?php

/**
 * =============================================================================
 * @file        Project/Issue/File.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: File.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_Issue_File
 * @brief   File model.
 */
class Project_Issue_File extends FreeCode_Doctrine_Record
{   
    
    public static $noAttachmentTypes = array(
        'image/jpeg',
        'image/png',
        'image/gif'
    );
    
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('project__issue__file');
        $this->option('type', 'MYISAM');
        
        $this->hasColumn('real_name', 'string', 255, array(
            'notnull' => true,
            'default' => ''
        ));
        $this->hasColumn('disk_name', 'string', 255, array(
            'notnull' => true,
            'default' => ''
        ));
        $this->hasColumn('size', 'integer', null, array(
            'notnull' => true,
            'default' => 0
        ));
        $this->hasColumn('mime_type', 'string', 255, array(
            'notnull' => true,
            'default' => ''
        ));
        $this->hasColumn('md5', 'string', 32, array(
            'notnull' => true,
            'default' => ''
        ));
        
        $this->hasColumn('time', 'integer');
        $this->hasColumn('author_id', 'integer');
        $this->hasColumn('issue_id', 'integer');
    }
    
    public function setUp()
    {
        parent::setUp();

        $this->hasOne('Project_Issue as issue', array(
            'local'     => 'issue_id',
            'foreign'   => 'id',
            'onDelete'  => 'CASCADE'
        ));
        
        $this->hasOne('User as author', array(
            'local'     => 'author_id',
            'foreign'   => 'id',
            'onDelete'  => 'CASCADE'
        ));
    }

    public function preInsert($event)
    {
        parent::preInsert($event);
        $this->time = time();
    }
    
    public function postUpdate($event)
    {
        parent::postInsert($event);
        ActivityObserver::getInstance()->notifyIssue($this->issue, Log::ACTION_FILE_ADD);
    }
    
    public function postDelete($event)
    {
        parent::postDelete($event);
        ActivityObserver::getInstance()->notifyIssue($this->issue, Log::ACTION_FILE_DELETE);
        @unlink(UPLOAD_ISSUES_DIR.'/'.$this->disk_name);
    }
    
    /**
     * Download the file.
     * @return void
     */
    public function download()
    {
        header("Content-Type: {$this->mime_type}");
        header("Content-Length: {$this->size}");
        header("Content-Transfer-Encoding: binary");
        
        if (!in_array($this->mime_type, self::$noAttachmentTypes))
            header("Content-Disposition: attachment; filename={$this->real_name};");
        
        $path = UPLOAD_ISSUES_DIR.'/'.$this->disk_name;
        if (!file_exists($path) || !is_readable($path))
            throw new FreeCode_Exception_IOError("Cannot read file '{$path}'!");
        @readfile($path);
    }

}
