<?php
/**
 * Application Bootstrap File
 */

// Load configuration
require_once dirname(__DIR__) . '/config/config.php';

// Autoloader
require_once 'core/Autoloader.php';
$autoloader = new \App\Core\Autoloader();
$autoloader->register();

// Error handling
error_reporting(E_ALL);
set_error_handler(function($level, $message, $file, $line) {
    if (error_reporting() & $level) {
        throw new \ErrorException($message, 0, $level, $file, $line);
    }
});

// Set default timezone
date_default_timezone_set('UTC');
