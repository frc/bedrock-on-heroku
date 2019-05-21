<?php

/** @var string Directory containing all of the site's files */
$root_dir = dirname(__DIR__);

/** @var string Document Root */
$webroot_dir = $root_dir . '/web';

/**
 * Expose global env() function from oscarotero/env
 */
Env::init();

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = new Dotenv\Dotenv($root_dir);
if (file_exists($root_dir . '/.env')) {
    $dotenv->load();
}

/**
 * Set up our global environment constant and load its config first
 * Default: development
 */
define('WP_ENV', env('WP_ENV') ?: 'development');

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}

/**
 *
 */
define('WP_CACHE', env('WP_CACHE'));

/**
 * URLs
 */
if (array_key_exists('HTTP_X_FORWARDED_PROTO',$_SERVER) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == 'https') $_SERVER['HTTPS'] = 'on';
$_server_http_host_scheme = array_key_exists('HTTPS',$_SERVER) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$_server_http_host_name = array_key_exists('HTTP_HOST',$_SERVER) ? $_SERVER['HTTP_HOST'] : 'localhost';
$_server_http_url = "$_server_http_host_scheme://$_server_http_host_name";
define('WP_HOME', (env('WP_HOME') ?: "$_server_http_url"));
define('WP_SITEURL', (env('WP_SITEURL') ?: "$_server_http_url/wp"));

/**
 * Custom Content Directory
 */
define('CONTENT_DIR', '/app');

if (defined('WP_CLI') && WP_CLI) {
    define('WP_CONTENT_DIR', dirname( __FILE__ ) . '/../web' . CONTENT_DIR);
}else{
    define('WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR);
}

define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);

/**
 * DB settings
 */
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));

/**
 * Custom Settings
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);
define('DISALLOW_FILE_EDIT', true);

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}

/**
 * Multi Site
 *
 * If your Multisite is running on multiple domains
 * f.ex.: www.example.com main domain and www.subexample.com (instead of sub.example.com) as sub domain
 * use $_SERVER[ 'HTTP_HOST' ] instead of WP_MULTISITE_MAIN_DOMAIN in DOMAIN_CURRENT_SITE:
 * define( 'DOMAIN_CURRENT_SITE', $_SERVER[ 'HTTP_HOST' ]  );
 *
 * Without this, logins will only work in the DOMAIN_CURRENT_SITE.
 * Reauth is required on all sites in the network after this.
 */
define('WP_ALLOW_MULTISITE', env('WP_ALLOW_MULTISITE'));

if (env('WP_MULTISITE_MAIN_DOMAIN')) {
    define('MULTISITE', true);
    define('SUBDOMAIN_INSTALL', env('SUBDOMAIN_INSTALL') !== false);
    define('PATH_CURRENT_SITE', '/');
    define('SITE_ID_CURRENT_SITE', 1);
    define('BLOG_ID_CURRENT_SITE', 1);

    if (array_key_exists('HTTP_HOST', $_SERVER) && strpos($_SERVER['HTTP_HOST'], 'localhost.frc.io') !== false) {
        define('DOMAIN_CURRENT_SITE', env('WP_MULTISITE_MAIN_DOMAIN'));
    } else {
        $_server_http_host_name = array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : env('WP_MULTISITE_MAIN_DOMAIN') ?: 'localhost.frc.io';
        define('DOMAIN_CURRENT_SITE', $_server_http_host_name);
    }
}
