<?php

/**
 * =============================================================================
 * @file        FreeCode/Mail.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Mail.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Mail
 * @biref   Just a mail.
 */
class FreeCode_Mail extends Zend_Mail
{

    public $view = null;
    protected $_config = null;
    protected $_scriptName = null;

    /**
     * Constructor.
     * @param   string  $scriptName Script filename.
     */
    public function __construct($scriptName = null)
    {
        parent::__construct('UTF-8');

        $this->_config = FreeCode_Config::getInstance();
        
        // Setup mail view.
        $this->view = new Zend_View();
        $this->view->setScriptPath(EMAILS_DIR);
        $this->view->addScriptPath(VIEWS_LAYOUTS_DIR);
        $this->view->addHelperPath('FreeCode/View/Helper', 'FreeCode_View_Helper');
        $this->view->addHelperPath(VIEWS_HELPERS_DIR, 'View_Helper');
        $this->view->config = $this->_config;
        $this->view->identity = FreeCode_Identity::getInstance();
        
        /**
         * Enable theme overriding if theme is defined.
         */
        if (defined('THEMES_DIR') && isset($this->_config->theme)) {
            $this->view->addScriptPath(THEMES_DIR.'/'.$this->_config->theme.'/emails');
        }
        
        $this->_scriptName = $scriptName;
    }

    /**
     * Set script name.
     * @param   string  $scriptName Filename.
     * @return  $this
     */
    public function setScriptName($scriptName)
    {
        $this->_scriptName = $scriptName;
        return $this;
    }

    /**
     * Get script name.
     * @return  string
     */
    public function getScriptName()
    {
        return $this->_scriptName;
    }

    /**
     *  Set subject.
     *  @param  string  $subject
     */
    public function setSubject($subject)
    {
        parent::setSubject(FreeCode_Translator::_($subject));    
    }
    
    /**
     * Send email.
     * @param   mixed $transport
     * @return  void
     */
    public function send($transport = null)
    {
        if (    FreeCode_Test::isEnabled() ||
                (isset($this->_config->mailer) &&
                isset($this->_config->mailer->enable))) {

            if ($this->_scriptName) {
                $html = $this->view->render($this->_scriptName);
                $this->setBodyHtml($html);
            }

            if (!$this->getFrom() && isset($this->_config->mailer->from))
                $this->setFrom($this->_config->mailer->from);
            
            if (!FreeCode_Test::isEnabled())
                parent::send($transport);
            else
                FreeCode_Trap::getInstance()->push($this);
        }
    }
    
    public static function getDefaultTransport()
    {
        return self::$_defaultTransport;
    }

}
