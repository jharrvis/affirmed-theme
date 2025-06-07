/**
 * Affirmed Theme Main JavaScript
 */
jQuery(document).ready(function ($) {
  // Handle order form submission
  $("#affirmed-order-form").on("submit", function (e) {
    e.preventDefault();

    var $form = $(this);
    var $submitBtn = $form.find('button[type="submit"]');
    var originalBtnText = $submitBtn.html();

    // Disable button and show loading state
    $submitBtn
      .prop("disabled", true)
      .html('<i class="fas fa-spinner fa-spin"></i> Processing...');

    // Serialize form data
    var formData = $form.serialize();

    $.ajax({
      url: affirmed_ajax.ajax_url,
      type: "POST",
      data: {
        action: "affirmed_form_submit",
        nonce: affirmed_ajax.nonce,
        ...$form.serializeArray().reduce((obj, item) => {
          obj[item.name] = item.value;
          return obj;
        }, {}),
      },
      success: function (response) {
        if (response.success) {
          // Show success message
          $form.html(
            '<div style="text-align: center; padding: 2rem;"><i class="fas fa-check-circle" style="font-size: 3rem; color: #10b981; margin-bottom: 1rem; display: block;"></i><h3>Thank You!</h3><p>' +
              response.data.message +
              "</p></div>"
          );
        } else {
          // Show error message
          alert("An error occurred. Please try again.");
          $submitBtn.prop("disabled", false).html(originalBtnText);
        }
      },
      error: function () {
        alert("An error occurred. Please try again.");
        $submitBtn.prop("disabled", false).html(originalBtnText);
      },
    });
  });

  // Smooth scrolling for anchor links
  $('a[href^="#"]').on("click", function (e) {
    e.preventDefault();

    var target = $(this).attr("href");
    if (target === "#") return;

    var $target = $(target);
    if ($target.length) {
      $("html, body").animate(
        {
          scrollTop: $target.offset().top - 100,
        },
        800
      );
    }
  });

  // Add animation on scroll
  if (affirmed_get_option("enable_animations", true)) {
    var animateElements = $(".feature-card, .testimonial-card, .faq-item");

    function checkAnimation() {
      var windowHeight = $(window).height();
      var windowTop = $(window).scrollTop();
      var windowBottom = windowTop + windowHeight;

      animateElements.each(function () {
        var $element = $(this);
        var elementTop = $element.offset().top;
        var elementBottom = elementTop + $element.outerHeight();

        if (elementBottom >= windowTop && elementTop <= windowBottom) {
          $element.addClass("animated");
        }
      });
    }

    $(window).on("scroll resize", checkAnimation);
    checkAnimation();
  }

  // FAQ toggle (if needed)
  $(".faq-question").on("click", function () {
    $(this).next(".faq-answer").slideToggle();
    $(this).toggleClass("active");
  });
});

// Helper function to get theme option (mock for JS)
function affirmed_get_option(option, defaultValue) {
  // This is a placeholder - actual values come from PHP
  return defaultValue;
}
