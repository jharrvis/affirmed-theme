<?php
/**
 * Simple Stripe Payment Handler for Affirmed Theme
 * No PHP SDK Required - Uses Stripe Checkout (Hosted)
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
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
            'affirmed-stripe-simple', 
            get_template_directory_uri() . '/js/stripe-simple.js', 
            array('jquery', 'stripe-js'), 
            '1.0.0', 
            true
        );
        
        $stripe_keys = affirmed_get_stripe_keys();
        $book_price = affirmed_get_option('book_price', '$19.99');
        $price_numeric = floatval(preg_replace('/[^0-9.]/', '', $book_price));
        
        // Localize script with Stripe data
        wp_localize_script('affirmed-stripe-simple', 'affirmed_stripe', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('affirmed_stripe_nonce'),
            'publishable_key' => $stripe_keys['publishable'],
            'currency' => affirmed_get_option('stripe_currency', 'usd'),
            'book_title' => affirmed_get_option('book_title', 'Affirmed Book'),
            'book_price' => $price_numeric,
            'shipping_cost' => affirmed_get_option('stripe_shipping_required', true) ? 
                            affirmed_get_option('stripe_shipping_cost', 5.99) : 0,
            'shipping_required' => affirmed_get_option('stripe_shipping_required', true),
            'success_url' => affirmed_get_option('stripe_success_url', home_url('/thank-you')),
            'cancel_url' => affirmed_get_option('stripe_cancel_url', home_url()),
            'mode' => affirmed_get_option('stripe_mode', 'test')
        ));
    }
}
add_action('wp_enqueue_scripts', 'affirmed_enqueue_stripe_scripts');

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
 * AJAX handler for creating payment link
 * This method doesn't require Stripe PHP SDK
 */
function affirmed_create_stripe_payment_link() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'affirmed_stripe_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed'));
    }
    
    if (!affirmed_get_option('enable_stripe_payments', false)) {
        wp_send_json_error(array('message' => 'Stripe payments are not enabled'));
    }
    
    $stripe_keys = affirmed_get_stripe_keys();
    
    if (empty($stripe_keys['secret'])) {
        wp_send_json_error(array('message' => 'Stripe configuration is incomplete'));
    }
    
    // Get form data
    $customer_data = array(
        'name' => sanitize_text_field($_POST['customer_data']['name']),
        'email' => sanitize_email($_POST['customer_data']['email']),
        'phone' => sanitize_text_field($_POST['customer_data']['phone']),
        'address' => sanitize_text_field($_POST['customer_data']['address']),
        'city' => sanitize_text_field($_POST['customer_data']['city']),
        'state' => sanitize_text_field($_POST['customer_data']['state']),
        'zip' => sanitize_text_field($_POST['customer_data']['zip']),
        'country' => sanitize_text_field($_POST['customer_data']['country'])
    );
    
    // Store customer data in session for later use
    if (!session_id()) {
        session_start();
    }
    $_SESSION['affirmed_customer_data'] = $customer_data;
    
    // Calculate prices
    $book_price = affirmed_get_option('book_price', '$19.99');
    $price_numeric = floatval(preg_replace('/[^0-9.]/', '', $book_price));
    $shipping_cost = affirmed_get_option('stripe_shipping_required', true) ? 
                    affirmed_get_option('stripe_shipping_cost', 5.99) : 0;
    
    // Create a simple checkout URL using Stripe's Payment Links
    // Note: In production, you should create these payment links in Stripe Dashboard
    // and store the URLs in theme options
    
    // For now, return data for client-side Stripe Checkout
    wp_send_json_success(array(
        'customer_email' => $customer_data['email'],
        'amount' => ($price_numeric + $shipping_cost) * 100, // Convert to cents
        'currency' => affirmed_get_option('stripe_currency', 'usd')
    ));
}
add_action('wp_ajax_affirmed_create_payment_link', 'affirmed_create_stripe_payment_link');
add_action('wp_ajax_nopriv_affirmed_create_payment_link', 'affirmed_create_stripe_payment_link');

