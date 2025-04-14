<?php
/**
 * Application Bootstrap File
 */

// Determine environment and load appropriate configuration
$env = getenv('APP_ENV') ?: 'development';
$configFile = '/config/config.' . $env . '.php';

// If environment-specific config exists, use it; otherwise, use default
if (file_exists(dirname(__DIR__) . $configFile)) {
    require_once dirname(__DIR__) . $configFile;
} else {
    require_once dirname(__DIR__) . '/config/config.php';
}

// Autoloader
require_once 'core/Autoloader.php';
$autoloader = new \App\Core\Autoloader();
$autoloader->register();

// Error handling
if (defined('APP_DEBUG') && APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

set_error_handler(function($level, $message, $file, $line) {
    if (error_reporting() & $level) {
        throw new \ErrorException($message, 0, $level, $file, $line);
    }
});

// Set default timezone
date_default_timezone_set('UTC');
