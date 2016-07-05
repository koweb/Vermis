<?php

/**
 * =============================================================================
 * @file        FreeCode/View/Helper/SuperEscape.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: SuperEscape.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_View_Helper_SuperEscape
 * @brief   View helper for escaping.
 */
class FreeCode_View_Helper_SuperEscape
{

    protected $_view = null;
    protected $_isSuperEnabled = false;
    
    protected $_autoUrlSearch = 
        '#((www\.|(http|https|ftp|ftps)\:\/\/)[^\<\>\n\t\r\ ]+)#';
    
    protected $_autoUrlBbSearch = 
        '#((www\.|\[url\]|\[url\=|\]|(http|https|ftp|ftps)\:\/\/)[^\<\>\n\t\r\ ]+)#';
    
    protected $_urlSearch = array(
        '#^(http|https|ftp|ftps)\:\/\/(.*)#',
        '#^www\.(.*)#'
    );
    
    protected $_urlReplace = array(
        '<a href="$1://$2">$2</a>',
        '<a href="http://www.$1">www.$1</a>'
    );
    
    protected $_urlBbReplace = array(
        '[url]$1://$2[/url]',
        '[url]http://www.$1[/url]'
    );
    
    protected $_bbSearch = array(
        '/\[b\](.*?)\[\/b\]/is',            // Bold
        '/\[i\](.*?)\[\/i\]/is',            // Italic
        '/\[u\](.*?)\[\/u\]/is',            // Underline
        '/\[quote\](.*?)\[\/quote\]/is',    // Quote
        '/\[code\](.*?)\[\/code\]/is',      // Code
        '/\[img\](.*?)\[\/img\]/is',        // Image
        '/\[url\](.*?)\[\/url\]/is',        // Url
        '/\[url\=(.*?)\](.*?)\[\/url\]/is'  // Url
    );
    
    protected $_bbReplace = array(
        '<strong>$1</strong>',
        '<i>$1</i>',
        '<u>$1</u>',
        '<q>$1</q>',
        '<pre><code>$1</code></pre>',
        '<img src="$1" alt="" />',
        '<a href="$1">$1</a>',
        '<a href="$1">$2</a>' 
    );
    
    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function superEscape($value, $filters = array('super'))
    {
        foreach ($filters as $filter) {
            $value = $this->_executeFilter($value, (string) $filter);
        }
        return $value;
    }
    
    protected function _executeFilter($value, $filter)
    {
        $this->_isSuperEnabled = false;
        
        switch ($filter) {
            
            case 'escape': 
                return $this->_filterEscape($value);
            
            case 'nl2br': 
                return $this->_filterNl2Br($value); 
            
            case 'auto-url': 
                return $this->_filterAutoUrl($value);
                
            case 'bb':
                return $this->_filterBb($value);
                
            case 'super': {
                $this->_isSuperEnabled = true;
                $value = $this->_filterEscape($value);
                $value = $this->_filterNl2Br($value);
                $value = $this->_filterAutoUrl($value);
                $value = $this->_filterBb($value);
                return $value;
            } 
            
            default:
                throw new FreeCode_Exception_InvalidArgument("Unknown filter '{$filter}'!");
        }
    }
    
    protected function _filterEscape($value)
    {
        return $this->_view->escape($value);
    }
    
    protected function _filterNl2Br($value)
    {
        return nl2br($value);
    }
    
    protected function _filterAutoUrl($value)
    {
        $value = preg_replace_callback(
            (!$this->_isSuperEnabled ? $this->_autoUrlSearch : $this->_autoUrlBbSearch),
            array($this, '_filterAutoUrlCallback'), 
            $value
        );
        return $value;
    }
    
    protected function _filterAutoUrlCallback(&$matches)
    {
        if ($this->_isSuperEnabled)
            return preg_replace($this->_urlSearch, $this->_urlBbReplace, $matches[0]);
        return preg_replace($this->_urlSearch, $this->_urlReplace, $matches[0]);
    }
    
    protected function _filterBb($value)
    {
        return preg_replace ($this->_bbSearch, $this->_bbReplace, $value);  
    }

}
