<?php
/**
 * Public API for developers.
 *
 * @package RR_Cookies
 */

class RR_Cookies_API {
    /**
     * Get user cookie preferences.
     *
     * @return array|false
     */
    public static function get_user_preferences() {
        if (!isset($_COOKIE['rr_cookies_preferences'])) {
            return false;
        }

        $preferences = json_decode(stripslashes($_COOKIE['rr_cookies_preferences']), true);
        return is_array($preferences) ? $preferences : false;
    }

    /**
     * Check if a specific cookie type is allowed.
     *
     * @param string $type Cookie type to check.
     * @return bool
     */
    public static function is_cookie_allowed($type) {
        $preferences = self::get_user_preferences();
        
        if (!$preferences) {
            return $type === 'necessary';
        }

        return isset($preferences[$type]) && $preferences[$type];
    }

    /**
     * Get all registered cookie types.
     *
     * @return array
     */
    public static function get_cookie_types() {
        return apply_filters('rr_cookies_consent_types', array(
            'necessary' => array(
                'required' => true,
                'title' => __('Necessary', 'rr-cookies'),
                'description' => __('Essential cookies for the website to function properly.', 'rr-cookies'),
            ),
            'analytics' => array(
                'required' => false,
                'title' => __('Analytics', 'rr-cookies'),
                'description' => __('Cookies that help us understand how visitors interact with the website.', 'rr-cookies'),
            ),
            'marketing' => array(
                'required' => false,
                'title' => __('Marketing', 'rr-cookies'),
                'description' => __('Cookies used for targeted advertising.', 'rr-cookies'),
            ),
        ));
    }

    /**
     * Force cookie consent banner to show again.
     */
    public static function reset_consent() {
        if (isset($_COOKIE['rr_cookies_preferences'])) {
            setcookie('rr_cookies_preferences', '', time() - 3600, '/');
        }
    }

    /**
     * Get cookie banner status.
     *
     * @return string
     */
    public static function get_banner_status() {
        if (!isset($_COOKIE['rr_cookies_preferences'])) {
            return 'not_shown';
        }
        return 'accepted';
    }
}
