jQuery(document).ready(function ($) {
  // Handle Kirki plugin installation
  $(".affirmed-kirki-notice .button-primary").on("click", function (e) {
    e.preventDefault();

    var $button = $(this);
    var $notice = $button.closest(".affirmed-kirki-notice");
    var originalText = $button.text();
    var isInstall = $button.attr("href").indexOf("install-plugin") !== -1;

    // Update button state
    $button.prop("disabled", true);
    $button.html(
      '<span class="dashicons dashicons-update spin" style="margin-right: 5px;"></span> ' +
        (isInstall
          ? affirmedKirki.installing_text
          : affirmedKirki.activating_text)
    );

    // If it's an install/activate link, follow it
    if ($button.attr("href")) {
      window.location.href = $button.attr("href");
      return;
    }

    // Otherwise handle via AJAX
    $.ajax({
      url: affirmedKirki.ajax_url,
      type: "POST",
      data: {
        action: "install_kirki_plugin",
        nonce: affirmedKirki.nonce,
      },
      success: function (response) {
        if (response.success) {
          $button.html(
            '<span class="dashicons dashicons-yes" style="margin-right: 5px; color: #46b450;"></span> ' +
              affirmedKirki.success_text
          );

          // Show success message
          showNotification(response.data.message, "success");

          // Reload page after 2 seconds
          setTimeout(function () {
            location.reload();
          }, 2000);
        } else {
          $button.html(
            '<span class="dashicons dashicons-warning" style="margin-right: 5px; color: #dc3232;"></span> ' +
              affirmedKirki.error_text
          );
          showNotification(
            response.data.message || "Installation failed",
            "error"
          );

          // Restore button after 3 seconds
          setTimeout(function () {
            $button.prop("disabled", false);
            $button.text(originalText);
          }, 3000);
        }
      },
      error: function () {
        $button.html(
          '<span class="dashicons dashicons-warning" style="margin-right: 5px; color: #dc3232;"></span> ' +
            affirmedKirki.error_text
        );
        showNotification("Network error occurred", "error");

        // Restore button after 3 seconds
        setTimeout(function () {
          $button.prop("disabled", false);
          $button.text(originalText);
        }, 3000);
      },
    });
  });

  // Handle notice dismissal
  $(".dismiss-kirki-notice").on("click", function (e) {
    e.preventDefault();

    var $notice = $(this).closest(".affirmed-kirki-notice");

    $.ajax({
      url: affirmedKirki.ajax_url,
      type: "POST",
      data: {
        action: "dismiss_kirki_notice",
        nonce: affirmedKirki.nonce,
      },
      success: function (response) {
        if (response.success) {
          $notice.fadeOut(300, function () {
            $(this).remove();
          });
        }
      },
    });
  });

  // Handle WordPress default notice dismissal
  $(document).on(
    "click",
    ".affirmed-kirki-notice .notice-dismiss",
    function () {
      var $notice = $(this).closest(".affirmed-kirki-notice");

      $.ajax({
        url: affirmedKirki.ajax_url,
        type: "POST",
        data: {
          action: "dismiss_kirki_notice",
          nonce: affirmedKirki.nonce,
        },
      });
    }
  );

  // Show notification function
  function showNotification(message, type) {
    type = type || "info";

    var notificationClass = "notice notice-" + type + " is-dismissible";
    var $notification = $(
      '<div class="' + notificationClass + '"><p>' + message + "</p></div>"
    );

    // Add to page
    $(".wrap > h1").after($notification);

    // Auto-dismiss after 5 seconds
    setTimeout(function () {
      $notification.fadeOut(300, function () {
        $(this).remove();
      });
    }, 5000);
  }

  // Add spinning animation for loading states
  $("<style>")
    .prop("type", "text/css")
    .html(
      `
            .spin {
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            
            .affirmed-kirki-notice {
                border-left-color: #d63638 !important;
            }
            
            .affirmed-kirki-notice .button {
                transition: all 0.3s ease;
            }
            
            .affirmed-kirki-notice .button:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }
            
            .affirmed-kirki-notice .dashicons {
                vertical-align: middle;
            }
        `
    )
    .appendTo("head");

  // Check for successful installation/activation
  var urlParams = new URLSearchParams(window.location.search);
  if (
    urlParams.get("activate") === "true" ||
    urlParams.get("plugin-activated") === "true"
  ) {
    showNotification(
      "Kirki plugin activated successfully! You can now access all theme customization options.",
      "success"
    );
  }

  // Theme activation welcome message
  if (urlParams.get("activated") === "true") {
    var welcomeMessage = `
            <div class="notice notice-success is-dismissible affirmed-welcome-notice">
                <h3 style="margin: 10px 0;">Welcome to Affirmed Theme!</h3>
                <p>Thank you for choosing Affirmed theme. To get started with customizing your site:</p>
                <ol style="margin-left: 20px;">
                    <li>Install the Kirki Customizer Framework plugin (if not already installed)</li>
                    <li>Go to <strong>Appearance → Customize</strong> to configure your content</li>
                    <li>Upload your images to the <code>assets/img/</code> folder</li>
                </ol>
                <p>
                    <a href="' + admin_url('customize.php') + '" class="button button-primary">Start Customizing</a>
                    <a href="#" class="button button-secondary dismiss-welcome" style="margin-left: 10px;">Dismiss</a>
                </p>
            </div>
        `;

    $(".wrap > h1").after(welcomeMessage);

    // Handle welcome notice dismissal
    $(document).on("click", ".dismiss-welcome", function (e) {
      e.preventDefault();
      $(this).closest(".affirmed-welcome-notice").fadeOut();
    });
  }

  // Add helpful links to theme page
  if (
    $("body").hasClass("appearance_page_themes") ||
    $("body").hasClass("themes-php")
  ) {
    var $themeActions = $(".theme.active .theme-actions");
    if ($themeActions.length) {
      var customizeButton =
        '<a href="' +
        admin_url("customize.php") +
        '" class="button button-primary">Customize Theme</a>';
      $themeActions.prepend(customizeButton);
    }
  }

  // Add theme info to customizer
  if ($("body").hasClass("wp-customizer")) {
    // Add theme status info
    var kirkiStatus = affirmedKirki.kirki_active
      ? '<span style="color: #46b450;">✓ Kirki Active</span>'
      : '<span style="color: #dc3232;">✗ Kirki Required</span>';

    var themeInfo = `
            <div id="affirmed-theme-info" style="
                background: #fff; 
                padding: 15px; 
                margin: 10px 0; 
                border-left: 4px solid #00a0d2;
                box-shadow: 0 1px 1px rgba(0,0,0,0.04);
            ">
                <h4 style="margin: 0 0 10px 0;">Affirmed Theme Status</h4>
                <p style="margin: 0; font-size: 13px;">${kirkiStatus}</p>
            </div>
        `;

    setTimeout(function () {
      $("#customize-controls").prepend(themeInfo);
    }, 1000);
  }

  console.log("Affirmed Kirki Installer: Initialized successfully");
});
