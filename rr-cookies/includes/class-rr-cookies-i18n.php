<?php
/**
 * Define the internationalization functionality.
 *
 * @package RR_Cookies
 */

class RR_Cookies_i18n {
    /**
     * Load the plugin text domain for translation.
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'rr-cookies',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }

    /**
     * Get translatable strings for JavaScript.
     *
     * @return array
     */
    public static function get_js_translations() {
        return array(
            'necessary' => array(
                'title' => __('Necessary Cookies', 'rr-cookies'),
                'description' => __('These cookies are essential for the website to function properly.', 'rr-cookies'),
            ),
            'analytics' => array(
                'title' => __('Analytics Cookies', 'rr-cookies'),
                'description' => __('These cookies help us understand how visitors interact with the website.', 'rr-cookies'),
            ),
            'marketing' => array(
                'title' => __('Marketing Cookies', 'rr-cookies'),
                'description' => __('These cookies are used to deliver advertisements more relevant to you and your interests.', 'rr-cookies'),
            ),
            'buttons' => array(
                'accept' => __('Accept All', 'rr-cookies'),
                'reject' => __('Reject All', 'rr-cookies'),
                'save' => __('Save Preferences', 'rr-cookies'),
                'close' => __('Close', 'rr-cookies'),
            ),
            'notices' => array(
                'saved' => __('Your preferences have been saved.', 'rr-cookies'),
                'error' => __('An error occurred. Please try again.', 'rr-cookies'),
            ),
        );
    }
}
