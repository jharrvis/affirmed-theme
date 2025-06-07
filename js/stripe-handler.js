/**
 * Stripe Payment Handler for Affirmed Theme
 */
(function ($) {
  "use strict";

  // Check if Stripe is configured
  if (
    typeof affirmed_stripe === "undefined" ||
    !affirmed_stripe.publishable_key
  ) {
    console.log("Stripe is not configured");
    return;
  }

  // Initialize Stripe
  const stripe = Stripe(affirmed_stripe.publishable_key);

  // Handle form submission
  $(document).ready(function () {
    // Replace the original form submission with Stripe checkout
    $("#affirmed-order-form").on("submit", function (e) {
      e.preventDefault();

      const $form = $(this);
      const $submitBtn = $form.find('button[type="submit"]');
      const originalBtnText = $submitBtn.html();

      // Validate form
      if (!validateOrderForm($form)) {
        return false;
      }

      // Show loading state
      $submitBtn
        .prop("disabled", true)
        .html('<i class="fas fa-spinner fa-spin"></i> Processing...');

      // Collect form data
      const formData = {
        name: $form.find('input[name="name"]').val(),
        email: $form.find('input[name="email"]').val(),
        phone: $form.find('input[name="phone"]').val(),
        address: $form.find('input[name="address"]').val(),
        city: $form.find('input[name="city"]').val(),
        state: $form.find('input[name="state"]').val(),
        zip: $form.find('input[name="zip"]').val(),
        country: $form.find('select[name="country"]').val(),
      };

      // Create Stripe Checkout session
      createStripeCheckout(formData, $submitBtn, originalBtnText);
    });

    // Add Stripe payment button option
    addStripePaymentButton();
  });

  // Validate order form
  function validateOrderForm($form) {
    let isValid = true;
    const requiredFields = [
      "name",
      "email",
      "phone",
      "address",
      "city",
      "state",
      "zip",
      "country",
    ];

    requiredFields.forEach(function (field) {
      const $field = $form.find(`[name="${field}"]`);
      const value = $field.val().trim();

      if (!value) {
        $field.addClass("error").css("border-color", "#ef4444");
        isValid = false;
      } else {
        $field.removeClass("error").css("border-color", "");
      }
    });

    // Validate email
    const email = $form.find('input[name="email"]').val();
    if (!isValidEmail(email)) {
      $form
        .find('input[name="email"]')
        .addClass("error")
        .css("border-color", "#ef4444");
      isValid = false;
    }

    if (!isValid) {
      showErrorMessage("Please fill in all required fields correctly.");
    }

    return isValid;
  }

  // Email validation
  function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }

  // Create Stripe Checkout session
  function createStripeCheckout(customerData, $submitBtn, originalBtnText) {
    // Calculate total
    const bookPrice = affirmed_stripe.book_price;
    const shippingCost = affirmed_stripe.shipping_cost;
    const total = bookPrice + shippingCost;

    // Create line items
    const lineItems = [
      {
        price_data: {
          currency: affirmed_stripe.currency,
          product_data: {
            name: affirmed_stripe.book_title,
            description: "Affirmed - Positive Affirmations Book",
          },
          unit_amount: bookPrice,
        },
        quantity: 1,
      },
    ];

    // Add shipping if required
    if (affirmed_stripe.shipping_required && shippingCost > 0) {
      lineItems.push({
        price_data: {
          currency: affirmed_stripe.currency,
          product_data: {
            name: "Shipping & Handling",
          },
          unit_amount: shippingCost,
        },
        quantity: 1,
      });
    }

    // For demonstration - in production, create session server-side
    $.ajax({
      url: affirmed_stripe.ajax_url,
      type: "POST",
      data: {
        action: "affirmed_create_stripe_session",
        nonce: affirmed_stripe.nonce,
        customer_data: customerData,
        line_items: lineItems,
      },
      success: function (response) {
        if (response.success) {
          // In production, you would redirect to Stripe Checkout
          // For now, show a demo message
          showStripeCheckoutDemo(customerData, total);
          $submitBtn.prop("disabled", false).html(originalBtnText);
        } else {
          showErrorMessage(
            response.data.message ||
              "Payment processing failed. Please try again."
          );
          $submitBtn.prop("disabled", false).html(originalBtnText);
        }
      },
      error: function () {
        showErrorMessage("An error occurred. Please try again later.");
        $submitBtn.prop("disabled", false).html(originalBtnText);
      },
    });
  }

  // Show Stripe Checkout demo (replace with actual Stripe redirect in production)
  function showStripeCheckoutDemo(customerData, total) {
    const totalFormatted = (total / 100).toFixed(2);
    const currency = affirmed_stripe.currency.toUpperCase();

    const demoHtml = `
            <div id="stripe-checkout-demo" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; display: flex; align-items: center; justify-content: center;">
                <div style="background: white; padding: 40px; border-radius: 8px; max-width: 500px; width: 90%; text-align: center;">
                    <h2 style="margin-bottom: 20px;">Stripe Checkout Demo</h2>
                    <p style="margin-bottom: 20px;">In production, you would be redirected to Stripe's secure checkout page.</p>
                    
                    <div style="background: #f3f4f6; padding: 20px; border-radius: 6px; margin-bottom: 20px; text-align: left;">
                        <h3 style="margin-bottom: 10px;">Order Summary:</h3>
                        <p><strong>Customer:</strong> ${customerData.name}</p>
                        <p><strong>Email:</strong> ${customerData.email}</p>
                        <p><strong>Total:</strong> ${currency} ${totalFormatted}</p>
                    </div>
                    
                    <div style="background: #fef3c7; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                        <p style="color: #92400e; margin: 0;">
                            <strong>Note:</strong> To enable real payments, please configure your Stripe API keys in the WordPress Customizer.
                        </p>
                    </div>
                    
                    <button onclick="document.getElementById('stripe-checkout-demo').remove();" style="background: #10b981; color: white; border: none; padding: 10px 30px; border-radius: 5px; cursor: pointer;">
                        Close Demo
                    </button>
                </div>
            </div>
        `;

    $("body").append(demoHtml);
  }

  // Add Stripe payment button
  function addStripePaymentButton() {
    // Find the submit button and add Stripe branding if enabled
    const $submitBtn = $('#affirmed-order-form button[type="submit"]');

    if ($submitBtn.length && affirmed_stripe.mode) {
      // Add secure payment badge
      const badgeHtml = `
                <div class="stripe-security-badge" style="text-align: center; margin-top: 15px;">
                    <img src="https://cdn.brandfolder.io/KGT2DTA4/at/8vbr8k4mr5xjwk4hxq4t9vs/Powered_by_Stripe_-_blurple.svg" 
                         alt="Powered by Stripe" 
                         style="height: 26px; opacity: 0.6;">
                    <p style="font-size: 12px; color: #6b7280; margin-top: 5px;">
                        <i class="fas fa-lock"></i> Secure payment powered by Stripe
                    </p>
                </div>
            `;

      $submitBtn.closest("form").append(badgeHtml);

      // Add test mode indicator
      if (affirmed_stripe.mode === "test") {
        const testModeHtml = `
                    <div class="stripe-test-mode" style="background: #fef3c7; padding: 10px; border-radius: 5px; margin-top: 10px;">
                        <p style="font-size: 12px; color: #92400e; margin: 0;">
                            <strong>TEST MODE:</strong> Use test card 4242 4242 4242 4242
                        </p>
                    </div>
                `;
        $submitBtn.closest("form").append(testModeHtml);
      }
    }
  }

  // Show error message
  function showErrorMessage(message) {
    const errorHtml = `
            <div class="stripe-error-message" style="background: #fee; color: #c33; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                <p style="margin: 0;"><i class="fas fa-exclamation-circle"></i> ${message}</p>
            </div>
        `;

    // Remove any existing error messages
    $(".stripe-error-message").remove();

    // Add new error message
    $("#affirmed-order-form").prepend(errorHtml);

    // Auto-remove after 5 seconds
    setTimeout(function () {
      $(".stripe-error-message").fadeOut(function () {
        $(this).remove();
      });
    }, 5000);
  }

  // Alternative: Direct Stripe Checkout integration
  window.createStripeCheckoutSession = function () {
    // This function can be called directly to create a Stripe session
    // Useful for custom buy buttons

    if (!affirmed_stripe.publishable_key) {
      alert(
        "Stripe is not configured. Please set up your API keys in the theme settings."
      );
      return;
    }

    // In production, make AJAX call to create session server-side
    // Then redirect to Stripe Checkout
    console.log("Creating Stripe Checkout session...");
  };
})(jQuery);
