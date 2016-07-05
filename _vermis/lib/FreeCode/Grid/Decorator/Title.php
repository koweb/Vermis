<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Title.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Title.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Title
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Title extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        if ($this->getColumn()->isSortable())
            return $this->_renderSortable($content);
        return $content;
    }
    
    protected function _renderSortable($content)
    {
        $grid       = $this->getGrid();
        $column     = $this->getColumn();
        $view       = $grid->getView();
        $sortColumn = $grid->getSortColumn();
        $sortOrder  = $grid->getSortOrder();
        $pager      = $grid->getPager();
        
        $id = $grid->getId().'_'.strtolower($column->getId());
        $prepend = '<a id="'.$id.'" href="javascript:void(0);" title="">';
        $append = '</a>';
       
        if ($column->getId() == $sortColumn->getId()) {
            
            if ($sortOrder == 'ASC') {
                $order = 'desc';
                $prepend = '<a class="arrows asc"></a>'.$prepend;
                
            } else {
                $order = 'asc';
                $prepend = '<a class="arrows desc"></a>'.$prepend;
                
            }
        
        } else {
            $prepend = '<a class="arrows none"></a>'.$prepend;
            $order = 'asc';
        }

        $options = $grid->getOptions();
        $options['sort'] = $column->getId();
        $options['order'] = $order;
        $url = $grid->getAjaxAction().'?'.http_build_query($options);
        
        $view->headScript()->captureStart();
?>
$(document).ready(function(){$('#<?= $id ?>').click(function(){$.get('<?= $url ?>', function(html){ $('#<?= $grid->getId() ?>').html(html); });});});
<?
        $view->headScript()->captureEnd();
        
        return $prepend.$view->escape(_T($content)).$append;
    }
    
}
