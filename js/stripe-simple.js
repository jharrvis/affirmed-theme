/**
 * Simple Stripe Payment Handler - No PHP SDK Required
 * Uses Stripe Checkout (Hosted Solution)
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

      // Save customer data first
      $.ajax({
        url: affirmed_stripe.ajax_url,
        type: "POST",
        data: {
          action: "affirmed_create_payment_link",
          nonce: affirmed_stripe.nonce,
          customer_data: formData,
        },
        success: function (response) {
          if (response.success) {
            // Redirect to Stripe Checkout
            redirectToStripeCheckout(formData.email, response.data);
          } else {
            showErrorMessage(
              response.data.message || "Payment processing failed."
            );
            $submitBtn.prop("disabled", false).html(originalBtnText);
          }
        },
        error: function () {
          showErrorMessage("Connection error. Please try again.");
          $submitBtn.prop("disabled", false).html(originalBtnText);
        },
      });
    });

    // Add Stripe branding
    addStripeBranding();
  });

  // Redirect to Stripe Checkout
  function redirectToStripeCheckout(customerEmail, paymentData) {
    // Calculate total
    const bookPrice = affirmed_stripe.book_price * 100; // Convert to cents
    const shippingCost = affirmed_stripe.shipping_cost * 100;
    const total = bookPrice + shippingCost;

    // Create line items
    const lineItems = [
      {
        price_data: {
          currency: affirmed_stripe.currency,
          product_data: {
            name: affirmed_stripe.book_title,
            description: "Positive Affirmations Book by Pastor Tony Ray Smith",
            images: [
              window.location.origin +
                "/wp-content/themes/affirmed-theme/assets/img/book-cover.webp",
            ],
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

    // Redirect to Stripe Checkout
    stripe
      .redirectToCheckout({
        lineItems: lineItems,
        mode: "payment",
        customerEmail: customerEmail,
        successUrl:
          affirmed_stripe.success_url + "?session_id={CHECKOUT_SESSION_ID}",
        cancelUrl: affirmed_stripe.cancel_url,
        shippingAddressCollection: affirmed_stripe.shipping_required
          ? {
              allowedCountries: ["US", "CA", "GB", "AU", "SG", "MY", "ID"],
            }
          : undefined,
      })
      .then(function (result) {
        if (result.error) {
          showErrorMessage(result.error.message);
          $('#affirmed-order-form button[type="submit"]')
            .prop("disabled", false)
            .html('<i class="fas fa-lock"></i> Secure Checkout');
        }
      });
  }

  // Validate order form
  function validateOrderForm($form) {
    let isValid = true;
    const requiredFields = ["name", "email", "phone"];

    // Only validate shipping fields if not using Stripe's shipping collection
    if (!affirmed_stripe.shipping_required) {
      requiredFields.push("address", "city", "state", "zip", "country");
    }

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

  // Add Stripe branding
  function addStripeBranding() {
    const $form = $("#affirmed-order-form");

    if ($form.length) {
      // Update shipping fields message if Stripe handles shipping
      if (affirmed_stripe.shipping_required) {
        const shippingNote = `
                    <div class="shipping-note" style="background: #f0f9ff; border: 1px solid #0ea5e9; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        <p style="font-size: 12px; color: #0369a1; margin: 0;">
                            <i class="fas fa-info-circle"></i> Shipping address will be collected securely during checkout
                        </p>
                    </div>
                `;
        $form.find('input[name="address"]').closest("div").before(shippingNote);

        // Make shipping fields optional
        $form
          .find(
            'input[name="address"], input[name="city"], input[name="state"], input[name="zip"], select[name="country"]'
          )
          .removeAttr("required")
          .attr("placeholder", function (i, val) {
            return val + " (Optional - will be collected at checkout)";
          });
      }

      // Add secure payment badge
      const badgeHtml = `
                <div class="stripe-security-badge" style="text-align: center; margin-top: 15px;">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 10px;">
                        <img src="https://cdn.brandfolder.io/KGT2DTA4/at/8vbr8k4mr5xjwk4hxq4t9vs/Powered_by_Stripe_-_blurple.svg" 
                             alt="Powered by Stripe" 
                             style="height: 26px;">
                        <span style="color: #6b7280; font-size: 14px;">|</span>
                        <span style="font-size: 14px; color: #6b7280;">
                            <i class="fas fa-lock"></i> SSL Encrypted
                        </span>
                    </div>
                    <p style="font-size: 12px; color: #6b7280; margin: 0;">
                        Your payment information is secure and encrypted
                    </p>
                </div>
            `;

      $form.append(badgeHtml);

      // Add test mode indicator
      if (affirmed_stripe.mode === "test") {
        const testModeHtml = `
                    <div class="stripe-test-mode" style="background: #fef3c7; padding: 10px; border-radius: 5px; margin-top: 10px;">
                        <p style="font-size: 12px; color: #92400e; margin: 0; font-weight: bold;">
                            <i class="fas fa-exclamation-triangle"></i> TEST MODE ACTIVE
                        </p>
                        <p style="font-size: 11px; color: #92400e; margin: 5px 0 0 0;">
                            Use card: 4242 4242 4242 4242 | Any future date | Any CVC
                        </p>
                    </div>
                `;
        $form.append(testModeHtml);
      }

      // Add accepted cards
      const cardsHtml = `
                <div class="accepted-cards" style="text-align: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;">
                    <p style="font-size: 12px; color: #6b7280; margin-bottom: 8px;">Accepted Payment Methods</p>
                    <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                        <i class="fab fa-cc-visa" style="font-size: 24px; color: #1a1f71;"></i>
                        <i class="fab fa-cc-mastercard" style="font-size: 24px; color: #eb001b;"></i>
                        <i class="fab fa-cc-amex" style="font-size: 24px; color: #006fcf;"></i>
                        <i class="fab fa-cc-discover" style="font-size: 24px; color: #ff6000;"></i>
                    </div>
                </div>
            `;

      $form.append(cardsHtml);
    }
  }

  // Show error message
  function showErrorMessage(message) {
    const errorHtml = `
            <div class="stripe-error-message" style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                <p style="margin: 0; font-size: 14px;"><i class="fas fa-exclamation-circle"></i> ${message}</p>
            </div>
        `;

    // Remove any existing error messages
    $(".stripe-error-message").remove();

    // Add new error message
    $("#affirmed-order-form").prepend(errorHtml);

    // Scroll to error
    $("html, body").animate(
      {
        scrollTop: $(".stripe-error-message").offset().top - 100,
      },
      500
    );

    // Auto-remove after 5 seconds
    setTimeout(function () {
      $(".stripe-error-message").fadeOut(function () {
        $(this).remove();
      });
    }, 5000);
  }
})(jQuery);
