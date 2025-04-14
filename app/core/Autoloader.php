<?php
namespace App\Core;

/**
 * Simple Autoloader Class
 */
class Autoloader
{
    /**
     * Register the autoloader
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * Load a class
     * 
     * @param string $className The fully-qualified class name
     */
    public function loadClass($className)
    {
        // Convert namespace separators to directory separators
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        
        // Remove 'App' from the beginning if it exists
        if (strpos($className, 'App' . DIRECTORY_SEPARATOR) === 0) {
            $className = substr($className, 4);
        }
        
        // Build the file path
        $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $className . '.php';
        
        // If the file exists, require it
        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }
}
