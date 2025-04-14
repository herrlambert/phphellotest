<?php
/**
 * Main entry point for the application
 */

// Define the application root directory
define('APP_ROOT', dirname(__DIR__));

// Load the bootstrap file
require_once APP_ROOT . '/app/bootstrap.php';

// Ensure Router class is loaded
$routerPath = APP_ROOT . '/app/core/Router.php';
if (!file_exists($routerPath)) {
    // Try case-insensitive search
    $coreDir = APP_ROOT . '/app/core';
    if (is_dir($coreDir)) {
        $files = scandir($coreDir);
        foreach ($files as $file) {
            if (strtolower($file) === 'router.php') {
                $routerPath = $coreDir . '/' . $file;
                break;
            }
        }
    }
}

if (!file_exists($routerPath)) {
    die('Router class not found at: ' . $routerPath);
}

// Manually include the Router class
require_once $routerPath;

// Initialize Router
$router = new \App\Core\Router();

// Define routes
$router->addRoute('', ['controller' => 'Home', 'action' => 'index']);
$router->addRoute('home', ['controller' => 'Home', 'action' => 'index']);
$router->addRoute('home/index', ['controller' => 'Home', 'action' => 'index']);

// Dispatch the request
$router->dispatch($_SERVER['QUERY_STRING'] ?? '');
