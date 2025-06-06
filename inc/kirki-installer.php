<?php
/**
 * Kirki Plugin Installer and Manager
 * 
 * Handles Kirki plugin detection, installation recommendations, and fallbacks
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Affirmed_Kirki_Installer {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_init', array($this, 'check_kirki_plugin'));
        add_action('admin_notices', array($this, 'kirki_admin_notice'));
        add_action('wp_ajax_install_kirki_plugin', array($this, 'install_kirki_plugin'));
        add_action('wp_ajax_dismiss_kirki_notice', array($this, 'dismiss_kirki_notice'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        
        // Add theme support check
        add_action('after_setup_theme', array($this, 'check_theme_requirements'));
    }
    
    /**
     * Check if Kirki plugin is installed and activated
     */
    public function check_kirki_plugin() {
        if (!$this->is_kirki_installed()) {
            // Kirki is not installed
            set_transient('affirmed_kirki_notice', 'not_installed', 0);
        } elseif (!$this->is_kirki_active()) {
            // Kirki is installed but not activated
            set_transient('affirmed_kirki_notice', 'not_activated', 0);
        } else {
            // Kirki is installed and activated
            delete_transient('affirmed_kirki_notice');
        }
    }
    
    /**
     * Check if Kirki is installed
     */
    public function is_kirki_installed() {
        $installed_plugins = get_plugins();
        return isset($installed_plugins['kirki/kirki.php']);
    }
    
    /**
     * Check if Kirki is active
     */
    public function is_kirki_active() {
        return is_plugin_active('kirki/kirki.php');
    }
    
    /**
     * Display admin notice for Kirki plugin
     */
    public function kirki_admin_notice() {
        // Don't show notice if user doesn't have permission
        if (!current_user_can('install_plugins')) {
            return;
        }
        
        // Don't show if notice was dismissed
        if (get_option('affirmed_kirki_notice_dismissed')) {
            return;
        }
        
        $notice_type = get_transient('affirmed_kirki_notice');
        
        if (!$notice_type) {
            return;
        }
        
        $class = 'notice notice-warning is-dismissible affirmed-kirki-notice';
        $plugin_name = '<strong>Kirki Customizer Framework</strong>';
        $theme_name = '<strong>Affirmed Theme</strong>';
        
        switch ($notice_type) {
            case 'not_installed':
                $message = sprintf(
                    __('%1$s requires the %2$s plugin to unlock all customization features. Click the button below to install it automatically.', 'affirmed-theme'),
                    $theme_name,
                    $plugin_name
                );
                $button = $this->get_install_button();
                break;
                
            case 'not_activated':
                $message = sprintf(
                    __('%1$s requires the %2$s plugin to be activated. Click the button below to activate it.', 'affirmed-theme'),
                    $theme_name,
                    $plugin_name
                );
                $button = $this->get_activate_button();
                break;
                
            default:
                return;
        }
        
        printf(
            '<div class="%1$s" data-notice="kirki-installer">
                <div style="display: flex; align-items: center; gap: 15px; padding: 5px 0;">
                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 10px 0; color: #d63638;">
                            <span class="dashicons dashicons-admin-plugins" style="font-size: 20px; margin-right: 8px;"></span>
                            %2$s
                        </h3>
                        <p style="margin: 0; font-size: 14px;">%3$s</p>
                        <p style="margin: 10px 0 0 0; font-size: 13px; color: #666;">
                            <strong>Note:</strong> The theme will work without Kirki, but you\'ll have limited customization options.
                        </p>
                    </div>
                    <div>%4$s</div>
                </div>
            </div>',
            esc_attr($class),
            esc_html__('Plugin Required for Full Functionality', 'affirmed-theme'),
            $message,
            $button
        );
    }
    
    /**
     * Get install button HTML
     */
    private function get_install_button() {
        $install_url = wp_nonce_url(
            add_query_arg(
                array(
                    'action' => 'install-plugin',
                    'plugin' => 'kirki'
                ),
                admin_url('update.php')
            ),
            'install-plugin_kirki'
        );
        
        return sprintf(
            '<a href="%1$s" class="button button-primary" style="margin-right: 10px;">
                <span class="dashicons dashicons-download" style="margin-right: 5px; margin-top: 3px;"></span>
                %2$s
            </a>
            <button type="button" class="button button-secondary dismiss-kirki-notice">
                %3$s
            </button>',
            esc_url($install_url),
            esc_html__('Install Kirki Plugin', 'affirmed-theme'),
            esc_html__('Maybe Later', 'affirmed-theme')
        );
    }
    
    /**
     * Get activate button HTML
     */
    private function get_activate_button() {
        $activate_url = wp_nonce_url(
            add_query_arg(
                array(
                    'action' => 'activate',
                    'plugin' => 'kirki/kirki.php'
                ),
                admin_url('plugins.php')
            ),
            'activate-plugin_kirki/kirki.php'
        );
        
        return sprintf(
            '<a href="%1$s" class="button button-primary" style="margin-right: 10px;">
                <span class="dashicons dashicons-admin-plugins" style="margin-right: 5px; margin-top: 3px;"></span>
                %2$s
            </a>
            <button type="button" class="button button-secondary dismiss-kirki-notice">
                %3$s
            </button>',
            esc_url($activate_url),
            esc_html__('Activate Kirki Plugin', 'affirmed-theme'),
            esc_html__('Maybe Later', 'affirmed-theme')
        );
    }
    
    /**
     * Install Kirki plugin via AJAX
     */
    public function install_kirki_plugin() {
        check_ajax_referer('affirmed_kirki_nonce', 'nonce');
        
        if (!current_user_can('install_plugins')) {
            wp_die(esc_html__('You do not have permission to install plugins.', 'affirmed-theme'));
        }
        
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        
        $plugin_slug = 'kirki';
        $plugin_info = plugins_api('plugin_information', array('slug' => $plugin_slug));
        
        if (is_wp_error($plugin_info)) {
            wp_send_json_error(array('message' => $plugin_info->get_error_message()));
        }
        
        $upgrader = new Plugin_Upgrader();
        $result = $upgrader->install($plugin_info->download_link);
        
        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        }
        
        // Activate the plugin
        $plugin_file = 'kirki/kirki.php';
        $activate_result = activate_plugin($plugin_file);
        
        if (is_wp_error($activate_result)) {
            wp_send_json_error(array('message' => $activate_result->get_error_message()));
        }
        
        wp_send_json_success(array('message' => esc_html__('Kirki plugin installed and activated successfully!', 'affirmed-theme')));
    }
    
    /**
     * Dismiss Kirki notice
     */
    public function dismiss_kirki_notice() {
        check_ajax_referer('affirmed_kirki_nonce', 'nonce');
        
        update_option('affirmed_kirki_notice_dismissed', true);
        delete_transient('affirmed_kirki_notice');
        
        wp_send_json_success();
    }
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'themes.php') !== false || strpos($hook, 'customize.php') !== false) {
            wp_enqueue_script(
                'affirmed-kirki-installer',
                get_template_directory_uri() . '/js/kirki-installer.js',
                array('jquery'),
                '1.0.0',
                true
            );
            
            wp_localize_script('affirmed-kirki-installer', 'affirmedKirki', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('affirmed_kirki_nonce'),
                'installing_text' => esc_html__('Installing...', 'affirmed-theme'),
                'activating_text' => esc_html__('Activating...', 'affirmed-theme'),
                'success_text' => esc_html__('Success! Refreshing page...', 'affirmed-theme'),
                'error_text' => esc_html__('Error occurred. Please try manually.', 'affirmed-theme'),
            ));
        }
    }
    
    /**
     * Check theme requirements and setup fallbacks
     */
    public function check_theme_requirements() {
        // If Kirki is not available, setup basic customizer fallbacks
        if (!class_exists('Kirki')) {
            add_action('customize_register', array($this, 'setup_basic_customizer'));
        }
    }
    
    /**
     * Setup basic customizer options when Kirki is not available
     */
    public function setup_basic_customizer($wp_customize) {
        // Add basic sections and controls for essential theme options
        
        // Hero Section
        $wp_customize->add_section('affirmed_hero', array(
            'title' => esc_html__('Hero Section', 'affirmed-theme'),
            'priority' => 30,
        ));
        
        $wp_customize->add_setting('hero_title', array(
            'default' => 'Change Your Mindset, Improve Your Life, Thrive',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage',
        ));
        
        $wp_customize->add_control('hero_title', array(
            'label' => esc_html__('Hero Title', 'affirmed-theme'),
            'section' => 'affirmed_hero',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting('hero_subtitle', array(
            'default' => 'Affirmed: Your Beginning Point Towards a Life Path Full of Positivity & Strength',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport' => 'postMessage',
        ));
        
        $wp_customize->add_control('hero_subtitle', array(
            'label' => esc_html__('Hero Subtitle', 'affirmed-theme'),
            'section' => 'affirmed_hero',
            'type' => 'textarea',
        ));
        
        // Book Section
        $wp_customize->add_section('affirmed_book', array(
            'title' => esc_html__('Book Section', 'affirmed-theme'),
            'priority' => 40,
        ));
        
        $wp_customize->add_setting('book_title', array(
            'default' => 'Discover The Transformative Power of Words',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage',
        ));
        
        $wp_customize->add_control('book_title', array(
            'label' => esc_html__('Book Title', 'affirmed-theme'),
            'section' => 'affirmed_book',
            'type' => 'text',
        ));
        
        // Contact Section
        $wp_customize->add_section('affirmed_contact', array(
            'title' => esc_html__('Contact Information', 'affirmed-theme'),
            'priority' => 50,
        ));
        
        $wp_customize->add_setting('contact_phone', array(
            'default' => '703.957.0529',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage',
        ));
        
        $wp_customize->add_control('contact_phone', array(
            'label' => esc_html__('Phone Number', 'affirmed-theme'),
            'section' => 'affirmed_contact',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting('contact_email', array(
            'default' => 'cs@tonyraysmith.com',
            'sanitize_callback' => 'sanitize_email',
            'transport' => 'postMessage',
        ));
        
        $wp_customize->add_control('contact_email', array(
            'label' => esc_html__('Email Address', 'affirmed-theme'),
            'section' => 'affirmed_contact',
            'type' => 'email',
        ));
        
        // Add live preview JavaScript
        if ($wp_customize->is_preview()) {
            add_action('wp_footer', array($this, 'customizer_live_preview'));
        }
    }
    
    /**
     * Add live preview JavaScript for basic customizer
     */
    public function customizer_live_preview() {
        ?>
        <script type="text/javascript">
        (function($) {
            // Hero title
            wp.customize('hero_title', function(value) {
                value.bind(function(newval) {
                    $('.hero-title .highlight').text(newval);
                });
            });
            
            // Hero subtitle  
            wp.customize('hero_subtitle', function(value) {
                value.bind(function(newval) {
                    $('.hero-subtitle').text(newval);
                });
            });
            
            // Book title
            wp.customize('book_title', function(value) {
                value.bind(function(newval) {
                    $('.book-title').text(newval);
                });
            });
            
            // Contact phone
            wp.customize('contact_phone', function(value) {
                value.bind(function(newval) {
                    $('.contact-phone').text(newval);
                });
            });
            
            // Contact email
            wp.customize('contact_email', function(value) {
                value.bind(function(newval) {
                    $('.contact-email').text(newval);
                });
            });
        })(jQuery);
        </script>
        <?php
    }
    
    /**
     * Get theme status information
     */
    public function get_theme_status() {
        return array(
            'kirki_installed' => $this->is_kirki_installed(),
            'kirki_active' => $this->is_kirki_active(),
            'customizer_ready' => class_exists('Kirki'),
            'notice_dismissed' => get_option('affirmed_kirki_notice_dismissed', false),
        );
    }
    
    /**
     * Reset all notices (useful for debugging)
     */
    public function reset_notices() {
        delete_option('affirmed_kirki_notice_dismissed');
        delete_transient('affirmed_kirki_notice');
    }
}

// Initialize the Kirki installer
new Affirmed_Kirki_Installer();

/**
 * Helper function to check if Kirki is available
 */
function affirmed_has_kirki() {
    return class_exists('Kirki');
}

/**
 * Helper function to get Kirki status
 */
function affirmed_kirki_status() {
    $installer = new Affirmed_Kirki_Installer();
    return $installer->get_theme_status();
}