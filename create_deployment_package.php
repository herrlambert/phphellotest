<?php
/**
 * Simple script to create a deployment package
 * 
 * Run this script from the command line:
 * php create_deployment_package.php
 */

echo "Creating deployment package...\n";

// Define the directories and files to include
$directories = [
    'app',
    'config',
    'public'
];

$files = [
    '.htaccess',
    'README.md'
];

// Create a temporary directory for the package
$tempDir = 'deployment_package';
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755);
}

// Copy directories
foreach ($directories as $dir) {
    echo "Copying directory: $dir\n";
    copyDirectory($dir, $tempDir . '/' . $dir);
}

// Copy files
foreach ($files as $file) {
    echo "Copying file: $file\n";
    copy($file, $tempDir . '/' . $file);
}

// Create a ZIP archive
$zipFile = 'mvc_app_deployment.zip';
echo "Creating ZIP archive: $zipFile\n";

// Create ZIP archive
if (extension_loaded('zip')) {
    createZipArchive($tempDir, $zipFile);
    echo "ZIP archive created successfully.\n";
} else {
    echo "ZIP extension not available. Please manually ZIP the '$tempDir' directory.\n";
}

echo "Deployment package created in: $tempDir\n";
if (file_exists($zipFile)) {
    echo "ZIP archive created: $zipFile\n";
}

echo "Done!\n";

/**
 * Copy a directory recursively
 * 
 * @param string $source Source directory
 * @param string $destination Destination directory
 */
function copyDirectory($source, $destination) {
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }
    
    $dir = opendir($source);
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $srcFile = $source . '/' . $file;
            $destFile = $destination . '/' . $file;
            
            if (is_dir($srcFile)) {
                copyDirectory($srcFile, $destFile);
            } else {
                copy($srcFile, $destFile);
            }
        }
    }
    closedir($dir);
}

/**
 * Create a ZIP archive
 * 
 * @param string $source Source directory
 * @param string $destination Destination ZIP file
 */
function createZipArchive($source, $destination) {
    if (file_exists($destination)) {
        unlink($destination);
    }
    
    $zip = new ZipArchive();
    if ($zip->open($destination, ZipArchive::CREATE) === true) {
        addDirToZip($zip, $source, basename($source));
        $zip->close();
        return true;
    } else {
        return false;
    }
}

/**
 * Add a directory to a ZIP archive recursively
 * 
 * @param ZipArchive $zip ZIP archive
 * @param string $source Source directory
 * @param string $relativePath Relative path in the ZIP
 */
function addDirToZip($zip, $source, $relativePath = '') {
    $source = rtrim($source, '/\\') . '/';
    
    // Create recursive directory iterator
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($files as $file) {
        // Skip directories (they would be added automatically)
        if ($file->isDir()) {
            continue;
        }
        
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen(dirname($source)) + 1);
        
        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}
