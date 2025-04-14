# PHP MVC Hello World Application

A simple MVC (Model-View-Controller) application built with PHP.

## Project Structure

```
/
├── app/
│   ├── controllers/    # Controller classes
│   ├── core/           # Core framework classes
│   ├── models/         # Model classes
│   ├── views/          # View templates
│   └── bootstrap.php   # Application bootstrap
├── config/             # Configuration files
├── public/             # Public-facing files
│   ├── index.php       # Front controller
│   └── .htaccess       # URL rewriting rules
└── .htaccess           # Redirect to public directory
```

## Local Development

To run the application locally:

```bash
# Navigate to the project directory
cd path/to/project

# Start the PHP development server
php -S localhost:8000 -t public
```

Then visit http://localhost:8000 in your browser.

## Deployment to Shared Hosting

### 1. Prepare Your Files

- Make sure all files have the correct permissions:
  - Directories: 755 (rwxr-xr-x)
  - PHP files: 644 (rw-r--r--)

### 2. Upload Files

Use FTP/SFTP to upload all files to your hosting account:

#### Option A: Root Directory Deployment

- Upload all files to your public directory (usually `public_html`, `www`, or `htdocs`)
- Your application will be accessible at `yourdomain.com`

#### Option B: Subdirectory Deployment

- Upload all files to a subdirectory in your public directory
- Your application will be accessible at `yourdomain.com/subdirectory`
- Edit both .htaccess files to uncomment and adjust the RewriteBase lines:
  - Root .htaccess: `RewriteBase /subdirectory/`
  - Public .htaccess: `RewriteBase /subdirectory/public/`

### 3. Environment Configuration

For production environment:

- Set the environment variable in .htaccess (if supported by your host):
  ```
  SetEnv APP_ENV production
  ```
- Or create a PHP file in your document root:
  ```php
  <?php
  putenv('APP_ENV=production');
  ```

### 4. Troubleshooting

#### Common Issues

- **404 Errors**: Check your .htaccess files and make sure mod_rewrite is enabled
- **500 Errors**: Check your PHP version and server logs
- **Blank Page**: Enable error reporting temporarily for debugging
- **Class Not Found Errors**: This is often due to case sensitivity issues on Linux servers

#### Debugging Steps

1. **Use the debug.php file**:
   - Access `yourdomain.com/debug.php` to see detailed information about your server environment
   - This will show file paths, PHP version, and class loading status

2. **Check file permissions**:
   - Make sure all PHP files have 644 permissions
   - Directories should have 755 permissions

3. **Case sensitivity issues**:
   - Linux servers are case-sensitive, while Windows is not
   - Ensure that all file references match the actual case of the files
   - For example, 'Router.php' is different from 'router.php' on Linux

4. **Try the fallback index**:
   - If the main index.php is not working, rename `index.fallback.php` to `index.php`
   - This uses direct class loading instead of the autoloader

5. **Check error logs**:
   - Look at your server's error logs for more detailed error messages
   - In cPanel, this is usually under "Error Log" in the Logs section

## Requirements

- PHP 7.0 or higher
- mod_rewrite enabled (for Apache)