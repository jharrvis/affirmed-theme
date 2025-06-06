jQuery(document).ready(function ($) {
  // Smooth scrolling for anchor links
  $('a[href^="#"]').on("click", function (event) {
    var target = $(this.getAttribute("href"));
    if (target.length) {
      event.preventDefault();
      $("html, body")
        .stop()
        .animate(
          {
            scrollTop: target.offset().top - 100,
          },
          1000
        );
    }
  });

  // Form submission handler
  $("#affirmed-order-form").on("submit", function (e) {
    e.preventDefault();

    var form = $(this);
    var submitButton = form.find('button[type="submit"]');
    var originalText = submitButton.html();

    // Validate form before submission
    if (!validateForm(form)) {
      alert("Please fill in all required fields correctly.");
      return false;
    }

    // Show loading state
    submitButton.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    submitButton.prop("disabled", true);

    // Collect form data
    var formData = {
      action: "affirmed_form_submit",
      nonce: form.find('[name="affirmed_nonce"]').val(),
      name: form.find('[name="name"]').val(),
      email: form.find('[name="email"]').val(),
      phone: form.find('[name="phone"]').val(),
      address: form.find('[name="address"]').val(),
      city: form.find('[name="city"]').val(),
      state: form.find('[name="state"]').val(),
      zip: form.find('[name="zip"]').val(),
      country: form.find('[name="country"]').val(),
    };

    // Submit form via AJAX
    $.post(affirmed_ajax.ajax_url, formData, function (response) {
      if (response.success) {
        // Show success message
        alert(
          "Thank you! Your information has been submitted successfully. You will be redirected to the payment page."
        );

        // In a real implementation, redirect to payment processor
        // window.location.href = '/payment-page/';

        // Reset form
        form[0].reset();

        // Update progress to step 2
        updateFormProgress(2);
      } else {
        alert("There was an error submitting your form. Please try again.");
      }
    })
      .fail(function () {
        alert("There was an error submitting your form. Please try again.");
      })
      .always(function () {
        // Restore button state
        submitButton.html(originalText);
        submitButton.prop("disabled", false);
      });
  });

  // Update form progress indicator
  function updateFormProgress(step) {
    $(".step-number").removeClass("active").addClass("inactive");
    $(".step-number")
      .eq(step - 1)
      .removeClass("inactive")
      .addClass("active");

    var progressWidth = (step / 2) * 100;
    $(".progress-fill").css("width", progressWidth + "%");
  }

  // Form validation function
  function validateForm(form) {
    var isValid = true;
    var requiredFields = form.find("[required]");

    requiredFields.each(function () {
      var field = $(this);
      var value = field.val().trim();

      // Remove previous error styling
      field.removeClass("error");

      if (!value) {
        field.addClass("error");
        isValid = false;
      } else {
        // Email validation
        if (field.attr("type") === "email") {
          var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(value)) {
            field.addClass("error");
            isValid = false;
          }
        }

        // Phone validation (basic)
        if (field.attr("type") === "tel") {
          var cleanPhone = value.replace(/[\s\-\(\)]/g, "");
          if (cleanPhone.length < 10) {
            field.addClass("error");
            isValid = false;
          }
        }
      }
    });

    return isValid;
  }

  // Real-time validation on field blur
  $(".form-input").on("blur", function () {
    var field = $(this);
    var value = field.val().trim();

    field.removeClass("error");

    if (field.prop("required") && !value) {
      field.addClass("error");
    } else if (field.attr("type") === "email" && value) {
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        field.addClass("error");
      }
    } else if (field.attr("type") === "tel" && value) {
      var cleanPhone = value.replace(/[\s\-\(\)]/g, "");
      if (cleanPhone.length < 10) {
        field.addClass("error");
      }
    }
  });

  // Buy Now button handlers
  $('.btn-success, .btn[href*="buy"], button:contains("BUY NOW")').on(
    "click",
    function (e) {
      e.preventDefault();

      // Scroll to order form
      var orderForm = $(".order-form");
      if (orderForm.length) {
        $("html, body").animate(
          {
            scrollTop: orderForm.offset().top - 100,
          },
          1000
        );

        // Focus on first input after animation
        setTimeout(function () {
          orderForm.find('input[name="name"]').focus();
        }, 1100);
      } else {
        // If no form on page, show alert (for demo purposes)
        alert(
          "This would redirect to the order page in a real implementation."
        );
      }
    }
  );

  // Animate elements on scroll
  function animateOnScroll() {
    $(".feature-card, .testimonial-card").each(function () {
      var element = $(this);
      var elementTop = element.offset().top;
      var elementBottom = elementTop + element.outerHeight();
      var viewportTop = $(window).scrollTop();
      var viewportBottom = viewportTop + $(window).height();

      if (elementBottom > viewportTop && elementTop < viewportBottom) {
        element.addClass("animate-in");
      }
    });
  }

  // FAQ accordion functionality
  $(".faq-question").on("click", function () {
    var item = $(this).parent();
    var answer = item.find(".faq-answer");

    // Toggle current item
    item.toggleClass("active");
    answer.slideToggle(300);

    // Optional: Close other items (uncomment if you want accordion behavior)
    // $('.faq-item').not(item).removeClass('active').find('.faq-answer').slideUp(300);
  });

  // Mobile menu toggle (for future navigation implementation)
  $(".mobile-menu-toggle").on("click", function () {
    $(".main-navigation").toggleClass("active");
    $(this).toggleClass("active");
  });

  // Testimonial auto-slider
  var currentTestimonial = 0;
  var testimonials = $(".testimonial-card");

  function showTestimonial(index) {
    testimonials.removeClass("active").eq(index).addClass("active");
  }

  // Auto-advance testimonials every 8 seconds
  if (testimonials.length > 1) {
    setInterval(function () {
      currentTestimonial = (currentTestimonial + 1) % testimonials.length;
      showTestimonial(currentTestimonial);
    }, 8000);
  }

  // Lazy loading for images
  function lazyLoadImages() {
    $("img[data-src]").each(function () {
      var img = $(this);
      var rect = this.getBoundingClientRect();

      if (rect.top < window.innerHeight && rect.bottom > 0) {
        img.attr("src", img.attr("data-src"));
        img.removeAttr("data-src");
        img.addClass("loaded");
      }
    });
  }

  // Copy email to clipboard functionality
  $('.copy-email, .faq-answer a[href^="mailto:"]').on("click", function (e) {
    if ($(this).hasClass("copy-email")) {
      e.preventDefault();
      var email = $(this).text();
      copyToClipboard(email, "Email copied to clipboard!");
    }
  });

  // Copy to clipboard helper function
  function copyToClipboard(text, successMessage) {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(text).then(function () {
        showNotification(successMessage || "Copied to clipboard!");
      });
    } else {
      // Fallback for older browsers
      var textArea = document.createElement("textarea");
      textArea.value = text;
      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();

      try {
        document.execCommand("copy");
        showNotification(successMessage || "Copied to clipboard!");
      } catch (err) {
        alert("Unable to copy. Please copy manually: " + text);
      }

      document.body.removeChild(textArea);
    }
  }

  // Show notification function
  function showNotification(message) {
    var notification = $('<div class="notification">' + message + "</div>");
    $("body").append(notification);

    setTimeout(function () {
      notification.addClass("show");
    }, 100);

    setTimeout(function () {
      notification.removeClass("show");
      setTimeout(function () {
        notification.remove();
      }, 300);
    }, 3000);
  }

  // Print page functionality
  $(".print-page").on("click", function (e) {
    e.preventDefault();
    window.print();
  });

  // Social sharing functions
  $(".share-facebook").on("click", function (e) {
    e.preventDefault();
    var url = encodeURIComponent(window.location.href);
    var shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + url;
    openShareWindow(shareUrl, "facebook-share");
  });

  $(".share-twitter").on("click", function (e) {
    e.preventDefault();
    var url = encodeURIComponent(window.location.href);
    var text = encodeURIComponent(document.title);
    var shareUrl =
      "https://twitter.com/intent/tweet?url=" + url + "&text=" + text;
    openShareWindow(shareUrl, "twitter-share");
  });

  $(".share-linkedin").on("click", function (e) {
    e.preventDefault();
    var url = encodeURIComponent(window.location.href);
    var shareUrl = "https://www.linkedin.com/sharing/share-offsite/?url=" + url;
    openShareWindow(shareUrl, "linkedin-share");
  });

  function openShareWindow(url, name) {
    window.open(url, name, "width=580,height=400,scrollbars=yes,resizable=yes");
  }

  // Back to top button
  var backToTop = $(
    '<button class="back-to-top" title="Back to Top" aria-label="Back to Top"><i class="fas fa-arrow-up"></i></button>'
  );
  $("body").append(backToTop);

  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 300) {
      backToTop.addClass("visible");
    } else {
      backToTop.removeClass("visible");
    }
  });

  backToTop.on("click", function () {
    $("html, body").animate({ scrollTop: 0 }, 600);
  });

  // Trigger scroll events
  $(window).on("scroll resize", function () {
    animateOnScroll();
    lazyLoadImages();
  });

  // Initial calls
  animateOnScroll();
  lazyLoadImages();

  // Form auto-save to localStorage (optional feature)
  var formAutoSave = {
    save: function () {
      var formData = {};
      $("#affirmed-order-form input, #affirmed-order-form select").each(
        function () {
          var field = $(this);
          if (field.attr("name") && field.attr("name") !== "affirmed_nonce") {
            formData[field.attr("name")] = field.val();
          }
        }
      );
      localStorage.setItem("affirmed_form_data", JSON.stringify(formData));
    },

    load: function () {
      var savedData = localStorage.getItem("affirmed_form_data");
      if (savedData) {
        try {
          var formData = JSON.parse(savedData);
          for (var fieldName in formData) {
            $('#affirmed-order-form [name="' + fieldName + '"]').val(
              formData[fieldName]
            );
          }
        } catch (e) {
          console.log("Error loading saved form data");
        }
      }
    },

    clear: function () {
      localStorage.removeItem("affirmed_form_data");
    },
  };

  // Load saved form data on page load
  formAutoSave.load();

  // Save form data on input change
  $("#affirmed-order-form input, #affirmed-order-form select").on(
    "input change",
    function () {
      formAutoSave.save();
    }
  );

  // Clear saved data on successful form submission
  $("#affirmed-order-form").on("submit", function () {
    setTimeout(formAutoSave.clear, 1000);
  });

  // Keyboard navigation improvements
  $(document).on("keydown", function (e) {
    // ESC key closes modals/notifications
    if (e.keyCode === 27) {
      $(".notification").removeClass("show");
    }

    // Enter key on Buy Now buttons
    if (e.keyCode === 13 && $(e.target).hasClass("btn-success")) {
      $(e.target).click();
    }
  });

  // Add loading state for images
  $("img").on("load", function () {
    $(this).addClass("loaded");
  });

  // Error handling for missing images
  $("img").on("error", function () {
    var img = $(this);
    img.addClass("error");
    console.log("Failed to load image: " + img.attr("src"));
  });

  // Initialize tooltips (if using Bootstrap or similar)
  if (typeof $().tooltip === "function") {
    $('[data-toggle="tooltip"]').tooltip();
  }

  // Performance monitoring
  if (window.performance && window.performance.timing) {
    $(window).on("load", function () {
      var loadTime =
        window.performance.timing.loadEventEnd -
        window.performance.timing.navigationStart;
      console.log("Page load time: " + loadTime + "ms");
    });
  }

  // Console message for developers
  console.log("Affirmed Theme: JavaScript initialized successfully");
  console.log("Theme version: 1.0");
  console.log("jQuery version: " + $.fn.jquery);

  // Add dynamic CSS for enhanced functionality
  $("<style>")
    .prop("type", "text/css")
    .html(
      `
            /* Form validation styles */
            .form-input.error {
                border-color: #ef4444 !important;
                background-color: #fef2f2 !important;
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
            }
            
            /* Animation styles */
            .feature-card, .testimonial-card {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            
            .feature-card.animate-in, .testimonial-card.animate-in {
                opacity: 1;
                transform: translateY(0);
            }
            
            /* Back to top button */
            .back-to-top {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 50px;
                height: 50px;
                background: #10b981;
                color: white;
                border: none;
                border-radius: 50%;
                cursor: pointer;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                z-index: 1000;
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            }
            
            .back-to-top.visible {
                opacity: 1;
                visibility: visible;
            }
            
            .back-to-top:hover {
                background: #059669;
                transform: translateY(-3px);
                box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            }
            
            /* Notification styles */
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: #10b981;
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.3s ease;
                z-index: 1001;
            }
            
            .notification.show {
                opacity: 1;
                transform: translateX(0);
            }
            
            /* Image loading states */
            img {
                transition: opacity 0.3s ease;
            }
            
            img:not(.loaded) {
                opacity: 0.7;
            }
            
            img.loaded {
                opacity: 1;
            }
            
            img.error {
                opacity: 0.5;
                background: #f3f4f6;
            }
            
            /* FAQ accordion styles */
            .faq-item.active .faq-question {
                color: #10b981;
            }
            
            .faq-answer {
                overflow: hidden;
            }
            
            /* Testimonial slider styles */
            .testimonial-card {
                transition: opacity 0.5s ease, transform 0.5s ease;
            }
            
            .testimonial-card:not(.active) {
                opacity: 0.7;
                transform: scale(0.95);
            }
            
            .testimonial-card.active {
                opacity: 1;
                transform: scale(1);
            }
            
            /* Loading spinner */
            .fa-spinner {
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            
            /* Mobile enhancements */
            @media (max-width: 768px) {
                .back-to-top {
                    bottom: 20px;
                    right: 20px;
                    width: 45px;
                    height: 45px;
                }
                
                .notification {
                    top: 10px;
                    right: 10px;
                    left: 10px;
                    transform: translateY(-100%);
                }
                
                .notification.show {
                    transform: translateY(0);
                }
            }
        `
    )
    .appendTo("head");
});
