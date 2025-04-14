<?php
/**
 * Fallback entry point for the application
 * Use this file if the main index.php is not working
 */

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define the application root directory
define('APP_ROOT', dirname(__DIR__));

// Direct class loading without autoloader
require_once APP_ROOT . '/app/core/Controller.php';
require_once APP_ROOT . '/app/core/Router.php';
require_once APP_ROOT . '/app/controllers/HomeController.php';
require_once APP_ROOT . '/app/models/Message.php';

// Simple route handling
$path = $_SERVER['REQUEST_URI'] ?? '';
$path = trim(parse_url($path, PHP_URL_PATH), '/');

// Create controller instance
$controller = new \App\Controllers\HomeController();

// Call the index method
$controller->index();
