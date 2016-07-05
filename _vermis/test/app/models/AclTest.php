<?php

/**
 * =============================================================================
 * @file        AclTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: AclTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
