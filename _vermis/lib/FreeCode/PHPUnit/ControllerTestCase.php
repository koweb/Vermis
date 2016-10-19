<?php

/**
 * =============================================================================
 * @file        FreeCode/PHPUnit/ControllerTestCase.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: ControllerTestCase.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_PHPUnit_ControllerTestCase
 * @brief   Controller test case.
 */
abstract class FreeCode_PHPUnit_ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    
    /**
     * OVERLOAD.
     * Enable exceptions.
     * @see extern/Zend/Test/PHPUnit/Zend_Test_PHPUnit_ControllerTestCase#dispatch($url)
     */
    public function dispatch($url = null)
    {
        // redirector should not exit
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        $redirector->setExit(false);

        // json helper should not exit
        $json = Zend_Controller_Action_HelperBroker::getStaticHelper('json');
        $json->suppressExit = true;

        $request    = $this->getRequest();
        if (null !== $url) {
            $request->setRequestUri($url);
        }
        $request->setPathInfo(null);
        $controller = $this->getFrontController();
        $this->frontController
             ->setRequest($request)
             ->setResponse($this->getResponse())
             ->throwExceptions(true)
             ->returnResponse(false);
        $this->frontController->dispatch();
    }
    
    public function getController($className)
    {
        $controller = new $className(
            $this->request,
            $this->response,
            $this->request->getParams()
        );
        return $controller;
    }
    
}
