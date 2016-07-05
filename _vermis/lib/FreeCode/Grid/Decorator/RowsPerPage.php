<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/RowsPerPage.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: RowsPerPage.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
* =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_RowsPerPage
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_RowsPerPage extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $grid = $this->getGrid();
        $rowsPerPage = $this->getElement();
        $id = $grid->getId().'_'.$rowsPerPage->getId();
        $float = $rowsPerPage->getFloat();
        $currentValue = $grid->getPager()->getRowsPerPage();
        $view = $grid->getView();
        
        $html = '';
        $options = $rowsPerPage->getOptions();
        foreach ($options as $value => $title) {
            if ($value == $currentValue)
                $html .= '<option value="'.$value.'" selected="selected">'.$title.'</option>';
            else
                $html .= '<option value="'.$value.'">'.$title.'</option>';
        }
        
        $options = $grid->getOptions();
        $options['page'] = 1;
        unset($options['rows']);
        $url = $grid->getAjaxAction().'?'.http_build_query($options);
        
        $view->headScript()->captureStart();
?>
$(document).ready(function(){
    $('#<?= $id ?>').change(function(){
        var rows = this.options[this.selectedIndex].value;
        $.get('<?= $url ?>&rows=' + rows, function(html){ $('#<?= $grid->getId() ?>').html(html); });
    });
});
<?
        $view->headScript()->captureEnd();

        return 
            '<select id="'.$id.'" style="float:'.$float.'">'.$html.'</select>';
    }
    
}
