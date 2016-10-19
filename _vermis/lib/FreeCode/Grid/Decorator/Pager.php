<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Pager.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Pager.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Pager
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Pager extends FreeCode_Grid_Decorator_Abstract
{

    static public $imagesPath = 'gfx/grid';
    
    protected $_html = '';
    protected $_grid = null;
    protected $_pager = null;
    protected $_view = null;
    
    public function render($content)
    {
        $this->_grid = $this->getGrid();
        $this->_pager = $this->_grid->getPager();
        $this->_view = $this->_grid->getView();
        
        $this->_html = '<div class="pager">';

        $this->_view->headScript()->captureStart();
?>
$(document).ready(function(){
<?php

        $imgPath = self::$imagesPath;
        $this->_renderLink('<img src="'.$imgPath.'/first.png" alt="first" />', $this->_pager->getFirstPage());
        $this->_renderLink('<img src="'.$imgPath.'/prev.png" alt="previous" />', $this->_pager->getPreviousPage());
        
        for ($i = $this->_pager->getFirstPage(); $i <= $this->_pager->getLastPage(); $i++) {
            if ($this->_pager->getPage() == $i)
                $this->_renderLink('['.$i.']', $i, true); 
            else
                $this->_renderLink($i, $i);
        }
        
        $this->_renderLink('<img src="'.$imgPath.'/next.png" alt="next" />', $this->_pager->getNextPage());
        $this->_renderLink('<img src="'.$imgPath.'/last.png" alt="last" />', $this->_pager->getLastPage());
                
?>
});
<?php
        $this->_view->headScript()->captureEnd();
        
        $this->_html .= '</div>';
        
        return $content.$this->_html;
    }
    
    protected function _renderLink($content, $page, $isActive = false)
    {
        static $unique;
        if (!isset($unique))
            $unique = 1;
            
        $id = $this->_grid->getId().'_'.$this->_pager->getId().'_'.$unique;
        $unique++;
        
        $class = ($isActive ? 'class="active"' : '');
        
        $this->_html .= '<a id="'.$id.'" '.$class.' href="javascript:void(0)">'.$content.'</a>';

        $options = $this->_grid->getOptions();
        $options['page'] = $page;
        $url = $this->_grid->getAjaxAction().'?'.http_build_query($options);
        
?>
$('#<?= $id ?>').click(function(){$.get('<?= $url ?>', function(html){ $('#<?= $this->_grid->getId() ?>').html(html); });});
<?php
    }
    
}
