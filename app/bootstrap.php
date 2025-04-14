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
$autoloaderPath = __DIR__ . '/core/Autoloader.php';
if (!file_exists($autoloaderPath)) {
    // Try case-insensitive search
    $coreDir = __DIR__ . '/core';
    if (is_dir($coreDir)) {
        $files = scandir($coreDir);
        foreach ($files as $file) {
            if (strtolower($file) === 'autoloader.php') {
                $autoloaderPath = $coreDir . '/' . $file;
                break;
            }
        }
    }
}

if (!file_exists($autoloaderPath)) {
    die('Autoloader not found at: ' . $autoloaderPath);
}

require_once $autoloaderPath;
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
