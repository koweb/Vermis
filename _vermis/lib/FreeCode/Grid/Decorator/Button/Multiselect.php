<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Button/Multiselect.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Multiselect.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Button_Multiselect
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Button_Multiselect extends FreeCode_Grid_Decorator_Button
{

    public function render($content)
    {
        $grid = $this->getGrid();
        $msId = $grid->getId().'_ms';
        $href = $this->getElement()->getHref();
        
        $this->getView()->headScript()->captureStart();
?>
$(document).ready(function(){
	$('#<?= $this->_getUniqueElementId() ?>').click(function(){
		var m = $('input[name=<?= $msId ?>]:checked').map(function(i, n){ return $(n).val(); }).get();
		var p = jQuery.param({selected: m}); 
		window.location = '<?= $href ?>?' + p;
	});
});
<?php
        $this->getView()->headScript()->captureEnd();
        
        return parent::render('javascript:void(0)');
    }
    
}
