<?php

/**
 * =============================================================================
 * @file        Project/MemberTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MemberTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_MemberTest
 */
class Project_MemberTest extends Test_PHPUnit_DbTestCase 
{
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupTranslator();
    }

    public function testGetRoleLabel()
    {
        $this->assertEquals('Leader', 
            Project_Member::getRoleLabel(Project_Member::ROLE_LEADER));
        $this->assertEquals('unknown', Project_Member::getRoleLabel('unknown'));
    }
    
}
