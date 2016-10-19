<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Filter.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Filter.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Filter
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Filter extends FreeCode_Grid_Decorator_Abstract
{

    protected $_grid = null;
    
    public function render($content)
    {
        $this->_grid = $this->getGrid();
        $html = '<tr class="bg0">';
        
        if ($this->_grid->hasIndicator())
            $html .= '<td class="idx"></td>';
            
        if ($this->_grid->hasMultiselect())
            $html .= '<td></td>';
        
        foreach ($this->_grid->getColumns() as $column) {
            
            if ($column->isHidden())
                continue;
            
            $html .= '<td class="filter">';
            if ($filter = $column->getFilter())
                $html .= $this->_renderSelectForColumn($column);
            $html .= '</td>';
        }
        
        $html .= '</tr>';
        
        return $html;
    }
    
    public function _renderSelectForColumn($column)
    {
        $options = $column->getFilter()->getOptions();
        if (count($options) == 0)
            return '';
        
        $id = $this->getGrid()->getId().'_'.$column->getId().'_filter';
        $html = '<select id="'.$id.'">';
        foreach ($options as $value => $title) {
            if ($column->getFilter()->getValue() == $value)
                $html .= '<option value="'.$value.'" selected="selected">'._T($title).'</option>';
            else
                $html .= '<option value="'.$value.'">'._T($title).'</option>';
        }     
        $html .= '</select>';
        
        $options = $this->_grid->getOptions();
        if (isset($options['filter']) && isset($options['filter'][$column->getId()]))
            unset($options['filter'][$column->getId()]);
        $options['page'] = 1;
        $url = $this->_grid->getAjaxAction().'?'.http_build_query($options);
        
        $this->getView()->headScript()->captureStart();
?>
$(document).ready(function(){
    $('#<?= $id ?>').change(function(){
        var value = this.options[this.selectedIndex].value;
        $.get('<?= $url ?>&filter%5B<?= $column->getFilter()->getId() ?>%5D=' + value, function(html){ $('#<?= $this->_grid->getId() ?>').html(html); });
    });
});
<?
        $this->getView()->headScript()->captureEnd();
        
        return $html;
    }
    
}
