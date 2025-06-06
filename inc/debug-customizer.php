<?php
/**
 * Debug Customizer Helper
 * 
 * This file helps debug customizer issues and provides fallback options
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Debug Customizer Status
 */
function affirmed_debug_customizer() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Add debug info to admin footer
    add_action('admin_footer', 'affirmed_show_debug_info');
}
add_action('admin_init', 'affirmed_debug_customizer');

/**
 * Show Debug Information
 */
function affirmed_show_debug_info() {
    if (!isset($_GET['page']) || $_GET['page'] !== 'themes.php') {
        return;
    }
    
    $kirki_status = class_exists('Kirki') ? 'Active' : 'Not Found';
    $theme_options = get_theme_mod('affirmed_theme_options', array());
    
    echo '<div style="background: #fff; border: 1px solid #ccc; padding: 15px; margin: 20px; border-radius: 5px;">';
    echo '<h3>Affirmed Theme Debug Info</h3>';
    echo '<p><strong>Kirki Status:</strong> ' . $kirki_status . '</p>';
    echo '<p><strong>Theme Options Count:</strong> ' . count($theme_options) . '</p>';
    
    if (class_exists('Kirki')) {
        echo '<p style="color: green;">✓ Kirki is loaded and ready</p>';
    } else {
        echo '<p style="color: red;">✗ Kirki is not available</p>';
    }
    
    echo '<p><a href="' . admin_url('customize.php') . '" class="button button-primary">Open Customizer</a></p>';
    echo '</div>';
}

/**
 * Force refresh customizer sections
 */
function affirmed_force_customizer_refresh() {
    if (is_customize_preview()) {
        // Force reload of customizer sections
        add_action('wp_footer', function() {
            echo '<script>
                if (typeof wp !== "undefined" && wp.customize) {
                    wp.customize.bind("ready", function() {
                        console.log("Affirmed Theme: Customizer ready");
                        console.log("Available sections:", Object.keys(wp.customize.section._value));
                    });
                }
            </script>';
        });
    }
}
add_action('init', 'affirmed_force_customizer_refresh');

/**
 * Admin notice for customizer issues
 */
function affirmed_customizer_admin_notice() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $screen = get_current_screen();
    if ($screen->id !== 'themes') {
        return;
    }
    
    if (!class_exists('Kirki')) {
        echo '<div class="notice notice-warning"><p>';
        echo '<strong>Affirmed Theme:</strong> Kirki Customizer Framework is required for full theme functionality. ';
        echo '<a href="' . admin_url('plugins.php?s=kirki') . '">Install Kirki Plugin</a>';
        echo '</p></div>';
        return;
    }
    
    // Check if customizer sections are working
    $test_option = get_theme_mod('affirmed_theme_options', array());
    if (empty($test_option)) {
        echo '<div class="notice notice-info"><p>';
        echo '<strong>Affirmed Theme:</strong> Ready to customize! ';
        echo '<a href="' . admin_url('customize.php') . '" class="button button-primary">Start Customizing</a>';
        echo '</p></div>';
    }
}
add_action('admin_notices', 'affirmed_customizer_admin_notice');