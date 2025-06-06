<?php
/**
 * The main template file
 */

get_header(); ?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, <?php echo esc_attr(affirmed_get_option('hero_bg_color', '#000000')); ?>, #1f2937);">
    <div class="container">
        <h1 class="hero-title">
            <span class="highlight"><?php echo esc_html(affirmed_get_option('hero_title', 'Change Your Mindset, Improve Your Life, Thrive')); ?></span>
            – With Affirmed
        </h1>
        <h2 class="hero-subtitle">
            <?php echo esc_html(affirmed_get_option('hero_subtitle', 'Affirmed: Your Beginning Point Towards a Life Path Full of Positivity & Strength')); ?>
        </h2>
    </div>
</section>

<!-- Main Content Section -->
<section class="main-content">
    <div class="container">
        <div class="content-grid">
            <!-- Left Column - Content -->
            <div>
                <?php $book_image = affirmed_get_option('book_image', get_template_directory_uri() . '/assets/img/book-cover.webp'); ?>
                <img src="<?php echo esc_url($book_image); ?>" alt="<?php esc_attr_e('Affirmed Book', 'affirmed-theme'); ?>" class="book-image" />

                <div class="text-center">
                    <h3 class="mb-4" style="font-size: 1.5rem; font-weight: bold;">
                        <?php echo esc_html(affirmed_get_option('book_title', 'Discover The Transformative Power of Words')); ?>
                    </h3>

                    <div style="color: #374151; text-align: left;">
                        <p class="main-quote-1"><?php echo esc_html(affirmed_get_option('main_quote1', '"I\'m not qualified enough for this job!"')); ?></p>
                        <p class="main-quote-2"><?php echo esc_html(affirmed_get_option('main_quote2', '"I don\'t deserve to be happy!"')); ?></p>
                        <p class="main-quote-3"><?php echo esc_html(affirmed_get_option('main_quote3', '"My life is a disaster!"')); ?></p>
                        <p class="main-question"><?php echo esc_html(affirmed_get_option('main_question', 'How many times have you found yourself drowning in a spiral of negative thoughts?')); ?></p>
                        <p class="book-description"><?php echo esc_html(affirmed_get_option('book_description', 'Words have the power to uplift or destroy you. A simple word is often enough to undermine your mood and confidence. By contrast, one positive affirmation can give you the encouragement you need to move on.')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Form -->
            <div class="order-form">
                <div class="mb-6">
                    <div class="form-progress">
                        <div class="progress-step">
                            <div class="step-number active">1</div>
                            <div>
                                <h4 style="font-weight: bold; color: #3b82f6;">SHIPPING</h4>
                                <p style="font-size: 0.875rem; color: #6b7280;">Where Should We Ship It?</p>
                            </div>
                        </div>
                        <div class="progress-step">
                            <div class="step-number inactive">2</div>
                            <div>
                                <h4 style="font-weight: bold; color: #6b7280;">PAYMENT INFO</h4>
                                <p style="font-size: 0.875rem; color: #6b7280;">Ordering Instructions</p>
                            </div>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                </div>

                <form id="affirmed-order-form">
                    <?php wp_nonce_field('affirmed_nonce', 'affirmed_nonce'); ?>
                    
                    <input type="text" name="name" placeholder="Full Name..." class="form-input" required />
                    <input type="email" name="email" placeholder="Email Address..." class="form-input" required />
                    <input type="tel" name="phone" placeholder="Phone Number..." class="form-input" required />

                    <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem;">
                        <h5 style="font-weight: bold; margin-bottom: 0.5rem;">SHIPPING</h5>
                        <div>
                            <input type="text" name="address" placeholder="Full Address..." class="form-input" required />
                            <input type="text" name="city" placeholder="City Name..." class="form-input" required />
                            <div class="input-row">
                                <input type="text" name="state" placeholder="State / Province..." class="form-input" required />
                                <input type="text" name="zip" placeholder="Zip Code..." class="form-input" required />
                            </div>
                            <select name="country" class="form-input" required>
                                <option value="">Select Country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fas fa-arrow-right" style="margin-right: 0.5rem;"></i>Go To Step #2
                    </button>
                    <p style="font-size: 0.75rem; color: #6b7280; text-align: center; margin-top: 0.5rem;">
                        We Respect Your Privacy & Information.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Author Section -->
<section class="author-section">
    <div class="container">
        <div class="text-center mb-12">
            <h2 class="author-title">
                Presenting "Affirmed" By <?php echo esc_html(affirmed_get_option('author_name', 'Pastor Tony Ray Smith')); ?>: Your Daily Dose Of Motivational and Positive Thinking
            </h2>
        </div>

        <div class="author-content">
            <div class="author-text">
                <p><?php echo esc_html(affirmed_get_option('author_bio', 'With the goal of infusing your life with confidence and gratitude, Pastor Tony Ray Smith has created a collection of positive affirmations enhanced with inspirational quotes and scriptures.')); ?></p>
                <p>Whether you are dealing with rejection, frustration, despair, or any other unpleasant situation in your life, this book is your source of positivity and hope. It helps to maintain your faith and optimism, even in the most challenging moments.</p>
            </div>
            <div class="text-center">
                <?php $author_image = affirmed_get_option('author_image', get_template_directory_uri() . '/assets/img/tony-ray-portrait.webp'); ?>
                <img src="<?php echo esc_url($author_image); ?>" alt="<?php echo esc_attr(affirmed_get_option('author_name', 'Pastor Tony Ray Smith')); ?>" class="author-image" />
            </div>
        </div>

        <div class="text-center" style="margin-top: 4rem;">
            <h3 class="features-title">
                <?php echo esc_html(affirmed_get_option('features_title', 'Why add "Affirmed" To Your Collection?')); ?>
            </h3>
        </div>

        <!-- Features Grid -->
        <div class="features-grid">
            <?php 
            $features_count = affirmed_get_option('features_count', 3);
            for ($i = 1; $i <= $features_count; $i++) :
                $feature_image = affirmed_get_option("feature{$i}_image", get_template_directory_uri() . "/assets/img/img{$i}.webp");
                $feature_title = affirmed_get_option("feature{$i}_title", "Feature {$i} Title");
                $feature_description = affirmed_get_option("feature{$i}_description", "Feature {$i} description");
            ?>
            <div class="feature-card">
                <img src="<?php echo esc_url($feature_image); ?>" alt="<?php echo esc_attr($feature_title); ?>" class="feature-image" />
                <h4 class="feature-title"><?php echo esc_html($feature_title); ?></h4>
                <p><?php echo wp_kses_post($feature_description); ?></p>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- Sample Affirmation Section -->
<section class="sample-section">
    <div class="container">
        <h2 class="sample-title">
            <?php echo esc_html(affirmed_get_option('sample_title', 'Affirmation Sample "Peace"')); ?>
        </h2>

        <div class="sample-content">
            <p class="sample-quote">Peace</p>
            
            <?php 
            $sample_quote1 = affirmed_get_option('sample_quote1', '"Do not let the behavior of others destroy your inner peace." — Dalai Lama');
            $sample_quote2 = affirmed_get_option('sample_quote2', '"Peace I leave with you; my peace I give to you. Not as the world gives do I give to you. Let not your hearts be troubled, neither let them be afraid." — John 14:27');
            ?>
            
            <p class="sample-quote-1"><?php echo esc_html($sample_quote1); ?></p>
            <p class="sample-quote-2"><?php echo esc_html($sample_quote2); ?></p>
            
            <p class="sample-quote">Unexplainable Peace</p>
            <div style="font-size: 1.125rem; line-height: 1.8;" class="sample-affirmation">
                <?php echo wp_kses_post(wpautop(affirmed_get_option('sample_content', 'I will live in peace, at peace, and with peace. I dwell in a peace that passes all understanding.'))); ?>
            </div>
        </div>

        <button class="btn btn-success" style="margin-top: 3rem;">
            BUY NOW
        </button>

        <!-- Testimonial -->
        <div style="margin-top: 4rem; max-width: 48rem; margin-left: auto; margin-right: auto;">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img4.jpg" alt="Pastor Charlet Lewis" style="width: 8rem; height: 8rem; border-radius: 50%; margin: 0 auto 1.5rem; display: block;" />
            <blockquote style="font-size: 1.25rem; font-style: italic; margin-bottom: 1rem;">
                "In his latest book, "Affirmed," Pastor Tony Smith offers his readers a guide that teaches us how to "speak life" over our own lives. Oh, how I wished I had read this book many years ago when my journey of change began."
            </blockquote>
            <cite style="font-weight: bold;">
                Pastor Charlet Lewis, Author<br />
                "I Had to Change"
            </cite>
        </div>
    </div>
</section>

<!-- Get Affirmed Section -->
<section style="background: white; padding: 4rem 0;">
    <div class="container">
        <h2 style="font-size: 3.5rem; font-weight: bold; text-align: center; color: #1f2937; margin-bottom: 4rem;">
            Get Affirmed
        </h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; max-width: 72rem; margin: 0 auto;">
            <div style="font-size: 1.125rem; color: #374151; line-height: 1.8;">
                <p style="margin-bottom: 1.5rem;">Nicole Ashley said it best "Affirmations are short, powerful, yet simple statements designed to manifest a specific goal. Positive thinking reinforced by verbal affirmations are designed to encourage a life filled with positivity and gratitude."</p>
                <p style="margin-bottom: 1.5rem;">Pastor Tony Ray Smith's book comes with enough affirmations to help you find some strength and comfort during your hardships.</p>
                <p style="margin-bottom: 1.5rem;">Use them as a source of inspiration to broaden your self-perspective and create your own versions that will accompany you throughout your life journey.</p>
                <p style="margin-bottom: 1.5rem;">Affirmed will equip you with the information and resources for you to begin creating your own affirmations to use during your prayer, meditation, and/or quiet time.</p>
                <p>Written affirmations can also become a source of hope and encouragement for your friends and family!</p>
            </div>

            <div class="text-center">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/book-cover.jpg" alt="Affirmed Book Cover" style="width: 100%; max-width: 28rem; margin: 0 auto; border-radius: 0.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);" />
            </div>
        </div>
    </div>
