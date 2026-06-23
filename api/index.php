<?php
// Set FCPATH to the project root directory so assets, system, and application paths are resolved correctly
define('FCPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Load the main index.php from the root
require __DIR__ . '/../index.php';
