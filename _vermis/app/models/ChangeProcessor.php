<?php

/**
 * =============================================================================
 * @file        ChangeProcessor.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ChangeProcessor.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   ChangeProcessor
 * @brief   Change processor.
 */
class ChangeProcessor
{
    
    public static $projectFields = 
        array(
            'name' => array('title' => 'Name'),
            'description' => array('title' => 'Description'),
            'is_private' => array(
                'title' => 'Access',
                'decorator' => 'boolLabel',
                'params' => array('is_private', 'Private', 'Public')
            )
        );
        
    public static $componentFields = 
        array(
            'name' => array('title' => 'Name'),
            'description' => array('title' => 'Description')
        );
        
    public static $milestoneFields = 
        array(
            'name' => array('title' => 'Name'),
            'description' => array('title' => 'Description')
        );
        
    public static $noteFields = 
        array(
            'title' => array('title' => 'Name'),
            'content' => array('title' => 'Content')
        );
        
    public static $issueFields = 
        array(
            'title' => array('title' => 'Title'),
            'type' => array(
                'title' => 'Type',
                'decorator' => 'issueType',
                'params' => array('type')
            ),
            'status' => array(
                'title' => 'Status',
                'decorator' => 'issueStatus',
                'params' => array('status')
            ),
            'priority' => array(
                'title' => 'Priority',
                'decorator' => 'issuePriority',
                'params' => array('priority')
            ),
            'description' => array('title' => 'Description'),
            'milestone_name' => array(
                'title' => 'Milestone',
                'decorator' => 'milestoneLink',
                'params' => array('project_slug', 'milestone_slug', 'milestone_name')
            ),
            'component_name' => array(
                'title' => 'Component',
                'decorator' => 'componentLink',
                'params' => array('project_slug', 'component_slug', 'component_name')
            ),
            'reporter_name' => array(
                'title' => 'Reported by',
                'decorator' => 'userLink',
                'params' => array('reporter_slug', 'reporter_name')
            ),    
            'assignee_name' => array(
                'title' => 'Assigned to',
                'decorator' => 'userLink',
                'params' => array('assignee_slug', 'assignee_name')
            ),
            'progress' => array(
                'title' => 'Progress', 
                'decorator' => 'progressBar', 
                'params' => array('progress', 150)
            )
        );
    
    public static function process(array $changes, array $first = array())
    {
        if (count($changes) == 0)
            return array();
            
        if (count($changes) == 1)
            return $changes;
            
        $changes[] = $first;
            
        $diffs = array();
        reset($changes);
        $prev = current($changes);
        while (($cur = next($changes)) !== false) {
            // Differences.
            $diff = array_diff_assoc($prev, $cur);
            
            // Skip empty versions.
            if (count($diff) == 1)
                continue;
            
            // Restore some info.
            if (isset($prev['id']))
                $diff['id'] = $prev['id'];
            if (isset($prev['changer_id'])) {
                $diff['changer_id'] = $prev['changer_id'];
                $diff['changer_name'] = $prev['changer_name'];
                $diff['changer_slug'] = $prev['changer_slug'];
            }
            
            $diffs[] = $diff;
            $prev = $cur;
        }
        
        return $diffs;
    }
    
}