</section>

<!-- Affirmations List Section -->
<section class="author-section">
    <div class="container">
        <div class="affirmations-content">
            <div>
                <h3 style="font-size: 1.875rem; font-weight: bold; margin-bottom: 2rem; text-align: center;">
                    Affirmations You'll Find in This Book!
                </h3>
                <ul class="affirmations-list">
                    <li>Brokenness</li>
                    <li>Children</li>
                    <li>Creativity</li>
                    <li>Deliverance</li>
                    <li>Family</li>
                    <li>Grief</li>
                    <li>Happiness</li>
                    <li>Health</li>
                    <li>Letting Go</li>
                    <li>Marriage</li>
                    <li>Closure</li>
                    <li>Bonus - Bedtime Affirmation</li>
                </ul>
            </div>

            <div class="text-center">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/happy-person.jpg" alt="Happy person working" style="width: 100%; border-radius: 0.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1);" />
            </div>
        </div>

        <div class="text-center" style="margin-top: 4rem;">
            <h3 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">
                Make An Invaluable Gift to Yourself or Someone Else
            </h3>
            <p style="font-size: 1.125rem; max-width: 64rem; margin: 0 auto 1.5rem;">
                Once you learn to speak and think positively, more positive things will come in your way.
            </p>
            <p style="font-size: 1.125rem; max-width: 64rem; margin: 0 auto 1.5rem;">
                This book will help you experience the impact that affirmations can have on your thoughts, emotions, and actions so you can make them a part of your daily routine.
            </p>
            <p style="font-size: 1.125rem; max-width: 64rem; margin: 0 auto; font-weight: 600;">
                Buy your softcover copy today and get the digital version for free!
            </p>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<?php if (affirmed_get_option('show_testimonials', true)) : ?>
