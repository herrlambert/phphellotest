<?php
/**
 * Main entry point for the application
 */

// Define the application root directory
define('APP_ROOT', dirname(__DIR__));

// Load the bootstrap file
require_once APP_ROOT . '/app/bootstrap.php';

// Initialize Router
$router = new \App\Core\Router();

// Define routes
$router->addRoute('', ['controller' => 'Home', 'action' => 'index']);
$router->addRoute('home', ['controller' => 'Home', 'action' => 'index']);
$router->addRoute('home/index', ['controller' => 'Home', 'action' => 'index']);

// Dispatch the request
$router->dispatch($_SERVER['QUERY_STRING'] ?? '');
