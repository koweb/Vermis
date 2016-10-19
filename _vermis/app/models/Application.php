<?php

/**
 * =============================================================================
 * @file        Application.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Application.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Application
 * @brief   Base application class.
 */
class Application extends FreeCode_Application
{
    
    /**
     * Singleton. Get application instance.
     * @return  Application
     */
    public static function getInstance()
    {
        static $instance;
        if (!isset($instance))
            $instance = new self;
        return $instance;
    }
    
    /**
     * Execution process.
     * @return void
     */
    public function execute()
    {
        $this
        	->systemCheck()
        	->installCheck()
            ->setupConfig()
            ->setupSession()
            ->setupMailer()
            ->setupPDO()
            ->setupDoctrine()
            ->setupTranslator()
            ->setupFrontController()
            ->setupRouter()
            ->setupView()
            ->setupIdentity()
            ->dispatch();
    }
    
    public function systemCheck()
    {
    	$requiredModules = array(
    		'ctype',
    		'dom',
    		'gd',
    		'session',
    		'iconv',
    		'json',
    		'mbstring',
    		'SPL',
    		'PDO',
    		'pdo_mysql'
    	);
    	$loadedModules = get_loaded_extensions();
    	foreach ($requiredModules as $module) {
    		if (!in_array($module, $loadedModules))
    			throw new FreeCode_Exception_SetupError(
    				"Module <strong style=\"color:#000\">{$module}</strong> is not supported by your version of PHP!",
    				"Please install <strong>{$module}</strong> extension.");
    	}
    	return $this;
    }
    
    public function installCheck()
    {
        $dirs = array(
            UPLOAD_DIR,
            UPLOAD_TMP_DIR,
            UPLOAD_ISSUES_DIR,
            CAPTCHA_DIR,
            LOG_DIR
        );
        
        foreach ($dirs as $path) {
            if (!is_dir($path))
                throw new FreeCode_Exception_SetupError(
                    "Directory {$path} does not exist!",
                    "Please create a new directory, for example:<br />mkdir {$path}");
            if (!is_writeable($path))
                throw new FreeCode_Exception_SetupError(
                    "Cannot write in {$path} directory!",
                    "Please set a permission to write, for example:<br />chmod -R ugo+w {$path}");
            if (!is_readable($path))
                throw new FreeCode_Exception_SetupError(
                    "Cannot read from {$path} directory!",
                    "Please set a permission to read, for example:<br />chmod -R ugo+r {$path}");
        }
        
        /*
         * Set some additional internal parameters for some classes.
         */
        FreeCode_View_Helper_Pager::$imagesPath = '_vermis/themes/default/gfx/pager';
        FreeCode_Grid_Decorator_Pager::$imagesPath = '_vermis/themes/default/gfx/grid';
    	
        return $this;
    }
    
    public function setupConfig($configPath = null)
    {
        try {
            return parent::setupConfig($configPath);
        } catch (FreeCode_Exception_FileNotFound $exc) {
            throw new FreeCode_Exception_SetupError(
            	"Config file does not exist!", 
            	"Please create a config/config.php file, you can copy the contents from config/sample.config.php.");
        } catch (FreeCode_Exception $exc) {
            throw new FreeCode_Exception_SetupError(
                "Your config/config.php file is invalid!",
                "Please check if there is no php syntax errors, etc...");
        }
    }
    
    public function setupPDO($config = null)
    {
        try {
            $ret =  parent::setupPDO($config);
            
            // Check database version.
            $stmt = FreeCode_PDO_Manager::getInstance()
                ->getCurrentConnection()
                ->prepare("SELECT version FROM version");
            $stmt->execute();
            $version = $stmt->fetchColumn();
            $requiredVersion = VERMIS_DB_VERSION;
            
            if ($version < $requiredVersion) {
                
                $vstr = '';
                $versions = array();
                for ($i = $version+1; $i <= $requiredVersion; $i++) {
                    $v = sprintf("%06d", $i);
                    $versions[] = $v;
                    $v .= '.sql';
                    $vstr .= '<strong>'.$v.'</strong> <small>(mysql -u youruser -p yourdb < fixtures/patches/'.$v.')</small><br />';
                }
                
                throw new FreeCode_Exception_SetupError(
                    "Your database is too old!",
                    "Your database version is {$version} and a required version is {$requiredVersion}!<br />".
                    "Please run database patches:<br />{$vstr}");
            
            } else if ($version > $requiredVersion) {
                throw new FreeCode_Exception_SetupError(
                    "Your Vermis files are too old!",
                    "Your database version is {$version} and files are valid for version {$requiredVersion}!<br />Please upgrade your files!");
            }
            
            return $ret;
        
        } catch (FreeCode_Exception_Database $exc) {
            throw new FreeCode_Exception_SetupError(
                "Cannot connect to the database!",
                "Please check in config/config.php file if your database settings are correct!");
        }
    }
    
    /**
     * Setup FreeCode_Identity, verify authentication and acl.
     * @return  Application
     */
    public function setupIdentity()
    {
        $role = User::ROLE_GUEST;
        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        
        if ($identity) {
            
            $isValid = true;

            // Validate array.
            if (!is_array($identity)) {
                $auth->clearIdentity();
            
            } else {
                
                // Confirm authenticatoin.
                $adapter = new FreeCode_Auth_Adapter_User($identity['login'], $identity['password_hash']);
                if ($auth->authenticate($adapter)->isValid()) {
                    $role = $identity['role'];
                
                } else {
                    $auth->clearIdentity();                    
                }
            }
            
        } else {
            $auth->clearIdentity();
        }
        
        // Acl
        $acl = new Acl;
        $this->_aclPlugin = new FreeCode_Controller_Plugin_Acl($acl, $role);
        $this->_frontController->registerPlugin($this->_aclPlugin);
        
        return $this;
    }
    
    /**
     * Detect browser localization.
     * @see FreeCode_Application::setupTranslator()
     */
    public function setupTranslator($locale = null, $translationPath = null)
    {
        $config = FreeCode_Config::getInstance();
        if (    isset($config->useFixedLocale) && 
                $config->useFixedLocale == true)
            return parent::setupTranslator($locale, $translationPath);

        if (!isset($_SERVER) || !isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
            return parent::setupTranslator($locale, $translationPath); 
        $ua = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $locales = array(
            'pl-PL' => 'pl_PL', 
        	'pl'    => 'pl_PL',
            'sl-SI' => 'sl_SI',
        	'sl'    => 'sl_SI',
            'nl-NL' => 'nl_NL',
            'nl'    => 'nl_NL',
            'fr-FR' => 'fr_FR',
            'fr'    => 'fr_FR',
            'de-DE' => 'de_DE',
            'de'    => 'de_DE',
            'es-LA' => 'es_LA',
            'es'    => 'es_LA',
            'en-US' => 'en_US', 
        	'en'    => 'en_US'
        );
        
        foreach ($locales as $name => $trans)
            if (strstr($ua, $name))
                return parent::setupTranslator($trans, $translationPath);
        
        return parent::setupTranslator($locale, $translationPath);    
    }
    
    /**
     * Check if application is running in demo mode.
     * @return boolean
     */
    public function isDemo()
    {
        return (Zend_Registry::get('environmentName') == 'demo' ? true : false);
    }
    
}
