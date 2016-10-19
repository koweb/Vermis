<?php

/**
 * =============================================================================
 * @file        FreeCode/Controller/Action.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Action.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Controller_Action
 * @brief   Base application controller.
 */
abstract class FreeCode_Controller_Action extends Zend_Controller_Action
{

    protected $_layout = null;
    protected $_redirector = null;
    protected $_identity = null;
    
    protected $_prevUrl = null;
    
    /**
     * Set identity.
     * @param User $identity
     * @return FreeCode_Controller_Action
     */
    public function setIdentity($identity)
    {
        $this->_identity = $identity;
        return $this;
    }
    
    /**
     * Get identity.
     * @return User
     */
    public function getIdentity()
    {
        return $this->_identity;
    }
    
    /**
     * Set layout.
     * @param Zend_Layout $layout
     * @return FreeCode_Controller_Action
     */
    public function setLayout($layout)
    {
        $this->_layout = $layout;
        return $this;
    }
    
    /**
     * Get layout.
     * @return Zend_Layout
     */
    public function getLayout()
    {
        return $this->_layout;
    }
    
    /**
     * Set redirector.
     * @param Zend_Controller_Action_Helper_Redirector $redirector
     * @return FreeCode_Controller_Action
     */
    public function setRedirector($redirector)
    {
        $this->_redirector = $redirector;
        return $this;
    }
    
    /**
     * Get redirector.
     * @return Zend_Controller_Action_Helper_Redirector
     */
    public function getRedirector()
    {
        return $this->_redirector;
    }
    
    /**
     * Init action controller.
     * @return  void
     */
    public function init()
    {
        parent::init();
        
        $this->_layout = Zend_Layout::getMvcInstance();
        
        $this->_redirector = $this->_helper->getHelper('Redirector');

        /**
         * Set scripts order.
         */
        $this->view->addScriptPath(VIEWS_LAYOUTS_DIR);
        $this->view->addScriptPath(VIEWS_SCRIPTS_DIR.'/'.$this->_request->getModuleName());
        
        /**
         * Enable theme overriding if theme is defined.
         */
        if (FreeCode_Config::isLoaded()) {
            $config = FreeCode_Config::getInstance();
            if (defined('THEMES_DIR') && isset($config->theme)) {
                $this->view->addScriptPath(THEMES_DIR.'/'.$config->theme.'/layouts');
                $this->view->addScriptPath(
                    THEMES_DIR.'/'.$config->theme.'/scripts/'
                    .$this->_request->getModuleName());
            }
        }
        
        if (isset($_SERVER['HTTP_REFERER']))
            $this->_prevUrl = $_SERVER['HTTP_REFERER'];
            
        FreeCode_Identity::reload();
        $this->_identity = FreeCode_Identity::getInstance();
        $this->view->identity = $this->_identity;
    }
    
    /**
     * Go to the previous page (using HTTP_REFERER).
     * @return  boolean
     */
    public function goBack()
    {
        if (!FreeCode_Test::isEnabled()) {
            $this->_redirect($this->_prevUrl);
            exit(0);
        }
        return true;
    }
    
    /**
     * Go to the action and exit.
     * @param   array   $params
     * @param   string  $route  Name of the route
     * @return  boolean
     */
    public function goToAction($params = array(), $route = null)
    {
        if (is_string($params) && !FreeCode_Test::isEnabled())
            return $this->_redirector->gotoSimpleAndExit($params);

        if (!is_array($params))
            throw new Exception('Given parameter is not an array!');

        if (isset($route) && !FreeCode_Test::isEnabled())
            return $this->_redirector->gotoRoute($params, $route);

        $module = $this->_request->getModuleName();
        $controller = $this->_request->getControllerName();
        $action = $this->_request->getActionName();

        if (isset($params['module'])) {
            $module = $params['module'];
            unset($params['module']);
        }

        if (isset($params['controller'])) {
            $controller = $params['controller'];
            unset($params['controller']);
        }

        if (isset($params['action'])) {
            $action = $params['action'];
            unset($params['action']);
        }

        if (!FreeCode_Test::isEnabled()) {
            $this->_redirector->gotoSimpleAndExit($action, $controller, $module, $params);
            exit(0);
        }
        return true;
    }
    
    /**
     * Go to the url.
     * @param   string  $url
     * @return  boolean
     */
    public function goToUrl($url)
    {
        if (!FreeCode_Test::isEnabled()) {
            // Below sucks.
            //return $this->_redirector->gotoUrl($url);
            header("Location: {$url}");
            exit(0);
        }
        return true;
    }
    
    /**
     * Returns true if request method is post, false otherwise.
     * @return  boolean
     */
    public function isPostRequest()
    {
        return $this->_request->isPost();    
    }
    
    /**
     * Returns true if request method is get, false otherwize.
     * @return  boolean
     */
    public function isGetRequest()
    {
        return !$this->_request->isPost();
    }
    
    /**
     * Render a view as a part of the layout.
     * @param   string  $partName   Name of the layouts part ($this->layout()->partName)
     * @param   string  $scriptPath Filename
     * @return  FreeCode_Controller_Action
     */
    public function renderLayoutPart($partName, $scriptPath)
    {
        $this->_response->insert($partName, $this->view->render($scriptPath));
        return $this;
    }
    
    /**
     * Disable layout. View is still enabled.
     * @return  FreeCode_Controller_Action
     */
    public function disableLayout()
    {
        $this->_helper->layout()->disableLayout();
        return $this;
    }
    
    /**
     * Enable layout.
     * @return  FreeCode_Controller_Action
     */
    public function enableLayout()
    {
        $this->_helper->layout()->enableLayout();
        return $this;
    }
    
