<?php

/**
 * =============================================================================
 * @file        WebTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: WebTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

class WebTest extends PHPUnit_Extensions_SeleniumTestCase
{

	protected $_url = null;
	
	protected function setUp()
	{
		Application::getInstance()->setupConfig();
		$config = FreeCode_Config::getInstance();
		$this->_url = $config->baseHost . $config->baseUri;
		
		$this->setBrowser('*firefox');
		$this->setBrowserUrl($config->baseHost);
	}
	
	public function testCase()
	{
		$this->open($this->_url);
		$this->assertTitle('Vermis');
	}

}