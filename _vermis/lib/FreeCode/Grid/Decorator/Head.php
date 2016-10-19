<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Head.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Head.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Head
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Head extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $grid = $this->getGrid();
        $html = '';
        
        if ($grid->hasIndicator()) {
            $html .= '<td class="slim">#</td>';
        }
        
        if ($grid->hasMultiselect()) {
            $msId = $grid->getId().'_ms';
            $msIdAll = $msId.'_all';
            $html .= '<td class="slim"><input id="'.$msIdAll.'" type="checkbox" name="'.$msIdAll.'" /></td>';

            $this->getView()->headScript()->captureStart();
?>
$(document).ready(function(){
	$('#<?= $msIdAll ?>').click(function(){
		var c = $('#<?= $msIdAll ?>').is(':checked');
		$('input[name=<?= $msId ?>]').map(function(i, n){ $(n).attr('checked', c); });
	});
});
<?
            $this->getView()->headScript()->captureEnd();
        }
        
        foreach ($grid->getColumns() as $column) {
            
            if ($column->isHidden())
                continue;
                
            $decorator = $column->getTitleDecorator();
            $decorator
                ->setView($this->getView())
                ->setGrid($grid)
                ->setColumn($column);
            $html .= '<td>'.$decorator->render($column->getTitle()).'</td>';
        }
        return '<thead><tr>'.$html.'</tr></thead>'.$content;
    }
    
}
