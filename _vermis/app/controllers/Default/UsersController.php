<?php

/**
 * =============================================================================
 * @file        UsersController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UsersController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   UsersController
 * @brief   Users controller.
 */
class UsersController extends Default_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'users';
        $this->view->headTitle()->prepend(_T('users'));
        $this->_breadCrumbs->addCrumb('users', array(), 'users');
    }
    
    public function indexAction()
    {
        $usersGrid = new Grid_Users;
        $usersGrid
            ->restore()
            ->import();
        $this->view->usersGrid = $usersGrid;
    }
    
    public function newAction()
    {
        $this->_breadCrumbs->addCrumb('create_a_new_user', array(), 'users/new');
        
        $form = new Form_User();
        $this->view->form = $form;

        if ($this->isPostRequest()) {
            $data = $this->_request->getPost();
            
            $form->login->addValidator(new FreeCode_Validate_User_LoginNotExists());
            $form->name->addValidator(new FreeCode_Validate_Doctrine_UniqueSlug('User', 'slug'));
            $form->email->addValidator(new FreeCode_Validate_User_EmailNotExists());
            $form->password_repeat->addValidator(new FreeCode_Validate_EqualString($data['password']));
            
            if ($data = $this->validateForm($form)) {
                $passwordHash = FreeCode_Hash::encodePassword($data['password']);
                unset($data['password']);
                unset($data['password_repeat']);
            
                $user = new User;
                $user->setArray($data);
                $user->password_hash = $passwordHash;
                $user->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("user_account_has_been_created");
                $this->goToAction(array(), 'users');
            
            } else {
                $this->view->success = false;
            }
            
        }
    }
    
    public function showAction()
    {
        $user = $this->fetchUser();
        $this->view->user = $user;
        $this->fetchUserProjects($user);
        
        $this->addUserBreadCrumb($user);
        $this->_breadCrumbs->addCrumb(
            'assigned_issued', 
            array('user_slug' => $user->slug), 
            'users/show');
        
        $assignedGrid = new Grid_Project_Issues_Assigned(array(
            'userId' => $user->id,
            'userSlug' => $user->slug,
            'identityId' => $this->_identity->id
        ));
        $assignedGrid
            ->restore()
            ->import();
        $this->view->assignedGrid = $assignedGrid;
    }
    
    public function reportedIssuesAction()
    {
        $user = $this->fetchUser();
        $this->view->user = $user;
        $this->fetchUserProjects($user);
        
        $this->addUserBreadCrumb($user);
        $this->_breadCrumbs->addCrumb(
            'reported_issues', 
            array('user_slug' => $user->slug), 
            'users/reported-issues');
        
        $reportedGrid = new Grid_Project_Issues_Reported(array(
            'userId' => $user->id,
            'userSlug' => $user->slug,
            'identityId' => $this->_identity->id
        ));
        $reportedGrid
            ->setAjaxAction($this->url(array('user_slug' => $user->slug), 'grid_user'))
            ->restore()
            ->import();
        $this->view->reportedGrid = $reportedGrid;
    }
    
    public function editAction()
    {
        $user = $this->fetchUser();
        $this->view->user = $user;
        $this->fetchUserProjects($user);
        
        $this->addUserBreadCrumb($user);
        $this->_breadCrumbs->addCrumb(
            'edit', array('user_slug' => $user->slug), 'users/edit');
            
        $form = new Form_User();
        $this->view->form = $form;
        $form->getElement('password')->setRequired(false);
        $form->getElement('password_repeat')->setRequired(false);
        $form->populate($user->toArray());
        
        if ($this->isPostRequest()) {
            $data = $this->_request->getPost();
            
            if ($data['login'] != $user->login)
                $form->login->addValidator(new FreeCode_Validate_User_LoginNotExists());
                
            if ($data['name'] != $user->name)
                $form->name->addValidator(new FreeCode_Validate_Doctrine_UniqueSlug('User', 'slug'));
                
            if ($data['email'] != $user->email)
                $form->email->addValidator(new FreeCode_Validate_User_EmailNotExists());
                
            if (!empty($data['password']) || !empty($data['password_repeat'])) {
                $resetPassword = true;
                $form->getElement('password')->setRequired(true);
                $form->getElement('password_repeat')->setRequired(true);
                $form->password_repeat->addValidator(new FreeCode_Validate_EqualString($data['password']));
            } else {
                $resetPassword = false;
            }
        
            if ($data = $this->validateForm($form)) {
            
                if ($resetPassword) {
                    $passwordHash = FreeCode_Hash::encodePassword($data['password']);
                    $user->password_hash = $passwordHash;
                }
                
                unset($data['password']);
                unset($data['password_repeat']);
                
                $user->setArray($data);
                $user->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("");
                if ($resetPassword && $user->id == $this->_identity->id)
                    $this->_flashMessages->addSuccess("your_password_has_been_reset");
                $this->goToAction(array(), 'users');
            
            } else {
                $this->view->success = false;
            }
        }

        $form->getElement('password')->setRequired(false);
        $form->getElement('password_repeat')->setRequired(false);
    }
    
    public function deleteAction()
    {
        $user = $this->fetchUser();
        if ($user->id == $this->_identity->id)
            throw new FreeCode_Exception_AccessDenied;        
        $user->delete();
        $this->_flashMessages->addSuccess("user_account_has_been_deleted");
        $this->goToAction(array(), 'users');
    }

    public function editProfileAction()
    {
        $user = $this->_identity;
        $this->view->user = $user;
        $this->fetchUserProjects($user);
        
        $this->addUserBreadCrumb($user);
        $this->_breadCrumbs->addCrumb('edit_profile', 
            array('user_slug' => $user->slug), 
            'users/edit-profile');
        
        $form = new Form_EditProfile;
        $form->populate($user->toArray());
        $this->view->form = $form;
        
        if ($this->isPostRequest()) {
            $data = $this->_request->getPost();
            
            if ($data['login'] != $user->login) {
                $changeLogin = true;
                $form->login->addValidator(new FreeCode_Validate_User_LoginNotExists());
            } else {
                $changeLogin = false;
            }
            
            if ($data['name'] != $user->name)
                $form->name->addValidator(new FreeCode_Validate_Doctrine_UniqueSlug('User', 'slug'));
                
            if ($data['email'] != $user->email) {
                $changeEmail = true;
                $form->email->addValidator(new FreeCode_Validate_User_EmailNotExists());
            } else {
                $changeEmail = false;
            }
                
            if ($data = $this->validateForm($form)) {
            
                if (!(Application::getInstance()->isDemo() && $this->_identity->login == 'demo')) {
                    $user->setArray($data);
                    $user->save();
            
                    $this->_flashMessages->addSuccess("changes_have_been_saved");
                    $this->view->success = true;
                
                    if ($changeLogin) $this->_flashMessages->addSuccess("your_login_has_been_reset");
                    if ($changeEmail) $this->_flashMessages->addSuccess("your_email_has_been_reset");
                
                    $this->goToAction(array('user_slug' => $user->slug), 'users/show');
                
                } else {
                    $this->_flashMessages->addSuccess("this_action_is_disabled_in_demo_mode");
                }
                
            } else {
                $this->view->success = false;    
            }
        }
    }
    
    public function changePasswordAction()
    {
        $user = $this->_identity;
        $this->view->user = $user;
        $this->fetchUserProjects($user);
        
        $this->addUserBreadCrumb($user);
        $this->_breadCrumbs->addCrumb('change_password', 
            array('user_slug' => $user->slug), 
            'users/change-password');
        
        $form = new Form_ChangePassword;
        $this->view->form = $form;
        
        if ($this->isPostRequest()) {
            $data = $this->_request->getPost();
            
            $form->old_password->addValidator(new FreeCode_Validate_EqualPasswordHash($user->password_hash));
            $form->password_repeat->addValidator(new FreeCode_Validate_EqualString($data['new_password']));
        
            if ($data = $this->validateForm($form)) {
            
                if (!(Application::getInstance()->isDemo() && $this->_identity->login == 'demo')) {
                    $passwordHash = FreeCode_Hash::encodePassword($data['new_password']);
                    $user->password_hash = $passwordHash;
                    $user->save();
            
                    $this->_flashMessages->addSuccess("changes_have_been_saved");
                    $this->_flashMessages->addSuccess("your_password_has_been_reset");
                    $this->view->success = true;
                
                    $this->goToAction(array('user_slug' => $user->slug), 'users/show');
                
                } else {
                    $this->_flashMessages->addSuccess("this_action_is_disabled_in_demo_mode");
                }
                
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function registerAction()
    {
        $this->_breadCrumbs->addCrumb('signup_for_a_new_account');
        $config = $this->getConfig();
        $form = new Form_User(array(
            'enableCaptcha' => (FreeCode_Test::isEnabled() ? false : true),
            'enableAcceptLicence' => $config->get('showRegisterAcceptLicence')
        ));
        $form->removeElement('role');
        $form->removeElement('status');
        
        $this->view->form = $form;
        
        if ($this->isPostRequest()) {
            $data = $this->_request->getPost();
            $form->removeElement('accept_licence');
            $form->login->addValidator(new FreeCode_Validate_User_LoginNotExists());
            $form->name->addValidator(new FreeCode_Validate_Doctrine_UniqueSlug('User', 'slug'));
            $form->email->addValidator(new FreeCode_Validate_User_EmailNotExists());
            $form->password_repeat->addValidator(new FreeCode_Validate_EqualString($data['password']));
            
            if ($data = $this->validateForm($form)) {
                $passwordHash = FreeCode_Hash::encodePassword($data['password']);
                unset($data['password']);
                unset($data['password_repeat']);
            
                $user = new User;
                $user->setArray($data);
                $user->role = User::ROLE_USER;
                $user->status = User::STATUS_INACTIVE;
                $user->password_hash = $passwordHash;
                $user->save();
            
                $this->view->success = true;
                $this->_flashMessages
                    ->addSuccess("your_account_has_been_created")
                    ->addSuccess("receive_an_email_and_activate_an_account");
            
                // Send an email to the newly registered user.
                $mail = new FreeCode_Mail('register.phtml');
                $mail->view->user = $user;
                $mail->addTo($user->email);
                $mail->setSubject('['.$this->_config->mailer->titleHeader.'] '._T('confirm_account_registration'));
                $mail->send();

                $this->goToAction(array(), 'auth/login');
            
            } else {
                $this->view->success = false;
            }
            
        }
    }
    
    public function activateAction()
    {
        $this
            ->disableLayout()
            ->disableView();
        
        $user = $this->fetchUser();
        $hash = $this->_request->getParam('hash');
        if ($user->confirm_hash != $hash)
            $this->goToAction(array(), 'index');
        $user->status = User::STATUS_ACTIVE;
        $user->generateConfirmHash();
        $user->save();
        $this->_flashMessages
            ->addSuccess("your_account_has_been_activated")
            ->addSuccess("now_you_can_login");
        $this->goToAction(array(), 'auth/login');
    }
    
    public function remindPasswordAction()
    {
        $this->_breadCrumbs->addCrumb('dont_remember_your_password');
        
        $form = new Form_RemindPassword();
        $form->addCssClass('center');
        $this->view->form = $form;
        
        if ($data = $this->validateForm($form)) {
            
            $table = Doctrine::getTable('User');
            $user = $table->findOneByEmail($data['email']);
            if (!$user)
                $user = $table->findOneByLogin($data['email']);
            if (!$user) {
                $this->_flashMessages->addError("User not found!");
                $this->view->success = false;
            
            } else {
                
                $user->generateConfirmHash();
                $user->save();
                
                $mail = new FreeCode_Mail('remind-password.phtml');
                $mail->view->user = $user;
                $mail->addTo($user->email);
                $mail->setSubject('['.$this->_config->mailer->titleHeader.'] '._T('dont_remember_your_password'));
                $mail->send();

                $this->_flashMessages->addSuccess("mail_with_instructions_has_been_sent");    
                $this->view->success = true;
            }
            
        }
    }
    
    public function generatePasswordAction()
    {
        $this
            ->disableLayout()
            ->disableView();
        
        $user = $this->fetchUser();
        $hash = $this->_request->getParam('hash');
        if ($user->confirm_hash != $hash)
            $this->goToAction(array(), 'index');
            
        $password = $user->generatePasswordHash();
        $user->generateConfirmHash();
        $user->save();
        
        $mail = new FreeCode_Mail('generate-password.phtml');
        $mail->view->user = $user;
        $mail->view->password = $password;
        $mail->addTo($user->email);
        $mail->setSubject('['.$this->_config->mailer->titleHeader.'] '._T('new_password'));
        $mail->send();

        $this->view->password = $password; // For tests.
        
        $this->_flashMessages->addSuccess("mail_with_a_new_password_has_been_sent");
        $this->goToAction(array(), 'auth/login');
    }
    
    public function fetchUser()
    {
        $slug = $this->_request->getParam('user_slug');
        $user = Doctrine::getTable('User')->findOneBySlug($slug);
        if (!$user)
            throw new FreeCode_Exception_RecordNotFound('User');
        $this->view->headTitle()->prepend($user->name);
        
        return $user;
    }
    
    public function fetchUserProjects($user)
    {
        $projects = Doctrine::getTable('Project')
            ->getCommonProjectsQuery(
                $user->id, 
                $this->_identity->isAdmin() ? null : $this->_identity->id)
            ->execute();
        $this->view->projects = $projects;
        return $projects;
    }
    
    public function addUserBreadCrumb($user)
    {
        $this->_breadCrumbs->addCrumb(
            $user->name, array('user_slug' => $user->slug), 
            'users/show');
    }
    
}