    /**
     * Check if layout is enabled or not.
     * @return  boolean
     */
    public function isLayoutEnabled()
    {
        return $this->_helper->layout()->isEnabled();
    }
    
    /**
     * Set layout script name.
     * @param   string  $scriptName
     * @return  FreeCode_Controller_Action
     */
    public function setLayoutScript($scriptName)
    {
        $this->_helper->layout()->setLayout($scriptName);
        return $this;
    }
    
    /**
     * Get layout script name.
     * @return  string
     */
    public function getLayoutScript()
    {
        return $this->_helper->layout()->getLayout();
    }
    
    /**
     * Disable view. Layout is still enabled.
     * @return  FreeCode_Controller_Action
     */
    public function disableView()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        return $this;
    }
    
    /**
     * Enable view.
     * @return  FreeCode_Controller_Action
     */
    public function enableView()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        return $this;
    }

    /**
     * Check if view is enabled.
     * @return  boolean
     */
    public function isViewEnabled()
    {
        return $this->_helper->viewRenderer->getNoRender();
    }
    
    /**
     * Validate form.
     * @param   Zend_Form   $form           
     * @param   string      $subFormName    Name of the subform.
     * @return  array | null
     */
    public function validateForm(Zend_Form $form, $subFormName = null)
    {
        if (!$this->isPostRequest())
            return null;
        
        $data = $this->_request->getPost($subFormName);
        if (!$data)
            throw new Exception('Null post data, check form and sub form names!');
        
        if ($form->isValid($data)) {
            $data = $this->getFilteredPostValues($form);
            
            if ($form instanceof FreeCode_Form && $form->isUploadEnabled()) {
                $info = $this->receiveUpload($form);
                if (!empty($info))
                    $data['files'] = $info;
            }
            
            unset($data['submit']);
            unset($data['captcha']);
            
            return $data;
        }
        
        return null;
    }

    /**
     * Get filtered post values.
     * @param   Zend_Form   $form   
     * @return  array
     */
    public function getFilteredPostValues(Zend_Form $form)
    {
        $data = array();
        $elements = $form->getElements();
        foreach ($elements as $element) {
            if (!($element instanceof Zend_Form_Element_File))
                $data[$element->getName()] = $element->getValue();
        }
        
        if (isset($data['submit']))
            unset($data['submit']);

        return $data;
    }
    
    /**
     * Receive upload from all Zend_Form_Element_File objects.
     * @param   Zend_Form   $form   
     * @return  array
     */
    public function receiveUpload(Zend_Form $form)
    {
        $infoArray = array();
            
        $elements = $form->getElements();
        foreach ($elements as $element) {
            if ($element instanceof Zend_Form_Element_File) {
                if (!($info = $this->receiveUploadFromElement($element)))
                    throw new Exception("Upload from element '{$element->getName()}' failed!");
                if (!empty($info))
                    $infoArray[$element->getName()] = $info;
            }
        }

        $subForms = $form->getSubForms();
        foreach ($subForms as $subForm) {
            $info = $this->receiveUpload($subForm);
            $infoArray = array_merge($infoArray, $info);
        }
        return $infoArray;
    }
    
    /**
     * Receive and process upload from file.
     * @param   Zend_Form_Element_File  $element    
     * @return  boolean
     */
    public function receiveUploadFromElement(Zend_Form_Element_File $element)
    {
        if (!$element->receive())
            return false;

        // Get element id for info.
        if ($element->getBelongsTo())
            $fileId = "{$element->getBelongsTo()}_{$element->getName()}_"; /// @todo
        else
            $fileId = $element->getName();

        /// @TODO: Check this!
        $path = $element->getFileName();
        if (empty($path))
            return true;
            
        if (!file_exists($path)) // probably after FreeCode_Filter_File_Remove
            return true;

        // Get info about file.
        $pathInfo = pathinfo($path);
        $fileInfo = $element->getTransferAdapter()->getFileInfo();

        // Create info about file.
        $info = array();
        $info['path'] = $path;
        $info['size'] = filesize($path);
        $info['md5'] = md5_file($path);
        $info['sha1'] = sha1_file($path);
        $info['type'] = $fileInfo[$fileId]['type'];
        $info['fileName'] = $fileInfo[$fileId]['name'];
        $info['name'] = $pathInfo['filename'];
        $info['extension'] = (isset($pathInfo['extension']) ? $pathInfo['extension'] : null);
        $info['destination'] = $pathInfo['dirname'];

        // Get image info.
        $imageTypes = array('image/jpeg', 'image/png');
        if (in_array($info['type'], $imageTypes)) {
            $imageInfo = getimagesize($info['path']);
            $info['isImage']    = true;
            $info['width']      = $imageInfo[0];
            $info['height']     = $imageInfo[1];
            $info['bits']       = $imageInfo['bits'];
            //$info['channels']   = $imageInfo['channels'];
        
        } else {
            $info['isImage'] = false;    
        }

        $this->handleUploadedFile($element, $info);
        return $info;
    }

    /**
     * Hook for handling upload.
     * @param   Zend_Form_Element_File  $element    
     * @param   array                   $info       
     * @return  boolean
     */
    public function handleUploadedFile(Zend_Form_Element_File $element, array $info)
    {
        //var_dump($info);
    }

    /**
     * Send json response.
     * @param   array $json
     * @return  void
     */
    public function sendJsonResponse($json)
    {
        if (is_array($json))
            $json = Zend_Json_Encoder::encode($json);
        
        $this->disableLayout();
        $this->disableView();
        
        $this->_response->setHeader('Content-Type', 'text/javascript');
        $this->_response->appendBody($json);
    }
    
    /**
     * Get action url.
     * @param   array   $params 
     * @param   string  $route  
     * @return  string
     */
    public function url($params = array(), $route = null)
    {
        return $this->view->url($params, $route);
    }
    
}