/**
 * Handle successful payment return
 */
function affirmed_handle_payment_success() {
    if (is_page('thank-you') && isset($_GET['payment_intent'])) {
        // Payment was successful
        // You can verify the payment_intent with Stripe API if needed
        
        // Get customer data from session
        if (!session_id()) {
            session_start();
        }
        
        $customer_data = isset($_SESSION['affirmed_customer_data']) ? $_SESSION['affirmed_customer_data'] : null;
        
        if ($customer_data) {
            // Send confirmation email
            affirmed_send_order_confirmation($customer_data);
            
            // Clear session
            unset($_SESSION['affirmed_customer_data']);
        }
    }
}
add_action('wp', 'affirmed_handle_payment_success');

/**
 * Send order confirmation email
 */
function affirmed_send_order_confirmation($customer_data) {
    $to = $customer_data['email'];
    $subject = 'Order Confirmation - Affirmed Book';
    
    $message = "Thank you for your order!\n\n";
    $message .= "Order Details:\n";
    $message .= "Product: Affirmed - Positive Affirmations Book\n";
    $message .= "Price: " . affirmed_get_option('book_price', '$19.99') . "\n";
    
    if (affirmed_get_option('stripe_shipping_required', true)) {
        $message .= "Shipping: $" . affirmed_get_option('stripe_shipping_cost', 5.99) . "\n\n";
        $message .= "Shipping Address:\n";
        $message .= $customer_data['name'] . "\n";
        $message .= $customer_data['address'] . "\n";
        $message .= $customer_data['city'] . ", " . $customer_data['state'] . " " . $customer_data['zip'] . "\n";
        $message .= $customer_data['country'] . "\n";
    }
    
    $message .= "\nWe'll process your order within 1-2 business days.\n";
    $message .= "\nIf you have any questions, please contact us at " . affirmed_get_option('contact_email', 'cs@tonyraysmith.com');
    
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    wp_mail($to, $subject, $message, $headers);
}

/**
 * Add Stripe payment button to order form
 */
function affirmed_add_stripe_button() {
    if (!affirmed_get_option('enable_stripe_payments', false)) {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Change form button text
        $('#affirmed-order-form button[type="submit"]').html('<i class="fas fa-lock"></i> Secure Checkout');
    });
    </script>
    <?php
}
add_action('wp_footer', 'affirmed_add_stripe_button');

/**
 * Create thank you page content
 */
function affirmed_thank_you_page_content($content) {
    if (is_page('thank-you')) {
        ob_start();
        ?>
        <div style="text-align: center; padding: 40px 20px;">
            <div style="max-width: 600px; margin: 0 auto;">
                <i class="fas fa-check-circle" style="font-size: 64px; color: #10b981; margin-bottom: 20px; display: block;"></i>
                <h1 style="color: #1f2937; margin-bottom: 20px;">Thank You for Your Purchase!</h1>
                <p style="font-size: 18px; color: #6b7280; margin-bottom: 30px;">
                    Your order has been successfully processed. You will receive a confirmation email shortly with your order details.
                </p>
                
                <?php if (isset($_GET['payment_intent'])) : ?>
                <div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <p style="margin: 0; color: #4b5563;">
                        <strong>Payment Reference:</strong> <?php echo esc_html(substr($_GET['payment_intent'], 0, 20)); ?>...
                    </p>
                </div>
                <?php endif; ?>
                
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <h3 style="color: #166534; margin-bottom: 10px;">What's Next?</h3>
                    <ul style="text-align: left; color: #166534; margin: 0;">
                        <li>Check your email for order confirmation</li>
                        <li>Your book will be shipped within 1-2 business days</li>
                        <li>You'll receive tracking information once shipped</li>
                    </ul>
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