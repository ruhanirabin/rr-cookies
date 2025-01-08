<?php
/**
 * Fired during plugin deactivation.
 *
 * @package RR_Cookies
 */

class RR_Cookies_Deactivator {
    /**
     * Clean up plugin data on deactivation if requested.
     */
    public static function deactivate() {
        $settings = get_option('rr_cookies_advanced');
        
        if (isset($settings['cleanup_on_deactivate']) && $settings['cleanup_on_deactivate']) {
            self::cleanup_plugin_data();
        }
    }

    /**
     * Remove all plugin data from the database.
     */
    private static function cleanup_plugin_data() {
        $options = array(
            'rr_cookies_settings',
            'rr_cookies_appearance',
            'rr_cookies_content',
            'rr_cookies_advanced'
        );

        foreach ($options as $option) {
            delete_option($option);
        }

        // Remove any transients
        delete_transient('rr_cookies_cache');
    }
}
