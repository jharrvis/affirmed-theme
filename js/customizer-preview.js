/**
 * Customizer Live Preview
 */
(function ($) {
  // Hero Section
  wp.customize("hero_title", function (value) {
    value.bind(function (newval) {
      $(".hero-title .highlight").text(newval);
    });
  });

  wp.customize("hero_subtitle", function (value) {
    value.bind(function (newval) {
      $(".hero-subtitle").text(newval);
    });
  });

  // Book Section
  wp.customize("book_title", function (value) {
    value.bind(function (newval) {
      $(".book-title").text(newval);
    });
  });

  wp.customize("book_description", function (value) {
    value.bind(function (newval) {
      $(".book-description").text(newval);
    });
  });

  wp.customize("book_price", function (value) {
    value.bind(function (newval) {
      $(".book-price").text(newval);
    });
  });

  // Author Section
  wp.customize("author_name", function (value) {
    value.bind(function (newval) {
      $(".author-name").text(newval);
    });
  });

  wp.customize("author_bio", function (value) {
    value.bind(function (newval) {
      $(".author-bio").text(newval);
    });
  });

  // Main Content
  wp.customize("main_quote1", function (value) {
    value.bind(function (newval) {
      $(".main-quote-1").text(newval);
    });
  });

  wp.customize("main_quote2", function (value) {
    value.bind(function (newval) {
      $(".main-quote-2").text(newval);
    });
  });

  wp.customize("main_quote3", function (value) {
    value.bind(function (newval) {
      $(".main-quote-3").text(newval);
    });
  });

  wp.customize("main_question", function (value) {
    value.bind(function (newval) {
      $(".main-question").text(newval);
    });
  });

  // Features Section
  wp.customize("features_title", function (value) {
    value.bind(function (newval) {
      $(".features-title").text(newval);
    });
  });

  // Dynamic Features
  for (var i = 1; i <= 6; i++) {
    (function (index) {
      wp.customize("feature" + index + "_title", function (value) {
        value.bind(function (newval) {
          $(".feature-card:nth-child(" + index + ") .feature-title").text(
            newval
          );
        });
      });

      wp.customize("feature" + index + "_description", function (value) {
        value.bind(function (newval) {
          $(".feature-card:nth-child(" + index + ") p").text(newval);
        });
      });
    })(i);
  }

  // Sample Section
  wp.customize("sample_title", function (value) {
    value.bind(function (newval) {
      $(".sample-title").html(newval);
    });
  });

  wp.customize("sample_content", function (value) {
    value.bind(function (newval) {
      $(".sample-affirmation").text(newval);
    });
  });

  wp.customize("sample_quote1", function (value) {
    value.bind(function (newval) {
      $(".sample-quote-1").text(newval);
    });
  });

  wp.customize("sample_quote2", function (value) {
    value.bind(function (newval) {
      $(".sample-quote-2").text(newval);
    });
  });

  // Testimonials
  wp.customize("testimonials_title", function (value) {
    value.bind(function (newval) {
      $(".testimonials-section h2").text(newval);
    });
  });

  // Dynamic Testimonials
  for (var i = 1; i <= 6; i++) {
    (function (index) {
      wp.customize("testimonial" + index + "_name", function (value) {
        value.bind(function (newval) {
          $(
            ".testimonial-card:nth-child(" + index + ") .testimonial-author"
          ).html(
            newval +
              "<br>" +
              $(
                ".testimonial-card:nth-child(" + index + ") .testimonial-author"
              )
                .html()
                .split("<br>")[1]
          );
        });
      });

      wp.customize("testimonial" + index + "_title", function (value) {
        value.bind(function (newval) {
          var name = $(
            ".testimonial-card:nth-child(" + index + ") .testimonial-author"
          )
            .html()
            .split("<br>")[0];
          $(
            ".testimonial-card:nth-child(" + index + ") .testimonial-author"
          ).html(name + "<br>" + newval);
        });
      });

      wp.customize("testimonial" + index + "_content", function (value) {
        value.bind(function (newval) {
          $(
            ".testimonial-card:nth-child(" + index + ") .testimonial-text"
          ).text(newval);
        });
      });
    })(i);
  }

  // FAQ Section
  wp.customize("faq_title", function (value) {
    value.bind(function (newval) {
      $(".faq-section h2").text(newval);
    });
  });

  // Dynamic FAQ
  for (var i = 1; i <= 10; i++) {
    (function (index) {
      wp.customize("faq" + index + "_question", function (value) {
        value.bind(function (newval) {
          $(".faq-item:nth-child(" + index + ") .faq-question").html(
            '<i class="fas fa-question-circle" style="color: #60a5fa; margin-right: 0.5rem;"></i>' +
              newval
          );
        });
      });

      wp.customize("faq" + index + "_answer", function (value) {
        value.bind(function (newval) {
          $(".faq-item:nth-child(" + index + ") .faq-answer").text(newval);
        });
      });
    })(i);
  }

  // Contact Information
  wp.customize("contact_phone", function (value) {
    value.bind(function (newval) {
      $(".footer-contact:first-child p:last-child").text(
        "Call " +
          newval +
          " during regular office hours: Monday to Saturday 9 AM - 6 PM"
      );
    });
  });

  wp.customize("copyright_text", function (value) {
    value.bind(function (newval) {
      $(".footer-bottom p:first-child").text(newval);
    });
  });
})(jQuery);
