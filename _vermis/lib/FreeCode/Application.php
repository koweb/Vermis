<?php

/**
 * =============================================================================
 * @file        FreeCode/Application.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Application.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Application
 * @brief   Application.
 */
class FreeCode_Application
{
    
    protected $_config = null;
    protected $_frontController = null;
    protected $_router = null;
    protected $_authPlugin = null;
    protected $_aclPlugin = null;

    protected function __construct() {}
    
    /**
     * Singleton pattern.
     * @return  FreeCode_Application
     */
    public static function getInstance()
    {
        static $instance;
        if (!isset($instance))
            $instance = new self;
        return $instance;
    }
    
    public function setConfig(Zend_Config $config)
    {
        $this->_config = $config;
        return $this;
    }
    
    public function getConfig()
    {
        if (!isset($this->_config))
            $this->setConfig(FreeCode_Config::getInstance());
        return $this->_config;
    }
    
    public function setFrontController(Zend_Controller_Front $frontController)
    {
        $this->_frontController = $frontController;
        return $this;
    }
    
    public function getFrontController()
    {
        if (!isset($this->_frontController))
            $this->setFrontController(Zend_Controller_Front::getInstance());
        return $this->_frontController;
    }
    
    public function setRouter(Zend_Controller_Router_Abstract $router)
    {
        $this->_router = $router;
        return $this;
    }
    
    public function getRouter()
    {
        if (!isset($this->_router))
            $this->setRouter(new Zend_Controller_Router_Rewrite);
        return $this->_router;
    }
    
    /**
     * Get uptime.
     * @return  float
     */
    public function getUptime()
    {
        global $bootTime;
        list($x, $y) = explode(' ', microtime());
        return (float)($x + $y - $bootTime);
    }
    
    /**
     * Setup configuration.
     * @param   $configPath string
     * @return  FreeCode_Application
     */
    public function setupConfig($configPath = null)
    {
        if (!FreeCode_Config::isLoaded()) {
            $path = (isset($path) ? $path : CONFIG_DIR.'/config.php');
            $this->setConfig(FreeCode_Config::load($path));
        } else {
            $this->setConfig(FreeCode_Config::getInstance());
        }
        return $this;
    }
    
    /**
     * Setup sessions.
     * @return  FreeCode_Application
     */
    public function setupSession()
    {
        if (isset($_GET['PHPSESID']))
            Zend_Session::setId($_GET['PHPSESID']);
        Zend_Session::start();   
        return $this;
    }
    
    /**
     * Setup locale and FreeCode_Translator.
     * @param   string  $locale
     * @param   string  $translationPath
     * @return  FreeCode_Application
     */
    public function setupTranslator($locale = null, $translationPath = null)
    {
        if (!isset($locale))
            $locale = (isset($this->getConfig()->locale) ? $this->getConfig()->locale : 'en_US');
            
        $translationPath = 
            (isset($translationPath) ? 
                $translationPath : LANG_DIR.'/'.$locale.'.php');
        
        Zend_Locale::setDefault($locale);
        $translator = FreeCode_Translator::load($translationPath, $locale);
        
        return $this;
    }
    
    /**
     * Setup PDO connection.
     * @param   $config array(
     *                      'driver'    => mysql|pgsql,
     *                      'host'      => XXX,
     *                      'name'      => XXX,
     *                      'user'      => XXX,
     *                      'password'  => XXX,
     *                      'port'      => XXX,
     *                      'debug'     => true|false
     *                  )
     * @return  FreeCode_Application
     */
    public function setupPDO($config = null)
    {
        if (    !isset($config)
                && !isset($this->_config) 
                && !isset($this->_config->database)
                && !FreeCode_Config::isLoaded())
            throw new FreeCode_Exception_Database("Database config missing!");

        $config = (isset($config) ? $config : $this->getConfig()->database); 
        
        if (is_array($config))
            $config = new Zend_Config($config);
        
        $dsn =
            $config->driver.':'.
            'dbname='.$config->name.';'.
            'host='.$config->host.';';
        if (isset($config->port))
            $dsn .= 'port='.$config->port.';';
            
        try {

            FreeCode_PDO_Manager::getInstance()
                ->getNewConnection($dsn, $config->user, $config->password);

        } catch (PDOException $e) {
            throw new FreeCode_Exception_Database('Database connection failed: '.$e->getMessage());
        }
        
        return $this;
    }
    
