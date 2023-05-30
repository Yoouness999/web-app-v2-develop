<?php

/**
 * Cherry Pulp Custom Configuration
 *
 * This is where we put special configuration and env config
 *
 */
global $_config;

$_config = array(

    'project' => array(
        'title' => 'Boxify',
        'licence' => 'Cherry Pulp',
        'url' => 'http://www.boxify.be',
        'authors' => array(
            "Daniel Sum"        => 'daniel@cherrypulp.com',
            "Simon Vreux"       => 'simon@cherrypulp.com',
            "Stephan Zych"      => 'stephan@cherrypulp.com',
			"Armand Garot"      => 'armand@cherrypulp.com'
        ),
    ),

    'database' => array(
        'driver' => 'mysql',
        'name' => 'boxify_v2',
        'user' => 'boxify',
        'password' => 'ch3rr630826!',
        'host' => 'localhost',
        'charset' => 'utf8',
    ),

	'mail_encryption' => 'tls'
);

# if not defined choose a default server_name
if (!isset($_SERVER['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = "www.boxify.be";
}

if (!isset($_SERVER['HTTP_USER_AGENT'])) {
    $_SERVER['HTTP_USER_AGENT'] = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36";
}

/**
 * Loc environment is connected to the remote DB
 */
if (preg_match('/loc\./', $_SERVER['SERVER_NAME'])) {

    $segment = explode('.', $_SERVER['SERVER_NAME']);

    $_config['locales_url'] = [
        'en' => 'loc.boxify.be',
        'fr' => 'fr.loc.boxify.be',
        'nl' => 'nl.loc.boxify.be',
    ];

    if (count($segment) == 4) {
        define('ZE_LANG', $segment[0] == 'nl' ? 'nl' : 'fr');
        define('ROOT_URL', 'http://'.ZE_LANG.'.loc.boxify.be');
        define('CDN_URL', 'http://'.ZE_LANG.'.demo.boxify.be');
    } else{
        define('ZE_LANG', 'en');
        define('ROOT_URL', 'http://loc.boxify.be');
        define('CDN_URL', 'http://demo.boxify.be');
    }

    define('LEVEL_ENV', 0);
    define('WP_ENV', 'development');
    define('WP_DEBUG', false);
    define('APP_DEBUG', false);

    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

    $_config['database']['host'] = "37.187.199.183";

    error_reporting(E_ALL ^ E_DEPRECATED);
    ini_set('display_errors', 'On');

	define('REDIRECT_EMAIL', 'hardik.mehta@boxify.be');
	$_config['mail_encryption'] = '';

} elseif (preg_match('/(en|fr|nl)?local\./', $_SERVER['SERVER_NAME'])) {

    $_config['locales_url'] = [
        'en' => 'local.boxify.be',
        'fr' => 'fr.local.boxify.be',
        'nl' => 'nl.local.boxify.be',
    ];

    $segment = explode('.', $_SERVER['SERVER_NAME']);

    if (count($segment) == 4) {
        define('ZE_LANG', $segment[0]);
        define('ROOT_URL', 'http://' . ZE_LANG . '.local.boxify.be');
        define('CDN_URL', 'http://' . ZE_LANG . '.local.boxify.be');
    } else{
        define('ZE_LANG', 'en');
        define('ROOT_URL', 'http://local.boxify.be');
        define('CDN_URL', 'http://local.boxify.be');
    }

    define('LEVEL_ENV', 0);
    define('WP_ENV', 'development');
    define('WP_DEBUG', true);
    define('APP_DEBUG', true);

    ini_set('display_errors', 1);
    ini_set('log_errors', 1);

    $_config['database']['host'] = "localhost";
    $_config['database']['user'] = "root";
    $_config['database']['password'] = "";

	ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

	define('REDIRECT_EMAIL', 'hardik.mehta@boxify.be');

	$_config['mail_encryption'] = '';

} elseif (preg_match('/staging.boxify.be/', $_SERVER['SERVER_NAME'])) {

    $segment = explode('.', $_SERVER['SERVER_NAME']);

    $_config['locales_url'] = [
        'en' => 'staging.boxify.be',
        'fr' => 'fr.staging.boxify.be',
        'nl' => 'nl.staging.boxify.be',
    ];

    if (count($segment) == 4) {
        define('ZE_LANG', $segment[0] == 'nl' ? 'nl' : 'fr');
        define('ROOT_URL', 'http://'.ZE_LANG.'.staging.boxify.be');
        define('CDN_URL', 'http://'.ZE_LANG.'.staging.boxify.be');
    } else{
        define('ZE_LANG', 'en');
        define('ROOT_URL', 'http://staging.boxify.be');
        define('CDN_URL', 'http://staging.boxify.be');
    }

    define('LEVEL_ENV', 2);

    define('APP_DEBUG', false);
    ini_set('log_errors', 1);
    error_reporting(0);

    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

    $_config['database']['name'] = "boxify_staging";

    define('REDIRECT_EMAIL', 'hardik.mehta@boxify.be');
    $_config['mail_encryption'] = '';

} elseif (preg_match('/boxify.lademo.be/', $_SERVER['SERVER_NAME'])) {

    $segment = explode('.', $_SERVER['SERVER_NAME']);

    $_config['locales_url'] = [
        'en' => 'boxify.lademo.be',
        'fr' => 'fr.boxify.lademo.be',
        'nl' => 'nl.boxify.lademo.be',
    ];

    if (count($segment) == 4) {
        define('ZE_LANG', $segment[0] == 'nl' ? 'nl' : 'fr');
        define('ROOT_URL', 'http://'.ZE_LANG.'.boxify.lademo.be');
        define('CDN_URL', 'http://'.ZE_LANG.'.boxify.lademo.be');
    } else{
        define('ZE_LANG', 'en');
        define('ROOT_URL', 'http://boxify.lademo.be');
        define('CDN_URL', 'http://boxify.lademo.be');
    }

    define('LEVEL_ENV', 3);

    define('APP_DEBUG', true);
    ini_set('log_errors', 1);
    error_reporting(0);

    ini_set('display_errors', 0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

    $_config['database']['name'] = "boxify_demo";

    define('REDIRECT_EMAIL', 'hardik.mehta@boxify.be');
    $_config['mail_encryption'] = '';

} elseif (preg_match('/www2.boxify.be/', $_SERVER['SERVER_NAME'])) {

    $segment = explode('.', $_SERVER['SERVER_NAME']);

    $_config['locales_url'] = [
        'en' => 'www2.boxify.be',
        'fr' => 'fr.www2.boxify.be',
        'nl' => 'nl.www2.boxify.be',
    ];

    if (count($segment) == 4) {
        define('ZE_LANG', $segment[0] == 'nl' ? 'nl' : 'fr');
        define('ROOT_URL', 'http://'.ZE_LANG.'.www2.boxify.be');
        define('CDN_URL', 'http://'.ZE_LANG.'.www2.boxify.be');
    } else{
        define('ZE_LANG', 'en');
        define('ROOT_URL', 'http://www2.boxify.be');
        define('CDN_URL', 'http://www2.boxify.be');
    }

    define('LEVEL_ENV', 2);

    define('APP_DEBUG', false);
    ini_set('log_errors', 1);
    error_reporting(0);

    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

    $_config['database']['name'] = "boxify_demo";

    define('REDIRECT_EMAIL', 'hardik.mehta@boxify.be');
    $_config['mail_encryption'] = '';

} else {

    $segment = explode('.', $_SERVER['SERVER_NAME']);

    $_config['locales_url'] = [
        'en' => 'www.boxify.be',
        'fr' => 'fr.boxify.be',
        'nl' => 'nl.boxify.be',
    ];

    if (count($segment) == 2) {
        header('Location:http://www.boxify.be');
        exit();
    }

    if ($segment[0] != 'www') {
        define('ZE_LANG', $segment[0] == 'nl' ? 'nl' : 'fr');
        define('ROOT_URL', 'http://'.ZE_LANG.'.boxify.be');
        define('CDN_URL', 'http://'.ZE_LANG.'.boxify.be');
    } else{
        define('ZE_LANG', 'en');
        define('ROOT_URL', 'http://www.boxify.be');
        define('CDN_URL', 'http://www.boxify.be');
    }

    define('LEVEL_ENV', 3);

    define('APP_DEBUG', false);

    ini_set('display_errors', 0);
    ini_set('log_errors', 1);

    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
}

error_reporting(E_ALL ^ E_DEPRECATED);
