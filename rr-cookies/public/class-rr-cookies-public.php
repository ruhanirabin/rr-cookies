<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package RR_Cookies
 */

class RR_Cookies_Public {
    /**
     * Initialize the class and set its properties.
     */
    public function __construct() {
        $this->plugin_name = 'rr-cookies';
        $this->version = RR_COOKIES_VERSION;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            RR_COOKIES_PLUGIN_URL . 'public/css/rr-cookies-public.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            RR_COOKIES_PLUGIN_URL . 'public/js/rr-cookies-public.js',
            array('jquery'),
            $this->version,
            true
        );

        wp_localize_script(
            $this->plugin_name,
            'rrCookiesParams',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('rr_cookies_nonce'),
                'cookieDuration' => $this->get_cookie_duration(),
                'texts' => $this->get_localized_texts(),
                'settings' => $this->get_frontend_settings()
            )
        );
    }

    /**
     * Get cookie duration setting.
     */
    private function get_cookie_duration() {
        $settings = get_option('rr_cookies_settings');
        return isset($settings['cookie_duration']) ? (int) $settings['cookie_duration'] : 365;
    }

    /**
     * Get localized texts for frontend.
     */
    private function get_localized_texts() {
        $content_settings = get_option('rr_cookies_content');
        
        return array(
            'mainText' => isset($content_settings['main_text']) 
                ? wp_kses_post($content_settings['main_text']) 
                : __('We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.', 'rr-cookies'),
            'acceptAll' => isset($content_settings['accept_all_text']) 
                ? esc_html($content_settings['accept_all_text']) 
                : __('Accept All', 'rr-cookies'),
            'preferences' => isset($content_settings['preferences_text']) 
                ? esc_html($content_settings['preferences_text']) 
                : __('Cookie Settings', 'rr-cookies'),
            'save' => isset($content_settings['save_text']) 
                ? esc_html($content_settings['save_text']) 
                : __('Save Preferences', 'rr-cookies'),
            'necessary' => __('Necessary', 'rr-cookies'),
            'analytics' => __('Analytics', 'rr-cookies'),
            'marketing' => __('Marketing', 'rr-cookies'),
            'necessaryDescription' => __('Necessary cookies are essential for the website to function properly.', 'rr-cookies'),
            'analyticsDescription' => __('Analytics cookies help us understand how visitors interact with the website.', 'rr-cookies'),
            'marketingDescription' => __('Marketing cookies are used to track visitors across websites to display relevant advertisements.', 'rr-cookies')
        );
    }

    /**
     * Get frontend settings.
     */
    private function get_frontend_settings() {
        $appearance = get_option('rr_cookies_appearance');
        $advanced = get_option('rr_cookies_advanced');
        
        return array(
            'theme' => isset($appearance['theme']) ? esc_attr($appearance['theme']) : 'light',
            'position' => isset($appearance['banner_position']) ? esc_attr($appearance['banner_position']) : 'bottom',
            'animation' => isset($appearance['animation_type']) ? esc_attr($appearance['animation_type']) : 'slide',
            'colors' => array(
                'banner' => isset($appearance['banner_background_color']) ? esc_attr($appearance['banner_background_color']) : '#ffffff',
                'text' => isset($appearance['text_color']) ? esc_attr($appearance['text_color']) : '#000000',
                'button' => isset($appearance['button_color']) ? esc_attr($appearance['button_color']) : '#0073aa',
                'buttonText' => isset($appearance['button_text_color']) ? esc_attr($appearance['button_text_color']) : '#ffffff'
            ),
            'privacyPolicy' => get_privacy_policy_url()
        );
    }

    /**
     * Display cookie consent banner.
     */
    public function display_cookie_banner() {
        if ($this->should_display_banner()) {
            include_once RR_COOKIES_PLUGIN_DIR . 'public/partials/cookie-banner.php';
            include_once RR_COOKIES_PLUGIN_DIR . 'public/partials/cookie-preferences.php';
        }
    }

    /**
     * Check if banner should be displayed.
     */
    private function should_display_banner() {
        if (is_admin()) {
            return false;
        }

        if (isset($_COOKIE['rr_cookies_preferences'])) {
            return false;
        }

        return true;
    }

    /**
     * AJAX handler for saving cookie preferences.
     */
    public function save_cookie_preferences() {
        check_ajax_referer('rr_cookies_nonce', 'nonce');

        $preferences = array(
            'necessary' => true, // Always true
            'analytics' => isset($_POST['analytics']) && $_POST['analytics'] === 'true',
            'marketing' => isset($_POST['marketing']) && $_POST['marketing'] === 'true'
        );

        $response = array(
            'success' => true,
            'preferences' => $preferences
        );

        wp_send_json($response);
    }
}