    /**
     * Setup Doctrine and PDO connection.
     * @param   $config array(
     *                      'driver'    => mysql|pgsql,
     *                      'host'      => XXX,
     *                      'name'      => XXX,
     *                      'user'      => XXX,
     *                      'password'  => XXX,
     *                      'port'      => XXX,
     *                      'debug'     => true|false
     *                  )
     * @return  FreeCode_Application
     */
    public function setupDoctrine($config = null)
    {
        if (isset($config))
            $this->setupPDO($config);
        
        try {
            $connection = Doctrine_Manager::getInstance()->getCurrentConnection();
        } catch (Exception $exc) {
            $pdo = FreeCode_PDO_Manager::getInstance()->getCurrentConnection();
            $connection = Doctrine_Manager::connection($pdo);
        }
        
        spl_autoload_register(array('Doctrine', 'autoload'));
        $connection->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);  

        return $this;
    }
    
    /**
     * Setup view.
     * @return  FreeCode_Application
     */
    public function setupView()
    {
        $layout = Zend_Layout::startMvc();
        // Don't set one layout location.
        //$layout->setLayoutPath(VIEWS_LAYOUTS_DIR);
        
        $view = $layout->getView();
        $view->addHelperPath('FreeCode/View/Helper', 'FreeCode_View_Helper');
        $view->addHelperPath(VIEWS_HELPERS_DIR, 'View_Helper');
        
        return $this;
    }
    
    /**
     * Setup front controller.
     * @return  FreeCode_Application
     */
    public function setupFrontController()
    {
        $this->getFrontController()->throwExceptions(isset($this->_config->throwExceptions) ? $this->_config->throwExceptions : false);

        $controllersPath = CONTROLLERS_DIR;
        $modules = array();
        if ($handle = @opendir($controllersPath)) {

            while ($module = readdir($handle)) {
                $path = $controllersPath.'/'.$module;
                if ($module{0} != '.' && is_dir($path)) {
                    $modules[strtolower($module)] = $path;
                }
            }
            closedir($handle);

            $this->getFrontController()
                ->setControllerDirectory($modules)
                ->setDefaultModule('default');

        } else {
            throw new Exception("Cannot load modules from '{$controllersPath}'!");
        }
        
        Zend_Controller_Action_HelperBroker::addPath(
            ROOT_DIR.'/lib/FreeCode/Controller/Action/Helper',
            'FreeCode_Controller_Action_Helper');
        
        Zend_Controller_Action_HelperBroker::addPath(
            ROOT_DIR.'/app/models/Controller/Action/Helper',
            'Controller_Action_Helper');
        
        return $this;
    }
    
    /**
     * Setup router.
     * @return  FreeCode_Application
     */
    public function setupRouter()
    {
        $routesFile = ROUTES_DIR.'/routes.php';
        if (file_exists($routesFile)) {
            $routes = @include $routesFile;
            if (!is_array($routes))
                throw new FreeCode_Exception("Invalid routes file '{$routesFile}'!");
            $this->getRouter()->addRoutes($routes);
        } else {
            throw new FreeCode_Exception("Routes file '{$routesFile}' not found!"); 
        }
        $this->getFrontController()->setRouter($this->getRouter());
        
        return $this;
    }
    
    /**
     * Setup mail transport.
     * @return FreeCode_Application
     */
    public function setupMailer()
    {
        // Set default transport to SMTP if it is set in config.
        if (    isset($this->_config->mailer) && 
                isset($this->_config->mailer->smtp)) {
            $smtp = $this->_config->mailer->smtp;

            $config = array();
            $config['auth'] = $smtp->auth;
            $config['username'] = $smtp->username;
            $config['password'] = $smtp->password;
            if (isset($smtp->ssl)) $config['ssl'] = $smtp->ssl;
            if (isset($smtp->port)) $config['port'] = $smtp->port;

            $transport = new Zend_Mail_Transport_Smtp($smtp->host, $config);
            Zend_Mail::setDefaultTransport($transport);
        }
        
        return $this;
    }

    /**
     * Execute dispatcher.
     * @return void
     */
    public function dispatch()
    {
        $this->getFrontController()->dispatch();
    }
    
}
