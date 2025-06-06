/**
 * Customizer Live Preview JavaScript
 *
 * Handles live preview updates for Kirki customizer controls
 */

(function ($) {
  "use strict";

  // Wait for the customizer to be ready
  wp.customize.bind("ready", function () {
    console.log("Affirmed Theme: Customizer preview ready");
  });

  // =============================================================================
  // HERO SECTION
  // =============================================================================

  // Hero Title
  wp.customize("affirmed_theme_options[hero_title]", function (value) {
    value.bind(function (newval) {
      $(".hero-title .highlight").text(newval);
    });
  });

  // Hero Subtitle
  wp.customize("affirmed_theme_options[hero_subtitle]", function (value) {
    value.bind(function (newval) {
      $(".hero-subtitle").text(newval);
    });
  });

  // Hero Background Color
  wp.customize("affirmed_theme_options[hero_bg_color]", function (value) {
    value.bind(function (newval) {
      $(".hero-section").css(
        "background",
        "linear-gradient(135deg, " + newval + ", #1f2937)"
      );
    });
  });

  // Hero Text Color
  wp.customize("affirmed_theme_options[hero_text_color]", function (value) {
    value.bind(function (newval) {
      $(".hero-section").css("color", newval);
    });
  });

  // Hero Highlight Color
  wp.customize(
    "affirmed_theme_options[hero_highlight_color]",
    function (value) {
      value.bind(function (newval) {
        $(".hero-title .highlight").css("color", newval);
      });
    }
  );

  // =============================================================================
  // BOOK SECTION
  // =============================================================================

  // Book Image
  wp.customize("affirmed_theme_options[book_image]", function (value) {
    value.bind(function (newval) {
      $(".book-image").attr("src", newval);
    });
  });

  // Book Title
  wp.customize("affirmed_theme_options[book_title]", function (value) {
    value.bind(function (newval) {
      $(".book-title, .main-content h3").text(newval);
    });
  });

  // Book Description
  wp.customize("affirmed_theme_options[book_description]", function (value) {
    value.bind(function (newval) {
      $(".book-description").text(newval);
    });
  });

  // Book Price
  wp.customize("affirmed_theme_options[book_price]", function (value) {
    value.bind(function (newval) {
      $(".book-price").text(newval);
    });
  });

  // =============================================================================
  // AUTHOR SECTION
  // =============================================================================

  // Author Name
  wp.customize("affirmed_theme_options[author_name]", function (value) {
    value.bind(function (newval) {
      $(".author-name, .author-title").each(function () {
        var text = $(this).text();
        $(this).text(
          text.replace(/Pastor Tony Ray Smith|Tony Ray Smith/g, newval)
        );
      });
    });
  });

  // Author Image
  wp.customize("affirmed_theme_options[author_image]", function (value) {
    value.bind(function (newval) {
      $(".author-image").attr("src", newval);
    });
  });

  // Author Bio
  wp.customize("affirmed_theme_options[author_bio]", function (value) {
    value.bind(function (newval) {
      $(".author-bio, .author-text p:first-child").text(newval);
    });
  });

  // Author Additional Info
  wp.customize(
    "affirmed_theme_options[author_additional_info]",
    function (value) {
      value.bind(function (newval) {
        $(".author-additional-info, .author-text p:last-child").text(newval);
      });
    }
  );

  // =============================================================================
  // FEATURES SECTION
  // =============================================================================

  // Features Title
  wp.customize("affirmed_theme_options[features_title]", function (value) {
    value.bind(function (newval) {
      $(".features-title").text(newval);
    });
  });

  // Feature 1
  wp.customize("affirmed_theme_options[feature1_image]", function (value) {
    value.bind(function (newval) {
      $(".feature-card:nth-child(1) .feature-image").attr("src", newval);
    });
  });

  wp.customize("affirmed_theme_options[feature1_title]", function (value) {
    value.bind(function (newval) {
      $(".feature-card:nth-child(1) .feature-title").text(newval);
    });
  });

  wp.customize(
    "affirmed_theme_options[feature1_description]",
    function (value) {
      value.bind(function (newval) {
        $(".feature-card:nth-child(1) p").text(newval);
      });
    }
  );

  // Feature 2
  wp.customize("affirmed_theme_options[feature2_image]", function (value) {
    value.bind(function (newval) {
      $(".feature-card:nth-child(2) .feature-image").attr("src", newval);
    });
  });

  wp.customize("affirmed_theme_options[feature2_title]", function (value) {
    value.bind(function (newval) {
      $(".feature-card:nth-child(2) .feature-title").text(newval);
    });
  });

  wp.customize(
    "affirmed_theme_options[feature2_description]",
    function (value) {
      value.bind(function (newval) {
        $(".feature-card:nth-child(2) p em").text(newval);
      });
    }
  );

  // Feature 3
  wp.customize("affirmed_theme_options[feature3_image]", function (value) {
    value.bind(function (newval) {
      $(".feature-card:nth-child(3) .feature-image").attr("src", newval);
    });
  });

  wp.customize("affirmed_theme_options[feature3_title]", function (value) {
    value.bind(function (newval) {
      $(".feature-card:nth-child(3) .feature-title").text(newval);
    });
  });

  wp.customize(
    "affirmed_theme_options[feature3_description]",
    function (value) {
      value.bind(function (newval) {
        $(".feature-card:nth-child(3) p").text(newval);
      });
    }
  );

  // =============================================================================
  // SAMPLE SECTION
  // =============================================================================

  // Sample Title
  wp.customize("affirmed_theme_options[sample_title]", function (value) {
    value.bind(function (newval) {
      $(".sample-title").text(newval);
    });
  });

  // Sample Content
  wp.customize("affirmed_theme_options[sample_content]", function (value) {
    value.bind(function (newval) {
      $(".sample-content .sample-affirmation").text(newval);
    });
  });

  // Sample Quote 1
  wp.customize("affirmed_theme_options[sample_quote1]", function (value) {
    value.bind(function (newval) {
      $(".sample-content .sample-quote-1").text(newval);
    });
  });

  // Sample Quote 2
  wp.customize("affirmed_theme_options[sample_quote2]", function (value) {
    value.bind(function (newval) {
      $(".sample-content .sample-quote-2").text(newval);
    });
  });

  // =============================================================================
  // TESTIMONIALS SECTION
  // =============================================================================

  // Testimonials Title
  wp.customize("affirmed_theme_options[testimonials_title]", function (value) {
    value.bind(function (newval) {
      $(".testimonials-section h2").text(newval);
    });
  });

  // Show/Hide Testimonials
  wp.customize("affirmed_theme_options[show_testimonials]", function (value) {
    value.bind(function (newval) {
      if (newval) {
        $(".testimonials-section").show();
      } else {
        $(".testimonials-section").hide();
      }
    });
  });

  // =============================================================================
  // CONTACT SECTION
  // =============================================================================

  // Phone Number
  wp.customize("affirmed_theme_options[contact_phone]", function (value) {
    value.bind(function (newval) {
      $(".contact-phone").text(newval);
    });
  });

  // Email Address
  wp.customize("affirmed_theme_options[contact_email]", function (value) {
    value.bind(function (newval) {
      $(".contact-email").text(newval);
      $('.faq-answer a[href^="mailto:"]')
        .attr("href", "mailto:" + newval)
        .text(newval);
    });
  });

  // Office Hours
  wp.customize("affirmed_theme_options[office_hours]", function (value) {
    value.bind(function (newval) {
      $(".office-hours").text(newval);
    });
  });

  // Copyright Text
  wp.customize("affirmed_theme_options[copyright_text]", function (value) {
    value.bind(function (newval) {
      $(".copyright-text").text(newval);
    });
  });

  // =============================================================================
  // COLORS & STYLING
  // =============================================================================

  // Primary Button Color
  wp.customize(
    "affirmed_theme_options[primary_button_color]",
    function (value) {
      value.bind(function (newval) {
        $(".btn-primary").css("background-color", newval);
      });
    }
  );

  // Success Button Color
  wp.customize(
    "affirmed_theme_options[success_button_color]",
    function (value) {
      value.bind(function (newval) {
        $(".btn-success").css("background-color", newval);
      });
    }
  );

  // Accent Color
  wp.customize("affirmed_theme_options[accent_color]", function (value) {
    value.bind(function (newval) {
      $(".features-title, .footer-brand").css("color", newval);
    });
  });

  // =============================================================================
  // ADVANCED SETTINGS
  // =============================================================================

  // Enable/Disable Animations
  wp.customize("affirmed_theme_options[enable_animations]", function (value) {
    value.bind(function (newval) {
      if (newval) {
        $("body").removeClass("no-animations");
      } else {
        $("body").addClass("no-animations");
      }
    });
  });

  // Enable/Disable Back to Top Button
  wp.customize("affirmed_theme_options[enable_back_to_top]", function (value) {
    value.bind(function (newval) {
      if (newval) {
        $(".back-to-top").show();
      } else {
        $(".back-to-top").hide();
      }
    });
  });

  // =============================================================================
  // FALLBACK FOR BASIC CUSTOMIZER (without Kirki)
  // =============================================================================

  // Basic customizer bindings for when Kirki is not available
  if (typeof wp.customize !== "undefined") {
    // Hero title fallback
    wp.customize("hero_title", function (value) {
      value.bind(function (newval) {
        $(".hero-title .highlight").text(newval);
      });
    });

    // Hero subtitle fallback
    wp.customize("hero_subtitle", function (value) {
      value.bind(function (newval) {
        $(".hero-subtitle").text(newval);
      });
    });

    // Book title fallback
    wp.customize("book_title", function (value) {
      value.bind(function (newval) {
        $(".book-title, .main-content h3").text(newval);
      });
    });

    // Contact phone fallback
    wp.customize("contact_phone", function (value) {
      value.bind(function (newval) {
        $(".contact-phone").text(newval);
      });
    });

    // Contact email fallback
    wp.customize("contact_email", function (value) {
      value.bind(function (newval) {
        $(".contact-email").text(newval);
        $('.faq-answer a[href^="mailto:"]')
          .attr("href", "mailto:" + newval)
          .text(newval);
      });
    });
  }

  // =============================================================================
  // HELPER FUNCTIONS
  // =============================================================================

  // Smooth updates with fade effect
  function smoothUpdate(selector, newValue, property) {
    property = property || "text";

    $(selector).fadeOut(200, function () {
      if (property === "text") {
        $(this).text(newValue);
      } else if (property === "src") {
        $(this).attr("src", newValue);
      } else if (property === "css") {
        $(this).css(newValue);
      }
      $(this).fadeIn(200);
    });
  }

  // Debounce function for performance
  function debounce(func, wait, immediate) {
    var timeout;
    return function () {
      var context = this,
        args = arguments;
      var later = function () {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };
      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    };
  }

  // Add visual feedback for live preview
  function highlightElement(selector) {
    $(selector).css({
      "box-shadow": "0 0 20px rgba(59, 130, 246, 0.5)",
      transition: "box-shadow 0.3s ease",
    });

    setTimeout(function () {
      $(selector).css("box-shadow", "");
    }, 1000);
  }

  // Console logging for debugging
  console.log(
    "Affirmed Theme: Customizer preview JavaScript loaded successfully"
  );
})(jQuery);
