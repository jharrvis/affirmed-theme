/**
 * Kirki Installer JavaScript
 */
jQuery(document).ready(function ($) {
  // Handle dismiss button
  $(".dismiss-kirki-notice").on("click", function (e) {
    e.preventDefault();

    var $notice = $(this).closest(".notice");

    $.ajax({
      url: affirmedKirki.ajax_url,
      type: "POST",
      data: {
        action: "dismiss_kirki_notice",
        nonce: affirmedKirki.nonce,
      },
      success: function (response) {
        $notice.fadeOut();
      },
    });
  });

  // Handle install button via AJAX (optional enhancement)
  $(".install-kirki-ajax").on("click", function (e) {
    e.preventDefault();

    var $button = $(this);
    var originalText = $button.text();

    $button.text(affirmedKirki.installing_text).prop("disabled", true);

    $.ajax({
      url: affirmedKirki.ajax_url,
      type: "POST",
      data: {
        action: "install_kirki_plugin",
        nonce: affirmedKirki.nonce,
      },
      success: function (response) {
        if (response.success) {
          $button.text(affirmedKirki.success_text);
          setTimeout(function () {
            window.location.reload();
          }, 1500);
        } else {
          $button.text(affirmedKirki.error_text);
          console.error(response.data.message);
        }
      },
      error: function () {
        $button.text(affirmedKirki.error_text);
      },
      complete: function () {
        setTimeout(function () {
          $button.text(originalText).prop("disabled", false);
        }, 3000);
      },
    });
  });
});
