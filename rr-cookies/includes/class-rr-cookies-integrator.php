<?php
/**
 * Integration hooks and filters for developers.
 *
 * @package RR_Cookies
 */

class RR_Cookies_Integrator {
    /**
     * Initialize the integrator.
     */
    public function __construct() {
        $this->add_hooks();
    }

    /**
     * Register integration hooks.
     */
    private function add_hooks() {
        add_filter('rr_cookies_consent_types', array($this, 'filter_consent_types'), 10, 1);
        add_filter('rr_cookies_banner_content', array($this, 'filter_banner_content'), 10, 1);
        add_action('rr_cookies_before_save_preferences', array($this, 'before_save_preferences'), 10, 1);
        add_action('rr_cookies_after_save_preferences', array($this, 'after_save_preferences'), 10, 1);
    }

    /**
     * Filter cookie consent types.
     *
     * @param array $types Default cookie types.
     * @return array
     */
    public function filter_consent_types($types) {
        return apply_filters('rr_cookies_consent_types', $types);
    }

    /**
     * Filter banner content.
     *
     * @param array $content Banner content.
     * @return array
     */
    public function filter_banner_content($content) {
        return apply_filters('rr_cookies_banner_content', $content);
    }

    /**
     * Action before saving preferences.
     *
     * @param array $preferences User preferences.
     */
    public function before_save_preferences($preferences) {
        do_action('rr_cookies_before_save_preferences', $preferences);
    }

    /**
     * Action after saving preferences.
     *
     * @param array $preferences User preferences.
     */
    public function after_save_preferences($preferences) {
        do_action('rr_cookies_after_save_preferences', $preferences);
    }
}
