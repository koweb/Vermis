<?php

/**
 * =============================================================================
 * @file        Default/UsersControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UsersControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Default_UsersControllerTest
 */
class Default_UsersControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    public function setUp()
    {
        parent::setUp();
        $this->login('admin', 'admin');  
    }
    
    public function testIndexAction()
    {
        $controller = $this->getController('UsersController');
        $controller->indexAction();
        $this->assertTrue(
            $controller->view->usersGrid instanceof Grid_Users);
    }
    
    public function testNewAction_Success()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'someuser',
                'role'              => User::ROLE_USER,
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Some user',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
            
        $controller = $this->getController('UsersController');
        $controller->newAction();
        $this->_assertNumberOfUsers(5);
        $this->assertTrue($controller->view->success);
        
        $user = Doctrine::getTable('User')->findOneByLogin('someuser');
        $this->assertTrue($user instanceof User);
        $this->assertEquals('Some-user', $user->slug);
    }
    
    public function testNewAction_LoginFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'admin',
                'role'              => User::ROLE_USER,
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Some user',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertNewActionFail();
    }
    
    public function testNewAction_TooLongLoginFail()
    {
        $login = str_repeat('abc', 100); // 300 characters.
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => $login,
                'role'              => User::ROLE_USER,
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Some user',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertNewActionFail();
    }
    
    public function testNewAction_TooLongNameFail()
    {
        $name = str_repeat('abc', 100); // 300 characters.
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'some-user',
                'role'              => User::ROLE_USER,
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => $name,
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertNewActionFail();
    }
    
    public function testNewAction_SlugFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'someuser',
                'role'              => User::ROLE_USER,
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Admin-User',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertNewActionFail();
    }
    
    public function testNewAction_EmailFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'someuser',
                'role'              => User::ROLE_USER,
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Some User',
                'email'             => 'email1@email.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertNewActionFail();
    }
    
    public function testNewAction_MismatchPasswordsFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'someuser',
                'role'              => User::ROLE_USER,
                'password'          => 'some password',
                'password_repeat'   => 'some password xxx',
                'name'              => 'Some User',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertNewActionFail();
    }
    
    public function testShowAction()
    {
        $this->request->setParam('user_slug', 'Admin-User');
        $controller = $this->getController('UsersController');
        $controller->showAction();
        $this->assertTrue($controller->view->user instanceof User);
        $this->assertEquals('Admin-User', $controller->view->user->slug);
        $this->assertTrue(is_array($controller->view->projects));
        $this->assertTrue(
            $controller->view->assignedGrid 
            instanceof Grid_Project_Issues_Assigned);
    }
    
    public function testReportedIssuesAction()
    {
        $this->request->setParam('user_slug', 'Admin-User');
        $controller = $this->getController('UsersController');
        $controller->reportedIssuesAction();
        $this->assertTrue($controller->view->user instanceof User);
        $this->assertEquals('Admin-User', $controller->view->user->slug);
        $this->assertTrue(is_array($controller->view->projects));
        $this->assertTrue(
            $controller->view->reportedGrid 
            instanceof Grid_Project_Issues_Reported);
    }
    
    public function testEditAction_Success()
    {
        $this->request
            ->setParam('user_slug', 'Admin-User')
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'adminx',
                'role'              => User::ROLE_ADMIN,
                'password'          => 'some password x',
                'password_repeat'   => 'some password x',
                'name'              => 'Edited admin',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
            
        $controller = $this->getController('UsersController');
        $controller->editAction();
        $this->assertTrue($controller->view->user instanceof User);
        $this->assertEquals('Edited-admin', $controller->view->user->slug);
        $this->assertTrue($controller->view->success);
        
        $user = Doctrine::getTable('User')->findOneByLogin('adminx');
        $this->assertTrue($user instanceof User);
        $this->assertEquals('Edited-admin', $user->slug);
    }
    
    public function testEditAction_NonLatinSuccess()
    {
        $this->request
            ->setParam('user_slug', 'Admin-User')
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'adminx',
                'role'              => User::ROLE_ADMIN,
                'password'          => 'some password x',
                'password_repeat'   => 'some password x',
                'name'              => 'اسم المستخدم',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
            
        $controller = $this->getController('UsersController');
        $controller->editAction();
        $this->assertTrue($controller->view->user instanceof User);
        $this->assertEquals('اسم-المستخدم', $controller->view->user->slug);
        $this->assertTrue($controller->view->success);
        
        $user = Doctrine::getTable('User')->findOneByLogin('adminx');
        $this->assertTrue($user instanceof User);
        $this->assertEquals('اسم-المستخدم', $user->slug);
    }
    
    public function testEditAction_MismatchPasswordsFail()
    {
        $this->request
            ->setParam('user_slug', 'Admin-User')
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'adminx',
                'role'              => User::ROLE_ADMIN,
                'password'          => 'some password x',
                'password_repeat'   => 'some password x mismatch',
                'name'              => 'Edited admin',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertEditActionFail();
    }
    
    public function testEditAction_LoginFail()
    {
        $this->request
            ->setParam('user_slug', 'Admin-User')
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'test-user1',
                'role'              => User::ROLE_ADMIN,
                'password'          => 'some password x',
                'password_repeat'   => 'some password x',
                'name'              => 'Admin-User',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertEditActionFail();
    }
    
    public function testEditAction_TooLongLoginFail()
    {
        $login = str_repeat('abc', 100); // 300 characters.
        $this->request
            ->setParam('user_slug', 'Admin-User')
            ->setMethod('POST')
            ->setPost(array(
                'login'             => $login,
                'role'              => User::ROLE_ADMIN,
                'password'          => 'some password x',
                'password_repeat'   => 'some password x',
                'name'              => 'Admin-User',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertEditActionFail();
    }
    
    public function testEditAction_NameFail()
    {
        $this->request
            ->setParam('user_slug', 'Admin-User')
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'admin',
                'role'              => User::ROLE_ADMIN,
                'password'          => 'some password x',
                'password_repeat'   => 'some password x',
                'name'              => 'Test user 1',
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertEditActionFail();
    }
    
    public function testEditAction_TooLongNameFail()
    {
        $name = str_repeat('abc', 100); // 300 characters.
        $this->request
            ->setParam('user_slug', 'Admin-User')
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'admin',
                'role'              => User::ROLE_ADMIN,
                'password'          => 'some password x',
                'password_repeat'   => 'some password x',
                'name'              => $name,
                'email'             => 'some@user.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertEditActionFail();
    }
    
    public function testEditAction_EmailFail()
    {
        $this->request
            ->setParam('user_slug', 'Admin-User')
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'admin',
                'role'              => User::ROLE_ADMIN,
                'password'          => 'some password x',
                'password_repeat'   => 'some password x',
                'name'              => 'Admin-User',
                'email'             => 'email1@email.com',
                'status'            => User::STATUS_ACTIVE
            ));
        $this->_assertEditActionFail();
    }
    
    public function testDeleteAction()
    {
        $this->request->setParam('user_slug', 'test-user-1');
        $controller = $this->getController('UsersController');
        $controller->deleteAction();
        $this->_assertNumberOfUsers(3);
    }
    
    public function testEditProfileAction_Success()
    {
        $this->request
            ->setParam('user_slug', 'Admin-User')
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'adminx',
                'name'              => 'Edited admin',
                'email'             => 'some@user.com'
            ));
            
        $controller = $this->getController('UsersController');
        $controller->editProfileAction();
        $this->assertTrue($controller->view->form instanceof Form_EditProfile);
        $this->assertTrue($controller->view->success);
        $this->assertTrue(is_array($controller->view->projects));
        
        $user = Doctrine::getTable('User')->findOneByLogin('adminx');
        $this->assertTrue($user instanceof User);
        $this->assertEquals('Edited-admin', $user->slug);
    }
    
    public function testEditProfileAction_LoginFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'test-user1',
                'name'              => 'Admin-User',
                'email'             => 'some@user.com'
            ));
        $this->_assertEditProfileActionFail();
    }
    
    public function testEditProfileAction_TooLongLoginFail()
    {
        $login = str_repeat('abc', 100); // 300 characters.
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => $login,
                'name'              => 'Admin-User',
                'email'             => 'some@user.com'
            ));
        $this->_assertEditProfileActionFail();
    }
    
    public function testEditProfileAction_NameFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'xxx',
                'name'              => 'test user 1',
                'email'             => 'some@user.com'
            ));
        $this->_assertEditProfileActionFail();
    }
    
    public function testEditProfileAction_TooLongNameFail()
    {
        $name = str_repeat('abc', 100); // 300 characters.
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'xxx',
                'name'              => $name,
                'email'             => 'some@user.com'
            ));
        $this->_assertEditProfileActionFail();
    }
    
    public function testEditProfileAction_EmailFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'admin',
                'name'              => 'Admin-User',
                'email'             => 'email1@email.com'
            ));
        $this->_assertEditProfileActionFail();
    }
    
    public function testChangePasswordAction_Success()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'old_password'    => 'admin',
                'new_password'    => 'adminxxx',
                'password_repeat' => 'adminxxx',
            ));
            
        $controller = $this->getController('UsersController');
        $controller->changePasswordAction();
        $this->assertTrue($controller->view->form instanceof Form_ChangePassword);
        $this->assertTrue($controller->view->success);
        $this->assertTrue(is_array($controller->view->projects));
        
        $user = Doctrine::getTable('User')->findOneByLogin('admin');
        $this->assertTrue($user instanceof User);
        $this->assertEquals(FreeCode_Hash::encodePassword('adminxxx'), $user->password_hash);
    }
    
    public function testChangePasswordAction_OldPasswordMismatch()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'old_password'    => 'admin wrong passwd',
                'new_password'    => 'adminxxx',
                'password_repeat' => 'adminxxx',
            ));
            
        $controller = $this->getController('UsersController');
        $controller->changePasswordAction();
        $this->assertTrue($controller->view->form instanceof Form_ChangePassword);
        $this->assertFalse($controller->view->success);
        $this->assertTrue(is_array($controller->view->projects));
        
        $user = Doctrine::getTable('User')->findOneByLogin('admin');
        $this->assertTrue($user instanceof User);
        $this->assertEquals(FreeCode_Hash::encodePassword('admin'), $user->password_hash);
    }
    
    public function testChangePasswordAction_NewPasswordMismatch()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'old_password'    => 'admin',
                'new_password'    => 'admin123',
                'password_repeat' => 'admin456',
            ));
            
        $controller = $this->getController('UsersController');
        $controller->changePasswordAction();
        $this->assertTrue($controller->view->form instanceof Form_ChangePassword);
        $this->assertFalse($controller->view->success);
        $this->assertTrue(is_array($controller->view->projects));
        
        $user = Doctrine::getTable('User')->findOneByLogin('admin');
        $this->assertTrue($user instanceof User);
        $this->assertEquals(FreeCode_Hash::encodePassword('admin'), $user->password_hash);
    }
    
    public function testFetchUser()
    {
        $this->request->setParam('user_slug', 'Admin-User');
        $controller = $this->getController('UsersController');
        $user = $controller->fetchUser();
        $this->assertTrue($user instanceof User);
        $this->assertEquals('Admin-User', $user->slug);
    }
    
    public function testFetchUserProjects()
    {
        $this->request->setParam('user_slug', 'Admin-User');
        $controller = $this->getController('UsersController');
        $user = $controller->fetchUser();
        $projects = $controller->fetchUserProjects($user);
        $this->assertTrue(is_array($projects));
    }
    
    public function testAddUserBreadCrumb()
    {
        $this->request->setParam('user_slug', 'Admin-User');
        $controller = $this->getController('UsersController');
        $user = $controller->fetchUser();
        $controller->addUserBreadCrumb($user);
        foreach ($controller->getBreadCrumbs()->getCrumbs() as $crumb) {
            if ($crumb['title'] == $user->name)
                return; // OK
        }
        $this->assertTrue(false); // FAIL
    }
    
    public function testRegisterAction_Success()
    {
        $trap = FreeCode_Trap::getInstance()->clear();
        
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'someuser',
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Some user',
                'email'             => 'some@user.com'
            ));
            
        $controller = $this->getController('UsersController');
        $controller->registerAction();
        $this->_assertNumberOfUsers(5);
        $this->assertTrue($controller->view->success);
        
        $user = Doctrine::getTable('User')->findOneByLogin('someuser');
        $this->assertTrue($user instanceof User);
        $this->assertEquals(User::STATUS_INACTIVE, $user->status);
        $this->assertEquals(User::ROLE_USER, $user->role);

        $this->assertEquals(1, $trap->getCount());
        $mail = $trap->getLast();
        $this->assertTrue($mail instanceof FreeCode_Mail);
      
        $content = (string) $mail->getBodyHtml(true);
        $content = str_replace(array('=', "\n", "\r"), array('', '', ''), $content);
        $this->assertContains($user->slug, $content);
        $this->assertContains($user->confirm_hash, $content);
            
        $headers = $mail->getHeaders();
        $this->assertEquals('some@user.com', $headers['To'][0]);
        $this->assertTrue(!empty($headers['Subject'][0]));
        $this->assertEquals(FreeCode_Config::getInstance()->mailer->from, 
            $headers['From'][0]);
    }
    
    public function testRegisterAction_LoginFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'admin',
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Some user',
                'email'             => 'some@user.com'
            ));
        $this->_assertRegisterActionFail();
    }
    
    public function testRegisterAction_TooLongLoginFail()
    {
        $login = str_repeat('abc', 100); // 300 characters.
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => $login,
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Some user',
                'email'             => 'some@user.com'
            ));
        $this->_assertRegisterActionFail();
    }
    
    public function testRegisterAction_TooLongNameFail()
    {
        $name = str_repeat('abc', 100); // 300 characters.
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'some-user',
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => $name,
                'email'             => 'some@user.com'
            ));
        $this->_assertRegisterActionFail();
    }
    
    public function testRegisterAction_SlugFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'someuser',
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Admin-User',
                'email'             => 'some@user.com'
            ));
        $this->_assertRegisterActionFail();
    }
    
    public function testRegisterAction_EmailFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'someuser',
                'password'          => 'some password',
                'password_repeat'   => 'some password',
                'name'              => 'Some User',
                'email'             => 'email1@email.com'
            ));
        $this->_assertRegisterActionFail();
    }
    
    public function testRegisterAction_MismatchPasswordsFail()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login'             => 'someuser',
                'password'          => 'some password',
                'password_repeat'   => 'some password xxx',
                'name'              => 'Some User',
                'email'             => 'some@user.com'
            ));
        $this->_assertRegisterActionFail();
    }
   
    public function testActivateAction()
    {
        $user = new User;
        $user->login = 'user';
        $user->name = 'the user';
        $user->email = 'the@user.com';
        $user->status = User::STATUS_INACTIVE;
        $user->save();
        
        $this->request
            ->setParam('user_slug', $user->slug)
            ->setParam('hash', $user->confirm_hash);
        
        $controller = $this->getController('UsersController');
        $controller->activateAction();
        
        $user = Doctrine::getTable('User')->findOneBySlug('the-user');
        $this->assertEquals($user->status, User::STATUS_ACTIVE);
    }
    
    public function testRemindPasswordAction_ByEmail()
    {
        $this->_assertRemindPasswordAction('email1@email.com');
    }
    
    public function testRemindPasswordAction_ByLogin()
    {
        $this->_assertRemindPasswordAction('Test-User2');
    }
    
    public function testGeneratePasswordAction()
    {
        $user = new User;
        $user->login = 'user';
        $user->name = 'the user';
        $user->email = 'the@user.com';
        $user->save();
        
        $trap = FreeCode_Trap::getInstance()->clear();
        
        $this->request
            ->setParam('user_slug', $user->slug)
            ->setParam('hash', $user->confirm_hash);
        
        $controller = $this->getController('UsersController');
        $controller->generatePasswordAction();
        
        $password = $controller->view->password;
        $hash = FreeCode_Hash::encodePassword($password);
        
        $user = Doctrine::getTable('User')->findOneBySlug('the-user');
        $this->assertEquals($user->password_hash, $hash);
        
        $this->assertEquals(1, $trap->getCount());
        $mail = $trap->getLast();
        $this->assertTrue($mail instanceof FreeCode_Mail);
        
        $content = (string) $mail->getBodyHtml(true);
        $content = str_replace(array('=', "\n", "\r"), array('', '', ''), $content);
        $this->assertContains($password, $content);
            
        $headers = $mail->getHeaders();
        $this->assertEquals('the@user.com', $headers['To'][0]);
        $this->assertTrue(!empty($headers['Subject'][0]));
        $this->assertEquals(FreeCode_Config::getInstance()->mailer->from, 
            $headers['From'][0]);
    }
    
    protected function _assertNewActionFail()
    {
        $controller = $this->getController('UsersController');
        $controller->newAction();
        $this->_assertNumberOfUsers(4);
        $this->assertFalse($controller->view->success);
    }
    
    protected function _assertEditActionFail()
    {
        $controller = $this->getController('UsersController');
        $controller->editAction();
        $this->assertTrue($controller->view->user instanceof User);
        $this->assertEquals('Admin-User', $controller->view->user->slug);
        $this->assertFalse($controller->view->success);
    }
    
    protected function _assertEditProfileActionFail()
    {
            
        $controller = $this->getController('UsersController');
        $controller->editProfileAction();
        $this->assertTrue($controller->view->form instanceof Form_EditProfile);
        $this->assertFalse($controller->view->success);
        $this->assertTrue(is_array($controller->view->projects));
    }
    
    protected function _assertNumberOfUsers($num)
    {
        $query = Doctrine::getTable('User')->getUsersListQuery()
            ->select("COUNT(id) AS cnt");
        $records = $query->execute();
        $this->assertEquals($num, $records[0]['cnt']);
    }
    
    protected function _assertRegisterActionFail()
    {
        $trap = FreeCode_Trap::getInstance()->clear();
        $controller = $this->getController('UsersController');
        $controller->registerAction();
        $this->_assertNumberOfUsers(4);
        $this->assertFalse($controller->view->success);
        $this->assertNull($trap->getLast());
    }
    
    protected function _assertRemindPasswordAction($emailOrLogin)
    {
        $trap = FreeCode_Trap::getInstance()->clear();
        
        $user = Doctrine::getTable('User')->findOneByEmail($emailOrLogin);
        if (!$user)
            $user = Doctrine::getTable('User')->findOneByLogin($emailOrLogin);
        $this->assertTrue($user instanceof User);
        
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'email' => $emailOrLogin
            ));
        
        $controller = $this->getController('UsersController');
        $controller->remindPasswordAction();
        $this->assertTrue($controller->view->success);
        
        $this->assertEquals(1, $trap->getCount());
        $mail = $trap->getLast();
        $this->assertTrue($mail instanceof FreeCode_Mail);
        
        $content = (string) $mail->getBodyHtml(true);
        $content = str_replace(array('=', "\n", "\r"), array('', '', ''), $content);
        $this->assertContains($user->slug, $content);
        $this->assertContains($user->confirm_hash, $content);
            
        $headers = $mail->getHeaders();
        $this->assertEquals($user->email, $headers['To'][0]);
        $this->assertTrue(!empty($headers['Subject'][0]));
        $this->assertEquals(FreeCode_Config::getInstance()->mailer->from, 
            $headers['From'][0]);
    }
    
}
