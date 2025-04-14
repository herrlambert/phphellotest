<?php
/**
 * Debug file to help diagnose issues on shared hosting
 */

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>PHP Environment Information</h1>";

// PHP Version
echo "<h2>PHP Version</h2>";
echo "<p>" . phpversion() . "</p>";

// Server Information
echo "<h2>Server Information</h2>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";

// Directory Structure
echo "<h2>Directory Structure</h2>";

function listDirectory($dir, $indent = 0) {
    if (!is_dir($dir)) {
        echo str_repeat("&nbsp;", $indent * 4) . "Not a directory: $dir<br>";
        return;
    }
    
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file == '.' || $file == '..') continue;
        
        $path = $dir . '/' . $file;
        $isDir = is_dir($path);
        
        echo str_repeat("&nbsp;", $indent * 4) . 
             ($isDir ? "📁 " : "📄 ") . 
             htmlspecialchars($file) . 
             ($isDir ? "/" : "") . 
             "<br>";
        
        if ($isDir && $indent < 3) { // Limit recursion depth
            listDirectory($path, $indent + 1);
        }
    }
}

// Get application root directory
$appRoot = dirname(__DIR__);
echo "<p>App Root: " . htmlspecialchars($appRoot) . "</p>";
listDirectory($appRoot);

// Check for specific files
echo "<h2>File Existence Check</h2>";
$filesToCheck = [
    $appRoot . '/app/core/Router.php',
    $appRoot . '/app/core/Autoloader.php',
    $appRoot . '/app/controllers/HomeController.php',
    $appRoot . '/app/bootstrap.php',
    $appRoot . '/config/config.php'
];

echo "<ul>";
foreach ($filesToCheck as $file) {
    echo "<li>" . htmlspecialchars($file) . ": " . 
         (file_exists($file) ? "✅ Exists" : "❌ Not found") . "</li>";
    
    if (file_exists($file)) {
        echo "<li>File permissions: " . substr(sprintf('%o', fileperms($file)), -4) . "</li>";
    }
}
echo "</ul>";

// Check class loading
echo "<h2>Class Loading Test</h2>";
try {
    require_once $appRoot . '/app/core/Autoloader.php';
    echo "✅ Autoloader.php loaded successfully<br>";
    
    $autoloader = new \App\Core\Autoloader();
    echo "✅ Autoloader class instantiated successfully<br>";
    
    $autoloader->register();
    echo "✅ Autoloader registered successfully<br>";
    
    require_once $appRoot . '/app/core/Router.php';
    echo "✅ Router.php loaded successfully<br>";
    
    $router = new \App\Core\Router();
    echo "✅ Router class instantiated successfully<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}

echo "<p>End of debug information</p>";
