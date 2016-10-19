<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Body.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Body.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Body
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Body extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $grid = $this->getGrid();
        $html = '';
        $i = $grid->getPager()->getRowsOffset();
        
        if ($grid->hasFilter()) {
            $decorator = new FreeCode_Grid_Decorator_Filter;
            $decorator
                ->setGrid($this->getGrid())
                ->setView($this->getView());
            $html .= $decorator->render('');
        }
        
        foreach ($grid->getRows() as $row) {
            $html .=  '<tr class="bg'.($i++ & 1).'">';
            
            if ($grid->hasIndicator()) {
                $html .= '<td class="idx">'.$i.'</td>';
            }
            
            if ($grid->hasMultiselect()) {
                $msId = $grid->getId().'_ms';
                $msValue = $row[$grid->getMultiselectColumn()->getId()];
                $html .= '<td><input type="checkbox" name="'.$msId.'" value="'.$msValue.'" /></td>';
            }
            
            foreach ($grid->getColumns() as $column) {
                
                if ($column->isHidden())
                    continue; 
                    
                $decorator = $column->getCellDecorator();
                $decorator
                    ->setView($this->getView())
                    ->setGrid($grid)
                    ->setColumn($column)
                    ->setRow($row);
                    
                $id = $column->getId();
                $value = (isset($row[$id]) ? $row[$id] : null);
                
                $html .= '<td>'.$decorator->render($value).'</td>';
            }
            
            $html .= '</tr>';
        }
        return '<tbody>'.$html.'</tbody>'.$content;
    }
    
}
