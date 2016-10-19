<?php

/**
 * =============================================================================
 * @file        WebTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: WebTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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