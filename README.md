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

- **404 Errors**: Check your .htaccess files and make sure mod_rewrite is enabled
- **500 Errors**: Check your PHP version and server logs
- **Blank Page**: Enable error reporting temporarily for debugging

## Requirements

- PHP 7.0 or higher
- mod_rewrite enabled (for Apache)