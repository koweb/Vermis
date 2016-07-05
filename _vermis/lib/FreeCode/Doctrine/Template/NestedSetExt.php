<?php

/**
 * =============================================================================
 * @file        FreeCode/Doctrine/Template/Meta.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: NestedSetExt.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Doctrine_Template_NestedSetExt
 * @brief   Nested set extensions for doctrine. 
 */
class FreeCode_Doctrine_Template_NestedSetExt extends Doctrine_Template
{

    /**
     * Move node up.
     * @return  Doctrine_Record
     */
    public function moveUp()
    {
        $invoker = $this->getInvoker();
        $node = $invoker->getNode(); 
        $prev = $node->getPrevSibling();
        if (!$prev)
            return false;
        $node->moveAsPrevSiblingOf($prev);
        return $invoker;
    }
    
    /**
     * Move node down.
     * @return  Doctrine_Record
     */
    public function moveDown()
    {
        $invoker = $this->getInvoker();
        $node = $invoker->getNode();
        $next = $node->getNextSibling();
        if (!$next)
            return false;
        $node->moveAsNextSiblingOf($next);
        return $invoker;
    }
    
    /**
     * Fetch ancestors.
     * @param   $hydrationMode
     * @return  array
     */
    public function fetchAncestors($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $invoker = $this->getInvoker();
        $invokerName = get_class($invoker);
        
        $query = Doctrine_Query::create();
        $query
            ->setHydrationMode($hydrationMode)
            ->select("*")
            ->from("{$invokerName} r")
            ->addWhere("r.lft < {$invoker->lft} AND r.rgt > {$invoker->rgt}")
            ->orderby("r.lft ASC");
            
        if (isset($invoker->is_deleted))
            $query->addWhere("r.is_deleted = false");

        $records = $query->execute();
        $query->free();

        return $records;
    }

    /**
     * Fetch descendants.
     * @param   $hydrationMode
     * @return  array
     */
    public function fetchDescendants($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $invoker = $this->getInvoker();
        $invokerName = get_class($invoker);

        $query = Doctrine_Query::create();
        $query
            ->setHydrationMode($hydrationMode)
            ->select("*")
            ->from("{$invokerName} r")
            ->addWhere("r.lft > {$invoker->lft} AND r.rgt < {$invoker->rgt}")
            ->orderby("r.lft ASC");

        if (isset($invoker->is_deleted))
            $query->addWhere("r.is_deleted = false");

        $records = $query->execute();
        $query->free();

        return $records;
    }

    /**
     * Fetch children.
     * @param   $hydrationMode
     * @return  array
     */
    public function fetchChildren($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $invoker = $this->getInvoker();
        $invokerName = get_class($invoker);

        $query = Doctrine_Query::create();
        $query
            ->setHydrationMode($hydrationMode)
            ->select("*")
            ->from("{$invokerName} r")
            ->addWhere("r.lft > {$invoker->lft} AND r.rgt < {$invoker->rgt}")
            ->addWhere("r.level = ?", $invoker->level + 1)
            ->orderby("r.lft ASC");

        if (isset($invoker->is_deleted))
            $query->addWhere("r.is_deleted = false");

        $records = $query->execute();
        $query->free();

        return $records;
    }
    
}