<section class="author-section testimonials-section">
    <div class="container">
        <h2 style="font-size: 2.5rem; font-weight: bold; text-align: center; margin-bottom: 4rem;">
            <?php echo esc_html(affirmed_get_option('testimonials_title', 'Praise For "Affirmed"')); ?>
        </h2>

        <div class="testimonials-grid">
            <?php 
            $testimonials_count = affirmed_get_option('testimonials_count', 3);
            for ($i = 1; $i <= $testimonials_count; $i++) :
                $testimonial_image = affirmed_get_option("testimonial{$i}_image", get_template_directory_uri() . "/assets/img/testimonial{$i}.jpg");
                $testimonial_name = affirmed_get_option("testimonial{$i}_name", "Person {$i}");
                $testimonial_title = affirmed_get_option("testimonial{$i}_title", "Title {$i}");
                $testimonial_content = affirmed_get_option("testimonial{$i}_content", "Testimonial content {$i}");
            ?>
            <div class="testimonial-card">
                <img src="<?php echo esc_url($testimonial_image); ?>" alt="<?php echo esc_attr($testimonial_name); ?>" class="testimonial-image" />
                <blockquote class="testimonial-text">
                    <?php echo esc_html($testimonial_content); ?>
                </blockquote>
                <cite class="testimonial-author">
                    <?php echo esc_html($testimonial_name); ?><br />
                    <?php echo esc_html($testimonial_title); ?>
                </cite>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQ Section -->
