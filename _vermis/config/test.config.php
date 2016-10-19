<?php

/**
 * Vermis - The Issue Tracking System
 * Example configuration file.
 * $Id: sample.config.php 1102 2011-01-29 23:37:17Z cepa $
 */

$config = array(
    'DATABASE_DRIVER'	=> 'mysql',
    'DATABASE_HOST'		=> 'localhost',
    'DATABASE_PORT'		=> 3306,
    'DATABASE_USERNAME' => 'root',
    'DATABASE_PASSWORD' => ''
);

$ciConfig = strtolower(getenv('CONFIG'));
$dbHost = 'test-'.$ciConfig;
if (strstr($ciConfig, 'mysql')) {
    $config['DATABASE_DRIVER']    = 'mysql';
    $config['DATABASE_HOST']      = $dbHost;
    $config['DATABASE_PORT']      = 3306;
    $config['DATABASE_USERNAME']  = 'root';
    $config['DATABASE_PASSWORD']  = '';
} else if (strstr($ciConfig, 'postgresql')) {
    $config['DATABASE_DRIVER']    = 'pgsql';
    $config['DATABASE_HOST']      = $dbHost;
    $config['DATABASE_PORT']      = 5432;
    $config['DATABASE_USERNAME']  = 'postgres';
    $config['DATABASE_PASSWORD']  = 'postgres';
}

$config['DATABASE_NAME'] = 'vermis_ose_'.md5(getenv('NODE_NAME').getenv('JOB_NAME'));

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
            'driver'    => $config['DATABASE_DRIVER'],
        
            // Database hostname or ip address.
            'host'      => $config['DATABASE_HOST'],
        
            // Name of the database.
            'name'      => $config['DATABASE_NAME'],
        
            // Database username.
            'user'      => $config['DATABASE_USERNAME'],
        
            // Database password.
            'password'  => $config['DATABASE_PASSWORD'],
        
            // Database server port.
            'port'      => $config['DATABASE_PORT'],
        
            // Enable query debugging.
            'debug'     => false
        ),
        
        // Throw exceptions instead of displaying Error 404 page.
        // This should not be set to true when using Vermis in production!
        'throwExceptions'   => false
    ) 

);
