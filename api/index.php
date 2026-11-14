<?php
// Normalize SCRIPT_NAME and PHP_SELF for Vercel rewrites to prevent CodeIgniter router from getting confused
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

// Set FCPATH to the project root directory so assets, system, and application paths are resolved correctly
define('FCPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Ensure writable SQLite database in /tmp for Vercel Serverless environment
$seed_db = dirname(__DIR__) . '/application/database/macha.sqlite';
$tmp_db  = '/tmp/macha.sqlite';
if (!file_exists($tmp_db) && file_exists($seed_db)) {
    @copy($seed_db, $tmp_db);
}

// Load the main index.php from the root
require __DIR__ . '/../index.php';
