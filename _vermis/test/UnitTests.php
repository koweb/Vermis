<?php

/**
 * =============================================================================
 * @file        UnitTests.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UnitTests.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

require_once 'bootstrap.php';

/**
 * @class   UnitTests
 */
class UnitTests 
{

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('vermis');
        
        $suite->addTestSuite('ApplicationTest');
        $suite->addTestSuite('AclTest');
        $suite->addTestSuite('ControllerTest');
        $suite->addTestSuite('ActivityObserverTest');
        $suite->addTestSuite('ActivityMailerTest');
        $suite->addTestSuite('ChangeProcessorTest');
        
        $suite->addTestSuite('Default_ControllerTest');
        $suite->addTestSuite('Project_ControllerTest');
        
        $suite->addTestSuite('Form_ChangePasswordTest');
        $suite->addTestSuite('Form_EditProfileTest');
        $suite->addTestSuite('Form_LoginTest');
        $suite->addTestSuite('Form_UserTest');
        $suite->addTestSuite('Form_RemindPasswordTest');
        $suite->addTestSuite('Form_ProjectTest');
        $suite->addTestSuite('Form_Project_ComponentTest');
        $suite->addTestSuite('Form_Project_IssueTest');
        $suite->addTestSuite('Form_Project_SimpleIssueTest');
        $suite->addTestSuite('Form_Project_MemberTest');
        $suite->addTestSuite('Form_Project_MilestoneTest');
        $suite->addTestSuite('Form_Project_NoteTest');
        $suite->addTestSuite('Form_CommentTest');
        $suite->addTestSuite('Form_UploadTest');
        
        $suite->addTestSuite('View_Helper_ActionMenuTest');
        $suite->addTestSuite('View_Helper_LogUrlTest');
        $suite->addTestSuite('View_Helper_ProgressBarTest');
        $suite->addTestSuite('View_Helper_SmallButtonsTest');
        $suite->addTestSuite('View_Helper_TableHeaderTest');
        $suite->addTestSuite('View_Helper_ComponentLinkTest');
        $suite->addTestSuite('View_Helper_IssueLinkTest');
        $suite->addTestSuite('View_Helper_MilestoneLinkTest');
        $suite->addTestSuite('View_Helper_ProjectLinkTest');
        $suite->addTestSuite('View_Helper_UserLinkTest');
        $suite->addTestSuite('View_Helper_NoteLinkTest');
        
        $suite->addTestSuite('UserTest');
        $suite->addTestSuite('UserTableTest');
        $suite->addTestSuite('LogTest');
        $suite->addTestSuite('LogTableTest');
        $suite->addTestSuite('ProjectTest');
        $suite->addTestSuite('ProjectTableTest');
        $suite->addTestSuite('Project_ComponentTest');
        $suite->addTestSuite('Project_ComponentTableTest');
        $suite->addTestSuite('Project_IssueTest');
        $suite->addTestSuite('Project_IssueTableTest');
        $suite->addTestSuite('Project_Issue_CommentTest');
        $suite->addTestSuite('Project_Issue_CommentTableTest');
        $suite->addTestSuite('Project_Issue_FileTest');
        $suite->addTestSuite('Project_Issue_FileTableTest');
        $suite->addTestSuite('Project_MemberTest');
        $suite->addTestSuite('Project_MemberTableTest');
        $suite->addTestSuite('Project_MilestoneTest');
        $suite->addTestSuite('Project_MilestoneTableTest');
        $suite->addTestSuite('Project_NoteTest');
        $suite->addTestSuite('Project_NoteTableTest');
        
        $suite->addTestSuite('Validate_Project_ComponentTest');
        $suite->addTestSuite('Validate_Project_MilestoneTest');
        $suite->addTestSuite('Validate_Project_NoteTest');
        
