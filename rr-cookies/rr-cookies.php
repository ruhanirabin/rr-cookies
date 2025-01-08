<?php
/**
 * Plugin Name: RR Cookies
 * Plugin URI: https://www.ruhanirabin.com/rr-cookies
 * Description: A comprehensive cookie consent management solution for WordPress
 * Version: 1.0.0
 * Requires at least: 6.5
 * Requires PHP: 8.2
 * Author: Ruhani Rabin
 * Author URI: https://www.ruhanirabin.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: rr-cookies
 * Domain Path: /languages
 *
 * @package RR_Cookies
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Plugin version
define('RR_COOKIES_VERSION', '1.0.0');
define('RR_COOKIES_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RR_COOKIES_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Class RR_Cookies
 */
class RR_Cookies {
    /**
     * Instance of this class.
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * Initialize the plugin.
     */
    private function __construct() {
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Get an instance of this class.
     *
     * @return RR_Cookies
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Load the required dependencies.
     *
     * @return void
     */
    private function load_dependencies() {
        require_once RR_COOKIES_PLUGIN_DIR . 'includes/class-rr-cookies-loader.php';
        require_once RR_COOKIES_PLUGIN_DIR . 'includes/class-rr-cookies-i18n.php';
        require_once RR_COOKIES_PLUGIN_DIR . 'admin/class-rr-cookies-admin.php';
        require_once RR_COOKIES_PLUGIN_DIR . 'public/class-rr-cookies-public.php';
    }

    /**
     * Set the locale for internationalization.
     *
     * @return void
     */
    private function set_locale() {
        $plugin_i18n = new RR_Cookies_i18n();
        add_action('plugins_loaded', array($plugin_i18n, 'load_plugin_textdomain'));
    }

    /**
     * Register all of the hooks related to the admin area.
     *
     * @return void
     */
    private function define_admin_hooks() {
        $plugin_admin = new RR_Cookies_Admin();
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_scripts'));
        add_action('admin_menu', array($plugin_admin, 'add_plugin_admin_menu'));
    }

    /**
     * Register all of the hooks related to the public-facing functionality.
     *
     * @return void
     */
    private function define_public_hooks() {
        $plugin_public = new RR_Cookies_Public();
        add_action('wp_enqueue_scripts', array($plugin_public, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($plugin_public, 'enqueue_scripts'));
        add_action('wp_footer', array($plugin_public, 'display_cookie_banner'));
    }
}
