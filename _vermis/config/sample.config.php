<?php

/**
 * Vermis - The Issue Tracking System
 * Example configuration file.
 * $Id: sample.config.php 1102 2011-01-29 23:37:17Z cepa $
 */

return array(

    // Name of the environment.
    'environment' => 'prod',

    // The 'prod' environment (production).
    'prod' => array(
        
        // The base host with the protocol type.
        // For example 'http://localhost' or 'https://your.domain.tld'.
        'baseHost'                  => 'http://localhost',

        // The base URI on your host.
        // If your vermis installation is available on 
        // http://your.domain.tld/some/directory
        // then you should set baseUri to '/some/directory/'
        // Make sure that you have a slash at the end of URI!
        'baseUri'                   => '/',

        // Theme name, see /_vermis/themes.
        'theme'						=> 'default',

        // Localization.
        // Name of the translation file from app/lang directory.
        'locale'                    => 'en_US',

        // If true then don't detect browser language automatically and use 
        // default locale setting. If false then check browser language and
        // adjust locale setting. 
        'useFixedLocale'			=> false,

        // The maximum size of the uploaded file.
        // The default is 1MB.
        'uploadMaxSize'             => 1048576, // 1MB
        
        // Date formatting.
        // Take a look on date function arguments from php.
        'dateFormat'                => 'Y-m-d H:i:s',

        // Mailing section.
        'mailer' => array(

            // Enable mailing in Vermis.
            'enable'       => false,

            // The 'From' header.
            'from'          => 'no-reply@localhost',

            // Prefix title.
            // Sent email will have a title like 
            // "[Vermis] - Something" or "[My title] - Something else"
            'titleHeader'   => 'Vermis',

            /*
             * Uncomment the section below if you want to have a SMTP mailing.
             */
            /*
            // SMTP connector.
            'smtp' => array(
                
                // SMTP server.
                'host'		=> 'mail.mydomain.tld',
                
                // Authentication method
                // 'plain' or 'login' or 'crammd5'
                'auth'		=> 'login',

                // Username.
                'username'	=> 'my.username',

                // Password.
                'password'	=> 'my.password'
            )
            */
        ),

        // Database section.
        'database' => array(
        
            // The database driver.
            // You should not change this value!
            // It should be 'mysql'
            'driver'    => 'mysql',
        
            // Database hostname or ip address.
            'host'      => 'localhost',
        
            // Name of the database.
            'name'      => 'vermis',
        
            // Database username.
            'user'      => 'vermis',
        
            // Database password.
            'password'  => 'vermis',
        
            // Database server port.
            'port'      => 3306,
        
            // Enable query debugging.
            'debug'     => false
        ),
        
        // Enables in user registration the acceptance of a licence.
        // Licence text must be written in row 13 of _vermis/themes/default/scripts/users/register.phtml
        'showRegisterAcceptLicence' => true,
        
        // Throw exceptions instead of displaying Error 404 page.
        // This should not be set to true when using Vermis in production!
        'throwExceptions'   => false
    ) 

);
