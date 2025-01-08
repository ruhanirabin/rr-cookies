<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package RR_Cookies
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin options
$options = array(
    'rr_cookies_settings',
    'rr_cookies_appearance',
    'rr_cookies_content',
    'rr_cookies_advanced'
);

foreach ($options as $option) {
    delete_option($option);
}