<?php if (affirmed_get_option('show_faq', true)) : ?>
<section class="author-section faq-section">
    <div class="container">
        <h2 style="font-size: 2rem; font-weight: bold; text-align: center; margin-bottom: 4rem;">
            <?php echo esc_html(affirmed_get_option('faq_title', 'Frequently Asked Questions')); ?>
        </h2>

        <div class="faq-grid">
            <?php 
            $faq_count = affirmed_get_option('faq_count', 5);
            $half_count = ceil($faq_count / 2);
            
            // Left column
            echo '<div>';
            for ($i = 1; $i <= $half_count; $i++) :
                $faq_question = affirmed_get_option("faq{$i}_question", "FAQ Question {$i}?");
                $faq_answer = affirmed_get_option("faq{$i}_answer", "FAQ Answer {$i}");
                
                // Replace email placeholder in answers
                $contact_email = affirmed_get_option('contact_email', 'cs@tonyraysmith.com');
                $faq_answer = str_replace(array('cs@tonyraysmith.com', '{contact_email}'), $contact_email, $faq_answer);
            ?>
                <div class="faq-item">
                    <h4 class="faq-question">
                        <i class="fas fa-question-circle" style="color: #60a5fa; margin-right: 0.5rem;"></i>
                        <?php echo esc_html($faq_question); ?>
                    </h4>
                    <p class="faq-answer"><?php echo wp_kses_post($faq_answer); ?></p>
                </div>
            <?php endfor; 
            echo '</div>';
            
            // Right column
            echo '<div>';
            for ($i = ($half_count + 1); $i <= $faq_count; $i++) :
                $faq_question = affirmed_get_option("faq{$i}_question", "FAQ Question {$i}?");
                $faq_answer = affirmed_get_option("faq{$i}_answer", "FAQ Answer {$i}");
                
                // Replace email placeholder in answers
                $contact_email = affirmed_get_option('contact_email', 'cs@tonyraysmith.com');
                $faq_answer = str_replace(array('cs@tonyraysmith.com', '{contact_email}'), $contact_email, $faq_answer);
            ?>
                <div class="faq-item">
                    <h4 class="faq-question">
                        <i class="fas fa-question-circle" style="color: #60a5fa; margin-right: 0.5rem;"></i>
                        <?php echo esc_html($faq_question); ?>
                    </h4>
                    <p class="faq-answer"><?php echo wp_kses_post($faq_answer); ?></p>
                </div>
            <?php endfor; 
            echo '</div>';
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>