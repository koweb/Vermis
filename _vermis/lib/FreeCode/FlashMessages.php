<?php

/**
 * =============================================================================
 * @file        FreeCode/FlashMessages.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: FlashMessages.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_FlashMessages
 * @brief   Flash messages utility.
 */
class FreeCode_FlashMessages
{

    protected $_messages = array();
    protected $_session = null;

    protected function __construct()
    {
        $this->_session = new Zend_Session_Namespace('FlashMessages');
        foreach ($this->_session as $message => $flag) {
            $this->_messages[$message] = $flag;
            $this->_session->__unset($message);
        }
    }

    /**
     * Singleton pattern.
     * @return  FreeCode_Utils_FlashMessages
     */
    public static function getInstance()
    {
        static $instance;
        if (!isset($instance))
            $instance = new self;
        return $instance;
    }

    /**
     * Add custom message.
     * @param   string  $message
     * @param   string  $flag
     * @return  FreeCode_FlashMessages
     */
    public function addMessage($message, $flag = 'message')
    {
        return $this->_add($message, $flag);
    }

    /**
     * Add error message.
     * @param   string  $message
     * @return  FreeCode_FlashMessages
     */
    public function addError($message)
    {
        return $this->_add($message, 'error');
    }

    /**
     * @brief   Add warning message.
     * @param   $message    string
     * @return  $this
     */
    public function addWarning($message)
    {
        return $this->_add($message, 'warning');
    }

    /**
     * Add success message.
     * @param   string  $message
     * @return  FreeCode_FlashMessages
     */
    public function addSuccess($message)
    {
        return $this->_add($message, 'success');
    }

    /**
     * Get messages array.
     * @return  array
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Get messages and clear them.
     * @return  array
     */
    public function getMessagesAndClear()
    {
        $messages = $this->_messages;
        $this->clear();
        return $messages;
    }

    /**
     * Clear messages, remove all.
     * @return  FreeCode_FlasgMessages
     */
    public function clear()
    {
        foreach ($this->_session as $message => $flag)
            $this->_session->__unset($message);
        $this->_messages = array();
        return $this;
    }

    /**
     * Add message.
     * @param   string  $message
     * @param   string  $flag
     * @return  FreeCode_FlashMessages
     */
    protected function _add($message, $flag = null)
    {
        if (empty($message))
            return $this;
        $this->_messages[$message] = $flag;
        $this->_session->__set($message, $flag);
        return $this;
    }

}
