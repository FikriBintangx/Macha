<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

if ( ! function_exists('get_db_env')) {
	function get_db_env($name, $default = '') {
		if (isset($_ENV[$name]) && $_ENV[$name] !== '') {
			return $_ENV[$name];
		}
		if (isset($_SERVER[$name]) && $_SERVER[$name] !== '') {
			return $_SERVER[$name];
		}
		$val = getenv($name);
		return ($val !== FALSE && $val !== '') ? $val : $default;
	}
}

$db_driver = get_db_env('DB_DRIVER', 'sqlite3');
$db_host = get_db_env('DB_HOST', '');

// Prepare writable SQLite database path in /tmp for Vercel Serverless environment
$sqlite_seed = APPPATH . 'database/macha.sqlite';
$sqlite_tmp  = '/tmp/macha.sqlite';

if (!file_exists($sqlite_tmp) && file_exists($sqlite_seed)) {
    @copy($sqlite_seed, $sqlite_tmp);
}

$active_sqlite = file_exists($sqlite_tmp) ? $sqlite_tmp : $sqlite_seed;

// If explicitly sqlite3, or host contains expired aivencloud, or no host provided: Use SQLite3
if ($db_driver === 'sqlite3' || empty($db_host) || strpos($db_host, 'aivencloud.com') !== FALSE) {
    $db['default'] = array(
        'dsn'	       => '',
        'hostname'     => '',
        'port'         => '',
        'username'     => '',
        'password'     => '',
        'database'     => $active_sqlite,
        'dbdriver'     => 'sqlite3',
        'dbprefix'     => '',
        'pconnect'     => FALSE,
        'db_debug'     => FALSE,
        'cache_on'     => FALSE,
        'cachedir'     => '',
        'char_set'     => 'utf8',
        'dbcollat'     => 'utf8_general_ci',
        'swap_pre'     => '',
        'encrypt'      => FALSE,
        'compress'     => FALSE,
        'stricton'     => FALSE,
        'failover'     => array(),
        'save_queries' => TRUE
    );
} else {
    // MySQL configuration with failover to SQLite3
    $db['default'] = array(
        'dsn'	       => '',
        'hostname'     => $db_host,
        'port'         => get_db_env('DB_PORT', 3306),
        'username'     => get_db_env('DB_USER', 'root'),
        'password'     => get_db_env('DB_PASS', ''),
        'database'     => get_db_env('DB_NAME', 'macha'),
        'dbdriver'     => get_db_env('DB_DRIVER', 'mysqli'),
        'dbprefix'     => '',
        'pconnect'     => FALSE,
        'db_debug'     => FALSE,
        'cache_on'     => FALSE,
        'cachedir'     => '',
        'char_set'     => 'utf8',
        'dbcollat'     => 'utf8_general_ci',
        'swap_pre'     => '',
        'encrypt'      => get_db_env('DB_SSL', 'false') === 'true' ? array('ssl_verify' => FALSE) : FALSE,
        'compress'     => FALSE,
        'stricton'     => FALSE,
        'failover'     => array(
            array(
                'dsn'	       => '',
                'hostname'     => '',
                'port'         => '',
                'username'     => '',
                'password'     => '',
                'database'     => $active_sqlite,
                'dbdriver'     => 'sqlite3',
                'dbprefix'     => '',
                'pconnect'     => FALSE,
                'db_debug'     => FALSE,
                'cache_on'     => FALSE,
                'cachedir'     => '',
                'char_set'     => 'utf8',
                'dbcollat'     => 'utf8_general_ci',
                'swap_pre'     => '',
                'encrypt'      => FALSE,
                'compress'     => FALSE,
                'stricton'     => FALSE
            )
        ),
        'save_queries' => TRUE
    );
}