        $suite->addTestSuite('Grid_UsersTest');
        $suite->addTestSuite('Grid_ProjectsTest');
        $suite->addTestSuite('Grid_Project_ComponentsTest');
        $suite->addTestSuite('Grid_Project_MilestonesTest');
        $suite->addTestSuite('Grid_Project_NotesTest');
        $suite->addTestSuite('Grid_Project_MembersTest');
        $suite->addTestSuite('Grid_Project_IssuesTest');
        $suite->addTestSuite('Grid_Project_Issues_AssignedTest');
        $suite->addTestSuite('Grid_Project_Issues_ComponentTest');
        $suite->addTestSuite('Grid_Project_Issues_MilestoneTest');
        $suite->addTestSuite('Grid_Project_Issues_ReportedTest');
        $suite->addTestSuite('Grid_Project_Issues_LatestTest');
        $suite->addTestSuite('Grid_Project_Issues_NavigatorTest');
        
        $suite->addTestSuite('Grid_Decorator_UserLinkTest');
        $suite->addTestSuite('Grid_Decorator_ProjectLinkTest');
        $suite->addTestSuite('Grid_Decorator_Project_ComponentLinkTest');
        $suite->addTestSuite('Grid_Decorator_Project_IssueIdTest');
        $suite->addTestSuite('Grid_Decorator_Project_IssuePriorityTest');
        $suite->addTestSuite('Grid_Decorator_Project_IssueStatusTest');
        $suite->addTestSuite('Grid_Decorator_Project_IssueTitleTest');
        $suite->addTestSuite('Grid_Decorator_Project_IssueTypeTest');
        $suite->addTestSuite('Grid_Decorator_Project_MilestoneLinkTest');
        $suite->addTestSuite('Grid_Decorator_Project_NoteLinkTest');
        $suite->addTestSuite('Grid_Decorator_Project_ProgressBarTest');
        
        $suite->addTestSuite('Grid_Importer_ProjectsTest');
        $suite->addTestSuite('Grid_Importer_UsersTest');
        $suite->addTestSuite('Grid_Importer_Project_ComponentsTest');
        $suite->addTestSuite('Grid_Importer_Project_MembersTest');
        $suite->addTestSuite('Grid_Importer_Project_MilestonesTest');
        $suite->addTestSuite('Grid_Importer_Project_NotesTest');
        $suite->addTestSuite('Grid_Importer_Project_IssuesTest');
        $suite->addTestSuite('Grid_Importer_Project_Issues_AssignedTest');
        $suite->addTestSuite('Grid_Importer_Project_Issues_ComponentTest');
        $suite->addTestSuite('Grid_Importer_Project_Issues_MilestoneTest');
        $suite->addTestSuite('Grid_Importer_Project_Issues_ReportedTest');
        
        $suite->addTestSuite('Default_AuthControllerTest');
        $suite->addTestSuite('Default_ErrorControllerTest');
        $suite->addTestSuite('Default_IndexControllerTest');
        $suite->addTestSuite('Default_ActivityControllerTest');
        $suite->addTestSuite('Default_ProjectsControllerTest');
        $suite->addTestSuite('Default_UsersControllerTest');
        $suite->addTestSuite('Default_SearchControllerTest');
        $suite->addTestSuite('Default_GridControllerTest');
        $suite->addTestSuite('Default_IssuesControllerTest');
        
        $suite->addTestSuite('Project_IndexControllerTest');
        $suite->addTestSuite('Project_ActivityControllerTest');
        $suite->addTestSuite('Project_ComponentsControllerTest');
        $suite->addTestSuite('Project_IssuesControllerTest');
        $suite->addTestSuite('Project_Issues_CommentsControllerTest');
        $suite->addTestSuite('Project_Issues_FilesControllerTest');
        $suite->addTestSuite('Project_MembersControllerTest');        
        $suite->addTestSuite('Project_MilestonesControllerTest');
        $suite->addTestSuite('Project_NotesControllerTest');
        $suite->addTestSuite('Project_GridControllerTest');
        
        return $suite;
    }
    
}
