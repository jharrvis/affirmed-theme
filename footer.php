</main><!-- #main -->

    <!-- Footer -->
    <footer id="colophon" class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="text-center" style="text-align: left;">
                    <h3 class="footer-brand">AFFIRMED</h3>
                </div>

                <div>
                    <div class="footer-contact">
                        <i class="fas fa-phone footer-icon"></i>
                        <div>
                            <p style="font-weight: bold; font-size: 0.875rem;">NEED HELP ORDERING?</p>
                            <p style="color: #9ca3af; font-size: 0.875rem;">
                                Call <?php echo esc_html(affirmed_get_option('contact_phone', '703.957.0529')); ?> during regular office hours: Monday to Saturday 9 AM - 6 PM
                            </p>
                        </div>
                    </div>

                    <div class="footer-contact">
                        <i class="fas fa-shield-alt footer-icon"></i>
                        <div>
                            <p style="font-weight: bold; font-size: 0.875rem;">30-DAY SATISFACTION GUARANTEED</p>
                            <p style="color: #9ca3af; font-size: 0.875rem;">
                                We are committed to your satisfaction with every order.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (is_active_sidebar('footer-widgets')) : ?>
                <div class="footer-widgets" style="margin-top: 2rem;">
                    <?php dynamic_sidebar('footer-widgets'); ?>
                </div>
            <?php endif; ?>

            <div class="footer-bottom">
                <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 1rem;">
                    <?php echo esc_html(affirmed_get_option('copyright_text', 'Tony Ray Smith Enterprises, LLC | Copyright ©2021 | All Rights Reserved')); ?>
                </p>
                <p style="color: white; font-size: 0.75rem;">
                    <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" style="color: white; text-decoration: none;">Privacy Policy</a> - 
                    <a href="<?php echo esc_url(home_url('/terms-conditions')); ?>" style="color: white; text-decoration: none;">Terms & Conditions</a> - 
                    <a href="<?php echo esc_url(home_url('/disclaimer')); ?>" style="color: white; text-decoration: none;">Disclaimer</a>
                </p>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>