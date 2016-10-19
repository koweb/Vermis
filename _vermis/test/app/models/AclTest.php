<?php

/**
 * =============================================================================
 * @file        AclTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: AclTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   AclTest
 */
class AclTest extends Test_PHPUnit_TestCase 
{
    
    public function testClass()
    {
        $acl = new Acl;

        $roleGuest     = new Zend_Acl_Role(User::ROLE_GUEST);
        $roleUser      = new Zend_Acl_Role(User::ROLE_USER);
        $roleAdmin     = new Zend_Acl_Role(User::ROLE_ADMIN);
        
        $this->assertTrue($acl->hasRole($roleGuest));
        $this->assertTrue($acl->hasRole($roleUser));
        $this->assertTrue($acl->hasRole($roleAdmin));
        
        $this->assertTrue($acl->has(new Zend_Acl_Resource('default')));
        $this->assertTrue($acl->has(new Zend_Acl_Resource('project')));
    }
    
}
