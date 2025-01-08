<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package RR_Cookies
 */

class RR_Cookies_Admin {
    /**
     * Initialize the class and set its properties.
     */
    public function __construct() {
        $this->plugin_name = 'rr-cookies';
        $this->version = RR_COOKIES_VERSION;
    }

    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_styles() {
        wp_enqueue_style(
            $this->plugin_name,
            RR_COOKIES_PLUGIN_URL . 'admin/css/rr-cookies-admin.css',
            array(),
            $this->version,
            'all'
        );
        wp_enqueue_style('wp-color-picker');
    }

    /**
     * Register the JavaScript for the admin area.
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            RR_COOKIES_PLUGIN_URL . 'admin/js/rr-cookies-admin.js',
            array('jquery', 'wp-color-picker'),
            $this->version,
            false
        );
    }

    /**
     * Add plugin admin menu.
     */
    public function add_plugin_admin_menu() {
        add_menu_page(
            __('RR Cookies Settings', 'rr-cookies'),
            __('RR Cookies', 'rr-cookies'),
            'manage_options',
            'rr-cookies',
            array($this, 'display_plugin_setup_page'),
            'dashicons-privacy',
            85
        );

        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Register all settings sections and fields.
     */
    public function register_settings() {
        register_setting('rr_cookies_settings', 'rr_cookies_settings', array($this, 'validate_settings'));
        register_setting('rr_cookies_appearance', 'rr_cookies_appearance', array($this, 'validate_appearance'));
        register_setting('rr_cookies_content', 'rr_cookies_content', array($this, 'validate_content'));
        register_setting('rr_cookies_advanced', 'rr_cookies_advanced', array($this, 'validate_advanced'));

        // General Settings Section
        add_settings_section(
            'rr_cookies_general_section',
            __('General Settings', 'rr-cookies'),
            array($this, 'general_section_callback'),
            'rr_cookies_settings'
        );

        // Appearance Settings Section
        add_settings_section(
            'rr_cookies_appearance_section',
            __('Appearance Settings', 'rr-cookies'),
            array($this, 'appearance_section_callback'),
            'rr_cookies_appearance'
        );

        // Content Settings Section
        add_settings_section(
            'rr_cookies_content_section',
            __('Content Settings', 'rr-cookies'),
            array($this, 'content_section_callback'),
            'rr_cookies_content'
        );

        // Advanced Settings Section
        add_settings_section(
            'rr_cookies_advanced_section',
            __('Advanced Settings', 'rr-cookies'),
            array($this, 'advanced_section_callback'),
            'rr_cookies_advanced'
        );

        // Register settings fields
        $this->register_general_settings_fields();
        $this->register_appearance_settings_fields();
        $this->register_content_settings_fields();
        $this->register_advanced_settings_fields();
    }

    /**
     * Register general settings fields.
     */
    private function register_general_settings_fields() {
        add_settings_field(
            'cookie_duration',
            __('Cookie Duration (days)', 'rr-cookies'),
            array($this, 'cookie_duration_callback'),
            'rr_cookies_settings',
            'rr_cookies_general_section',
            array(
                'label_for' => 'cookie_duration',
                'description' => __('Set how long the cookie consent should be remembered (1-365 days).', 'rr-cookies')
            )
        );

        add_settings_field(
            'privacy_policy_link',
            __('Privacy Policy Link', 'rr-cookies'),
            array($this, 'privacy_policy_link_callback'),
            'rr_cookies_settings',
            'rr_cookies_general_section',
            array(
                'label_for' => 'privacy_policy_link',
                'description' => __('Enter the URL of your privacy policy page.', 'rr-cookies')
            )
        );
    }

    /**
     * Register appearance settings fields.
     */
    private function register_appearance_settings_fields() {
        $appearance_fields = array(
            'theme' => array(
                'title' => __('Theme', 'rr-cookies'),
                'callback' => 'theme_callback',
                'description' => __('Choose between light and dark theme.', 'rr-cookies')
            ),
            'banner_position' => array(
                'title' => __('Banner Position', 'rr-cookies'),
                'callback' => 'banner_position_callback',
                'description' => __('Select where the banner should appear.', 'rr-cookies')
            ),
            'animation_type' => array(
                'title' => __('Animation Type', 'rr-cookies'),
                'callback' => 'animation_type_callback',
                'description' => __('Choose how the banner should appear.', 'rr-cookies')
            ),
            'banner_background_color' => array(
                'title' => __('Banner Background Color', 'rr-cookies'),
                'callback' => 'banner_background_color_callback',
                'description' => __('Select banner background color.', 'rr-cookies')
            ),
            'text_color' => array(
                'title' => __('Text Color', 'rr-cookies'),
                'callback' => 'text_color_callback',
                'description' => __('Select text color.', 'rr-cookies')
            ),
            'button_color' => array(
                'title' => __('Button Color', 'rr-cookies'),
                'callback' => 'button_color_callback',
                'description' => __('Select button color.', 'rr-cookies')
            ),
            'button_text_color' => array(
                'title' => __('Button Text Color', 'rr-cookies'),
                'callback' => 'button_text_color_callback',
                'description' => __('Select button text color.', 'rr-cookies')
            )
        );

        foreach ($appearance_fields as $field_id => $field) {
            add_settings_field(
                $field_id,
                $field['title'],
                array($this, $field['callback']),
                'rr_cookies_appearance',
                'rr_cookies_appearance_section',
                array(
                    'label_for' => $field_id,
                    'description' => $field['description']
                )
            );
        }
    }

    /**
     * Display the admin settings page.
     */
    public function display_plugin_setup_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <h2 class="nav-tab-wrapper">
                <a href="?page=rr-cookies&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">
                    <?php _e('General', 'rr-cookies'); ?>
                </a>
                <a href="?page=rr-cookies&tab=appearance" class="nav-tab <?php echo $active_tab == 'appearance' ? 'nav-tab-active' : ''; ?>">
                    <?php _e('Appearance', 'rr-cookies'); ?>
                </a>
                <a href="?page=rr-cookies&tab=content" class="nav-tab <?php echo $active_tab == 'content' ? 'nav-tab-active' : ''; ?>">
                    <?php _e('Content', 'rr-cookies'); ?>
                </a>
                <a href="?page=rr-cookies&tab=advanced" class="nav-tab <?php echo $active_tab == 'advanced' ? 'nav-tab-active' : ''; ?>">
                    <?php _e('Advanced', 'rr-cookies'); ?>
                </a>
            </h2>

            <form method="post" action="options.php">
                <?php
                switch ($active_tab) {
                    case 'appearance':
                        settings_fields('rr_cookies_appearance');
                        do_settings_sections('rr_cookies_appearance');
                        break;
                    case 'content':
                        settings_fields('rr_cookies_content');
                        do_settings_sections('rr_cookies_content');
                        break;
                    case 'advanced':
                        settings_fields('rr_cookies_advanced');
                        do_settings_sections('rr_cookies_advanced');
                        break;
                    default:
                        settings_fields('rr_cookies_settings');
                        do_settings_sections('rr_cookies_settings');
                        break;
                }
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    // Field callbacks
    public function cookie_duration_callback($args) {
        $options = get_option('rr_cookies_settings');
        $value = isset($options['cookie_duration']) ? $options['cookie_duration'] : 365;
        ?>
        <input type="number" 
               id="<?php echo esc_attr($args['label_for']); ?>"
               name="rr_cookies_settings[cookie_duration]"
               min="1"
               max="365"
               value="<?php echo esc_attr($value); ?>">
        <p class="description"><?php echo esc_html($args['description']); ?></p>
        <?php
    }

    public function theme_callback($args) {
        $options = get_option('rr_cookies_appearance');
        $value = isset($options['theme']) ? $options['theme'] : 'light';
        ?>
        <select id="<?php echo esc_attr($args['label_for']); ?>"
                name="rr_cookies_appearance[theme]">
            <option value="light" <?php selected($value, 'light'); ?>><?php _e('Light', 'rr-cookies'); ?></option>
            <option value="dark" <?php selected($value, 'dark'); ?>><?php _e('Dark', 'rr-cookies'); ?></option>
        </select>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
        <?php
    }

    // Validation callbacks
    public function validate_settings($input) {
        $output = array();
        
        if (isset($input['cookie_duration'])) {
            $output['cookie_duration'] = min(max(intval($input['cookie_duration']), 1), 365);
        }

        return $output;
    }

    public function validate_appearance($input) {
        $output = array();
        
        if (isset($input['theme'])) {
            $output['theme'] = sanitize_text_field($input['theme']);
        }

        return $output;
    }
}
