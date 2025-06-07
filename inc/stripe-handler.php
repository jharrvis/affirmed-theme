<?php
/**
 * Stripe Payment Handler for Affirmed Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initialize Stripe Configuration
 */
function affirmed_stripe_init() {
    if (!affirmed_get_option('enable_stripe_payments', false)) {
        return;
    }
    
    // Load Stripe library (you'll need to include Stripe PHP SDK)
    if (!class_exists('\Stripe\Stripe')) {
        // Note: You need to install Stripe PHP SDK via Composer or manually include it
        // For now, we'll use Stripe.js for frontend processing
        return;
    }
}
add_action('init', 'affirmed_stripe_init');

/**
 * Get active Stripe keys
 */
function affirmed_get_stripe_keys() {
    $mode = affirmed_get_option('stripe_mode', 'test');
    
    if ($mode === 'test') {
        return array(
            'publishable' => affirmed_get_option('stripe_test_publishable_key', ''),
            'secret' => affirmed_get_option('stripe_test_secret_key', '')
        );
    } else {
        return array(
            'publishable' => affirmed_get_option('stripe_live_publishable_key', ''),
            'secret' => affirmed_get_option('stripe_live_secret_key', '')
        );
    }
}

/**
 * Enqueue Stripe scripts
 */
function affirmed_enqueue_stripe_scripts() {
    if (!affirmed_get_option('enable_stripe_payments', false)) {
        return;
    }
    
    // Only load on pages with the order form
    if (is_page_template() || is_front_page() || is_home()) {
        // Stripe.js v3
        wp_enqueue_script('stripe-js', 'https://js.stripe.com/v3/', array(), null, true);
        
        // Custom Stripe handler
        wp_enqueue_script(
            'affirmed-stripe', 
            get_template_directory_uri() . '/js/stripe-handler.js', 
            array('jquery', 'stripe-js'), 
            '1.0.0', 
            true
        );
        
        $stripe_keys = affirmed_get_stripe_keys();
        $book_price = affirmed_get_option('book_price', '$19.99');
        $price_numeric = floatval(preg_replace('/[^0-9.]/', '', $book_price));
        
        // Localize script with Stripe data
        wp_localize_script('affirmed-stripe', 'affirmed_stripe', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('affirmed_stripe_nonce'),
            'publishable_key' => $stripe_keys['publishable'],
            'currency' => affirmed_get_option('stripe_currency', 'usd'),
            'book_title' => affirmed_get_option('book_title', 'Affirmed Book'),
            'book_price' => $price_numeric * 100, // Stripe uses cents
            'shipping_cost' => affirmed_get_option('stripe_shipping_required', true) ? 
                            affirmed_get_option('stripe_shipping_cost', 5.99) * 100 : 0,
            'shipping_required' => affirmed_get_option('stripe_shipping_required', true),
            'success_url' => affirmed_get_option('stripe_success_url', home_url('/thank-you')),
            'cancel_url' => affirmed_get_option('stripe_cancel_url', home_url()),
            'mode' => affirmed_get_option('stripe_mode', 'test')
        ));
    }
}
add_action('wp_enqueue_scripts', 'affirmed_enqueue_stripe_scripts');

/**
 * AJAX handler for creating Stripe checkout session
 */
function affirmed_create_stripe_checkout_session() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'affirmed_stripe_nonce')) {
        wp_die('Security check failed');
    }
    
    if (!affirmed_get_option('enable_stripe_payments', false)) {
        wp_send_json_error(array('message' => 'Stripe payments are not enabled'));
    }
    
    $stripe_keys = affirmed_get_stripe_keys();
    
    if (empty($stripe_keys['secret'])) {
        wp_send_json_error(array('message' => 'Stripe configuration is incomplete'));
    }
    
    // For basic implementation without Stripe PHP SDK
    // We'll create a simple checkout URL
    $book_price = affirmed_get_option('book_price', '$19.99');
    $price_numeric = floatval(preg_replace('/[^0-9.]/', '', $book_price));
    $shipping_cost = affirmed_get_option('stripe_shipping_required', true) ? 
                    affirmed_get_option('stripe_shipping_cost', 5.99) : 0;
    $total = ($price_numeric + $shipping_cost) * 100; // Convert to cents
    
    // In a real implementation, you would:
    // 1. Use Stripe PHP SDK to create a checkout session
    // 2. Return the session ID to redirect to Stripe Checkout
    
    // For now, return success with instructions
    wp_send_json_success(array(
        'message' => 'Ready for Stripe checkout',
        'total' => $total,
        'currency' => affirmed_get_option('stripe_currency', 'usd'),
        'requires_stripe_sdk' => true
    ));
}
add_action('wp_ajax_affirmed_create_stripe_session', 'affirmed_create_stripe_checkout_session');
add_action('wp_ajax_nopriv_affirmed_create_stripe_session', 'affirmed_create_stripe_checkout_session');

/**
 * Handle Stripe webhook (for order fulfillment)
 */
function affirmed_stripe_webhook_handler() {
    if (!isset($_GET['affirmed_stripe_webhook'])) {
        return;
    }
    
    // Verify webhook signature (requires Stripe PHP SDK)
    // Process the webhook event
    // Update order status, send confirmation email, etc.
    
    http_response_code(200);
    exit;
}
add_action('init', 'affirmed_stripe_webhook_handler');

/**
 * Add custom rewrite rule for webhook endpoint
 */
function affirmed_add_webhook_endpoint() {
    add_rewrite_rule(
        '^stripe-webhook/?$',
        'index.php?affirmed_stripe_webhook=1',
        'top'
    );
}
add_action('init', 'affirmed_add_webhook_endpoint');

/**
 * Add query var for webhook
 */
function affirmed_webhook_query_vars($vars) {
    $vars[] = 'affirmed_stripe_webhook';
    return $vars;
}
add_filter('query_vars', 'affirmed_webhook_query_vars');

/**
 * Create thank you page content
 */
function affirmed_thank_you_page_content($content) {
    if (is_page('thank-you') && isset($_GET['session_id'])) {
        ob_start();
        ?>
        <div style="text-align: center; padding: 40px 20px;">
            <div style="max-width: 600px; margin: 0 auto;">
                <i class="fas fa-check-circle" style="font-size: 64px; color: #10b981; margin-bottom: 20px; display: block;"></i>
                <h1 style="color: #1f2937; margin-bottom: 20px;">Thank You for Your Purchase!</h1>
                <p style="font-size: 18px; color: #6b7280; margin-bottom: 30px;">
                    Your order has been successfully processed. You will receive a confirmation email shortly with your order details and tracking information.
                </p>
                <div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <p style="margin: 0; color: #4b5563;">
                        <strong>Order Reference:</strong> <?php echo esc_html($_GET['session_id']); ?>
                    </p>
                </div>
                <p style="color: #6b7280;">
                    If you have any questions about your order, please contact us at:<br>
                    <a href="mailto:<?php echo esc_attr(affirmed_get_option('contact_email', 'cs@tonyraysmith.com')); ?>" style="color: #10b981;">
                        <?php echo esc_html(affirmed_get_option('contact_email', 'cs@tonyraysmith.com')); ?>
                    </a>
                </p>
                <a href="<?php echo home_url(); ?>" class="button" style="display: inline-block; margin-top: 20px; background: #10b981; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px;">
                    Return to Homepage
                </a>
            </div>
        </div>
        <?php
        $custom_content = ob_get_clean();
        return $custom_content;
    }
    return $content;
}
add_filter('the_content', 'affirmed_thank_you_page_content');