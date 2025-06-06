<?php
/**
 * Affirmed Theme Customizer Configuration
 * 
 * This file contains all Kirki customizer settings and configurations
 * Separated for easy maintenance and updates
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if Kirki is available
 */
if (!class_exists('Kirki')) {
    return;
}

/**
 * Kirki Configuration
 */
function affirmed_kirki_configuration() {
    Kirki::add_config('affirmed_theme_config', array(
        'capability'    => 'edit_theme_options',
        'option_type'   => 'theme_mod',
        'option_name'   => 'affirmed_theme_options',
    ));
}
add_action('after_setup_theme', 'affirmed_kirki_configuration');

/**
 * Add Customizer Panels
 */
function affirmed_add_customizer_panels() {
    
    // Main Theme Panel
    Kirki::add_panel('affirmed_theme_panel', array(
        'priority'    => 10,
        'title'       => esc_html__('Affirmed Theme Options', 'affirmed-theme'),
        'description' => esc_html__('Customize your Affirmed landing page theme settings.', 'affirmed-theme'),
    ));
}
add_action('after_setup_theme', 'affirmed_add_customizer_panels');

/**
 * Add Customizer Sections and Fields
 */
function affirmed_add_customizer_sections() {
    
    // =============================================================================
    // HERO SECTION
    // =============================================================================
    
    Kirki::add_section('affirmed_hero_section', array(
        'title'    => esc_html__('Hero Section', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 10,
    ));

    // Hero Title
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'hero_title',
        'label'    => esc_html__('Hero Title', 'affirmed-theme'),
        'section'  => 'affirmed_hero_section',
        'default'  => 'Change Your Mindset, Improve Your Life, Thrive',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Hero Subtitle
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'hero_subtitle',
        'label'    => esc_html__('Hero Subtitle', 'affirmed-theme'),
        'section'  => 'affirmed_hero_section',
        'default'  => 'Affirmed: Your Beginning Point Towards a Life Path Full of Positivity & Strength',
        'priority' => 20,
        'transport' => 'postMessage',
    ));

    // Hero Background Color
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'color',
        'settings' => 'hero_bg_color',
        'label'    => esc_html__('Hero Background Color', 'affirmed-theme'),
        'section'  => 'affirmed_hero_section',
        'default'  => '#000000',
        'priority' => 30,
        'choices'  => array(
            'alpha' => true,
        ),
        'output'   => array(
            array(
                'element'  => '.hero-section',
                'property' => 'background',
                'value_pattern' => 'linear-gradient(135deg, $, #1f2937)',
            ),
        ),
    ));

    // Hero Text Color
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'color',
        'settings' => 'hero_text_color',
        'label'    => esc_html__('Hero Text Color', 'affirmed-theme'),
        'section'  => 'affirmed_hero_section',
        'default'  => '#ffffff',
        'priority' => 40,
        'output'   => array(
            array(
                'element'  => '.hero-section',
                'property' => 'color',
            ),
        ),
    ));

    // Hero Highlight Color
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'color',
        'settings' => 'hero_highlight_color',
        'label'    => esc_html__('Hero Highlight Color', 'affirmed-theme'),
        'section'  => 'affirmed_hero_section',
        'default'  => '#10b981',
        'priority' => 50,
        'output'   => array(
            array(
                'element'  => '.hero-title .highlight',
                'property' => 'color',
            ),
        ),
    ));

    // =============================================================================
    // BOOK SECTION
    // =============================================================================
    
    Kirki::add_section('affirmed_book_section', array(
        'title'    => esc_html__('Book Section', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 20,
    ));

    // Book Image
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'image',
        'settings' => 'book_image',
        'label'    => esc_html__('Book Cover Image', 'affirmed-theme'),
        'section'  => 'affirmed_book_section',
        'default'  => get_template_directory_uri() . '/assets/img/book-cover.webp',
        'priority' => 10,
    ));

    // Book Title
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'book_title',
        'label'    => esc_html__('Book Section Title', 'affirmed-theme'),
        'section'  => 'affirmed_book_section',
        'default'  => 'Discover The Transformative Power of Words',
        'priority' => 20,
        'transport' => 'postMessage',
    ));

    // Book Description
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'book_description',
        'label'    => esc_html__('Book Description', 'affirmed-theme'),
        'section'  => 'affirmed_book_section',
        'default'  => 'You may not always understand it, but words have the power to uplift or destroy you. A simple word is often enough to undermine your mood and confidence. By contrast, one positive affirmation can give you the encouragement you need to move on. Words can shape the way you live and feel. Therefore, choosing the right ones can and will transform your entire life!',
        'priority' => 30,
        'transport' => 'postMessage',
    ));

    // Book Price
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'book_price',
        'label'    => esc_html__('Book Price', 'affirmed-theme'),
        'section'  => 'affirmed_book_section',
        'default'  => '$19.99',
        'priority' => 40,
        'transport' => 'postMessage',
    ));

    // =============================================================================
    // AUTHOR SECTION
    // =============================================================================
    
    Kirki::add_section('author_section', array(
        'title'    => esc_html__('Author Section', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 30,
    ));

    // Author Name
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'author_name',
        'label'    => esc_html__('Author Name', 'affirmed-theme'),
        'section'  => 'author_section',
        'default'  => 'Pastor Tony Ray Smith',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Author Image
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'image',
        'settings' => 'author_image',
        'label'    => esc_html__('Author Image', 'affirmed-theme'),
        'section'  => 'author_section',
        'default'  => get_template_directory_uri() . '/assets/img/tony-ray-portrait.webp',
        'priority' => 20,
    ));

    // Author Bio
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'author_bio',
        'label'    => esc_html__('Author Bio', 'affirmed-theme'),
        'section'  => 'author_section',
        'default'  => 'With the goal of infusing your life with confidence and gratitude, Pastor Tony Ray Smith has created a collection of positive affirmations enhanced with inspirational quotes and scriptures.',
        'priority' => 30,
        'transport' => 'postMessage',
    ));

    // Author Additional Info
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'author_additional_info',
        'label'    => esc_html__('Author Additional Information', 'affirmed-theme'),
        'section'  => 'author_section',
        'default'  => 'Whether you are dealing with rejection, frustration, despair, or any other unpleasant situation in your life, this book is your source of positivity and hope.',
        'priority' => 40,
        'transport' => 'postMessage',
    ));

    // =============================================================================
    // MAIN CONTENT SECTION
    // =============================================================================
    
    Kirki::add_section('main_content_section', array(
        'title'    => esc_html__('Main Content Section', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 25,
    ));

    // Main Content Texts (customizable quotes)
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'main_quote1',
        'label'    => esc_html__('Quote 1', 'affirmed-theme'),
        'section'  => 'main_content_section',
        'default'  => '"I\'m not qualified enough for this job!"',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'main_quote2',
        'label'    => esc_html__('Quote 2', 'affirmed-theme'),
        'section'  => 'main_content_section',
        'default'  => '"I don\'t deserve to be happy!"',
        'priority' => 20,
        'transport' => 'postMessage',
    ));

    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'main_quote3',
        'label'    => esc_html__('Quote 3', 'affirmed-theme'),
        'section'  => 'main_content_section',
        'default'  => '"My life is a disaster!"',
        'priority' => 30,
        'transport' => 'postMessage',
    ));

    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'main_question',
        'label'    => esc_html__('Main Question', 'affirmed-theme'),
        'section'  => 'main_content_section',
        'default'  => 'How many times have you found yourself drowning in a spiral of negative thoughts?',
        'priority' => 40,
        'transport' => 'postMessage',
    ));

    // =============================================================================
    // FEATURES SECTION (Dynamic)
    // =============================================================================
    
    Kirki::add_section('affirmed_features_section', array(
        'title'    => esc_html__('Features Section', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 40,
    ));

    // Features Title
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'features_title',
        'label'    => esc_html__('Features Section Title', 'affirmed-theme'),
        'section'  => 'affirmed_features_section',
        'default'  => 'Why add "Affirmed" To Your Collection?',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Number of Features
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'slider',
        'settings' => 'features_count',
        'label'    => esc_html__('Number of Features', 'affirmed-theme'),
        'section'  => 'affirmed_features_section',
        'default'  => 3,
        'priority' => 20,
        'choices'  => array(
            'min'  => 1,
            'max'  => 6,
            'step' => 1,
        ),
    ));

    // Dynamic Features
    for ($i = 1; $i <= 6; $i++) {
        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'custom',
            'settings' => "feature{$i}_divider",
            'section'  => 'affirmed_features_section',
            'default'  => '<div style="padding: 20px 0; border-top: 1px solid #ddd; margin-top: 20px;"><h3 style="margin: 0; color: #333;">Feature ' . $i . '</h3></div>',
            'priority' => 20 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[features_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'image',
            'settings' => "feature{$i}_image",
            'label'    => esc_html__("Feature {$i} Image", 'affirmed-theme'),
            'section'  => 'affirmed_features_section',
            'default'  => get_template_directory_uri() . "/assets/img/img{$i}.webp",
            'priority' => 21 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[features_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'text',
            'settings' => "feature{$i}_title",
            'label'    => esc_html__("Feature {$i} Title", 'affirmed-theme'),
            'section'  => 'affirmed_features_section',
            'default'  => $i == 1 ? 'Never Run Out Of Motivation' : ($i == 2 ? 'Enjoy An Easy & Simple Reading Experience' : ($i == 3 ? 'Turn Reading Into Acting' : "Feature {$i} Title")),
            'priority' => 22 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[features_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'textarea',
            'settings' => "feature{$i}_description",
            'label'    => esc_html__("Feature {$i} Description", 'affirmed-theme'),
            'section'  => 'affirmed_features_section',
            'default'  => $i == 1 ? 'Even in the darkest of times, you can find something good to hold on to. This book will become your mood-booster, your prayer-starter, and ultimately, your closest companion every time you must cope with overwhelming thoughts and emotions.' : ($i == 2 ? 'Unlike other complicated self-help books, in Affirmed, you will only find simple, uplifting affirmations waiting for you to read them again and again when you need to remind yourself of all the good things that you deserve.' : ($i == 3 ? 'This life-changing book comes with 35 positive affirmations encouraging you to implement what they manifest into your everyday life. Fill your days with self-esteem and love, feel blessed, and turn the spotlight on whatever makes you happy.' : "Feature {$i} description text goes here.")),
            'priority' => 23 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[features_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));
    }_config', array(
            'type'     => 'custom',
            'settings' => "feature{$i}_divider",
            'section'  => 'features_section',
            'default'  => '<div style="padding: 20px 0; border-top: 1px solid #ddd; margin-top: 20px;"><h3 style="margin: 0; color: #333;">Feature ' . $i . '</h3></div>',
            'priority' => 20 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[features_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'image',
            'settings' => "feature{$i}_image",
            'label'    => esc_html__("Feature {$i} Image", 'affirmed-theme'),
            'section'  => 'features_section',
            'default'  => get_template_directory_uri() . "/assets/img/img{$i}.webp",
            'priority' => 21 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[features_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'text',
            'settings' => "feature{$i}_title",
            'label'    => esc_html__("Feature {$i} Title", 'affirmed-theme'),
            'section'  => 'features_section',
            'default'  => $i == 1 ? 'Never Run Out Of Motivation' : ($i == 2 ? 'Enjoy An Easy & Simple Reading Experience' : ($i == 3 ? 'Turn Reading Into Acting' : "Feature {$i} Title")),
            'priority' => 22 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[features_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'textarea',
            'settings' => "feature{$i}_description",
            'label'    => esc_html__("Feature {$i} Description", 'affirmed-theme'),
            'section'  => 'features_section',
            'default'  => $i == 1 ? 'Even in the darkest of times, you can find something good to hold on to. This book will become your mood-booster, your prayer-starter, and ultimately, your closest companion.' : ($i == 2 ? 'Unlike other complicated self-help books, in Affirmed, you will only find simple, uplifting affirmations waiting for you to read them again and again.' : ($i == 3 ? 'This life-changing book comes with 35 positive affirmations encouraging you to implement what they manifest into your everyday life.' : "Feature {$i} description text goes here.")),
            'priority' => 23 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[features_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));
    }

    // =============================================================================
    // SAMPLE SECTION
    // =============================================================================
    
    Kirki::add_section('affirmed_sample_section', array(
        'title'    => esc_html__('Sample Section', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 50,
    ));

    // Sample Title
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'sample_title',
        'label'    => esc_html__('Sample Title', 'affirmed-theme'),
        'section'  => 'affirmed_sample_section',
        'default'  => 'Affirmation Sample<br />"Peace"',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Sample Content
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'sample_content',
        'label'    => esc_html__('Sample Content', 'affirmed-theme'),
        'section'  => 'affirmed_sample_section',
        'default'  => 'I will live in peace, at peace, and with peace.\nI dwell in a peace that passes all understanding.\nI will not allow people or situations to disrupt, detain, or destroy my peace.\nThere is no separation between me and peace;\ntherefore, there will be peace in my home, peace on my job, and peace everywhere I am.\nI shift hostile environments because my presence brings Peace.\nI know the author of peace.\nPeace overflows in my life. Therefore, I share peace with everyone I encounter.\nShalom.',
        'priority' => 20,
        'transport' => 'postMessage',
    ));

    // Sample Quote 1
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'sample_quote1',
        'label'    => esc_html__('Sample Quote 1', 'affirmed-theme'),
        'section'  => 'affirmed_sample_section',
        'default'  => '"Do not let the behavior of others destroy your inner peace." — Dalai Lama',
        'priority' => 30,
        'transport' => 'postMessage',
    ));

    // Sample Quote 2
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'sample_quote2',
        'label'    => esc_html__('Sample Quote 2', 'affirmed-theme'),
        'section'  => 'affirmed_sample_section',
        'default'  => '"Peace I leave with you; my peace I give to you. Not as the world gives do I give to you. Let not your hearts be troubled, neither let them be afraid." — John 14:27',
        'priority' => 40,
        'transport' => 'postMessage',
    ));

    // =============================================================================
    // TESTIMONIALS SECTION (Dynamic)
    // =============================================================================
    
    Kirki::add_section('affirmed_testimonials_section', array(
        'title'    => esc_html__('Testimonials Section', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 60,
    ));

    // Testimonials Title
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'testimonials_title',
        'label'    => esc_html__('Testimonials Section Title', 'affirmed-theme'),
        'section'  => 'affirmed_testimonials_section',
        'default'  => 'Praise For "Affirmed"',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Show/Hide Testimonials
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'toggle',
        'settings' => 'show_testimonials',
        'label'    => esc_html__('Show Testimonials Section', 'affirmed-theme'),
        'section'  => 'affirmed_testimonials_section',
        'default'  => true,
        'priority' => 20,
    ));

    // Number of Testimonials
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'slider',
        'settings' => 'testimonials_count',
        'label'    => esc_html__('Number of Testimonials', 'affirmed-theme'),
        'section'  => 'affirmed_testimonials_section',
        'default'  => 3,
        'priority' => 30,
        'choices'  => array(
            'min'  => 1,
            'max'  => 6,
            'step' => 1,
        ),
        'active_callback' => array(
            array(
                'setting'  => 'affirmed_theme_options[show_testimonials]',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    // Dynamic Testimonials
    $default_testimonials = array(
        1 => array(
            'name' => 'Andrea Johnson',
            'title' => 'www.templetraining.net',
            'content' => 'To have a good day, I believe it begins the night before. Learning bedtime affirmations was a tremendous help in getting a good night\'s sleep and setting up my mind to have a good day. Every night I affirm, \'By God\'s grace, I release myself from all negative energy, thoughts, and feelings. I declare I will have sweet sleep.\'',
            'image' => 'Andrea-Johnson.jpg'
        ),
        2 => array(
            'name' => 'Pastor Cory J. Lanier',
            'title' => 'Executive Pastor',
            'content' => 'There\'s a picture on my office wall with Philippians 4:8 written out underscored by the statement \'What we feed grows and what we starve dies!\' My dear brother, Tony Ray Smith supplies us with a tool to challenge and help us to take an honest inventory of our lives and affirm positive change. Ask yourself, do I spend more time feeding your life with the things of God or the things of the world?',
            'image' => 'Pastor-Cory.jpg'
        ),
        3 => array(
            'name' => 'Will Cravens',
            'title' => 'Author, 99 for 1',
            'content' => 'In these days riddled with a worldwide pandemic, constant political tensions and news channels filled with negative messages, it\'s difficult to know where to turn for inspiration. Pastor Tony has taken the time to compile a book filled with affirmations designed to lift your spirit, in a time when this is desperately needed.',
            'image' => 'Will-Cravens.jpg'
        )
    );

    for ($i = 1; $i <= 6; $i++) {
        $default_data = isset($default_testimonials[$i]) ? $default_testimonials[$i] : array(
            'name' => "Person {$i}",
            'title' => "Title {$i}",
            'content' => "Testimonial content {$i} goes here.",
            'image' => "testimonial{$i}.jpg"
        );

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'custom',
            'settings' => "testimonial{$i}_divider",
            'section'  => 'affirmed_testimonials_section',
            'default'  => '<div style="padding: 20px 0; border-top: 1px solid #ddd; margin-top: 20px;"><h3 style="margin: 0; color: #333;">Testimonial ' . $i . '</h3></div>',
            'priority' => 30 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'image',
            'settings' => "testimonial{$i}_image",
            'label'    => esc_html__("Testimonial {$i} Image", 'affirmed-theme'),
            'section'  => 'affirmed_testimonials_section',
            'default'  => get_template_directory_uri() . '/assets/img/' . $default_data['image'],
            'priority' => 31 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'text',
            'settings' => "testimonial{$i}_name",
            'label'    => esc_html__("Testimonial {$i} Name", 'affirmed-theme'),
            'section'  => 'affirmed_testimonials_section',
            'default'  => $default_data['name'],
            'priority' => 32 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'text',
            'settings' => "testimonial{$i}_title",
            'label'    => esc_html__("Testimonial {$i} Title/Position", 'affirmed-theme'),
            'section'  => 'affirmed_testimonials_section',
            'default'  => $default_data['title'],
            'priority' => 33 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'textarea',
            'settings' => "testimonial{$i}_content",
            'label'    => esc_html__("Testimonial {$i} Content", 'affirmed-theme'),
            'section'  => 'affirmed_testimonials_section',
            'default'  => $default_data['content'],
            'priority' => 34 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));
    }

    // =============================================================================
    // FAQ SECTION (Dynamic)
    // =============================================================================
    
    Kirki::add_section('affirmed_faq_section', array(
        'title'    => esc_html__('FAQ Section', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 65,
    ));

    // FAQ Title
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'faq_title',
        'label'    => esc_html__('FAQ Section Title', 'affirmed-theme'),
        'section'  => 'affirmed_faq_section',
        'default'  => 'Frequently Asked Questions',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Show/Hide FAQ
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'toggle',
        'settings' => 'show_faq',
        'label'    => esc_html__('Show FAQ Section', 'affirmed-theme'),
        'section'  => 'affirmed_faq_section',
        'default'  => true,
        'priority' => 20,
    ));

    // Number of FAQ Items
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'slider',
        'settings' => 'faq_count',
        'label'    => esc_html__('Number of FAQ Items', 'affirmed-theme'),
        'section'  => 'affirmed_faq_section',
        'default'  => 5,
        'priority' => 30,
        'choices'  => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ),
        'active_callback' => array(
            array(
                'setting'  => 'affirmed_theme_options[show_faq]',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    // Default FAQ Items
    $default_faqs = array(
        1 => array(
            'question' => 'Can I buy this book in stores?',
            'answer' => 'No. "Affirmed" is available only through our store and Amazon.'
        ),
        2 => array(
            'question' => 'Do you have a refund policy?',
            'answer' => 'Yes! If you are not 100% satisfied with your purchase, just reach out to our customer experience team at cs@tonyraysmith.com within 30 days of your purchase. You will receive a full refund.'
        ),
        3 => array(
            'question' => 'When will I receive my book?',
            'answer' => 'You can expect to receive your book 5 - 7 business days after purchase. Shipping and delivery times vary depending on your location.'
        ),
        4 => array(
            'question' => 'Do you offer any discounts for purchasing more than one book?',
            'answer' => 'Yes! We offer discount pricing with every purchase of five or more books. Please contact our customer support team at cs@tonyraysmith.com for assistance with discount purchasing.'
        ),
        5 => array(
            'question' => 'I have another question. Can I get some assistance?',
            'answer' => 'Absolutely! Our customer support team is waiting and ready to help. Just email us at cs@tonyraysmith.com, and we\'ll take care of you.'
        )
    );

    // Dynamic FAQ Items
    for ($i = 1; $i <= 10; $i++) {
        $default_data = isset($default_faqs[$i]) ? $default_faqs[$i] : array(
            'question' => "FAQ Question {$i}?",
            'answer' => "FAQ Answer {$i} goes here."
        );

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'custom',
            'settings' => "faq{$i}_divider",
            'section'  => 'affirmed_faq_section',
            'default'  => '<div style="padding: 20px 0; border-top: 1px solid #ddd; margin-top: 20px;"><h3 style="margin: 0; color: #333;">FAQ ' . $i . '</h3></div>',
            'priority' => 30 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_faq]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[faq_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'text',
            'settings' => "faq{$i}_question",
            'label'    => esc_html__("FAQ {$i} Question", 'affirmed-theme'),
            'section'  => 'affirmed_faq_section',
            'default'  => $default_data['question'],
            'priority' => 31 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_faq]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[faq_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'textarea',
            'settings' => "faq{$i}_answer",
            'label'    => esc_html__("FAQ {$i} Answer", 'affirmed-theme'),
            'section'  => 'affirmed_faq_section',
            'default'  => $default_data['answer'],
            'priority' => 32 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_faq]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[faq_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));
    }

    // =============================================================================
    // CONTACT SECTION
    // =============================================================================
    
    Kirki::add_section('affirmed_contact_section', array(
        'title'    => esc_html__('Contact Information', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 70,
    ));

    // Phone Number
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'contact_phone',
        'label'    => esc_html__('Phone Number', 'affirmed-theme'),
        'section'  => 'affirmed_contact_section',
        'default'  => '703.957.0529',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Email Address
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'email',
        'settings' => 'contact_email',
        'label'    => esc_html__('Email Address', 'affirmed-theme'),
        'section'  => 'affirmed_contact_section',
        'default'  => 'cs@tonyraysmith.com',
        'priority' => 20,
        'transport' => 'postMessage',
    ));

    // Office Hours
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'office_hours',
        'label'    => esc_html__('Office Hours', 'affirmed-theme'),
        'section'  => 'affirmed_contact_section',
        'default'  => 'Monday to Saturday 9 AM - 6 PM',
        'priority' => 30,
        'transport' => 'postMessage',
    ));

    // Copyright Text
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'copyright_text',
        'label'    => esc_html__('Copyright Text', 'affirmed-theme'),
        'section'  => 'affirmed_contact_section',
        'default'  => 'Tony Ray Smith Enterprises, LLC | Copyright ©2021 | All Rights Reserved',
        'priority' => 40,
        'transport' => 'postMessage',
    ));

    // =============================================================================
    // COLORS & STYLING
    // =============================================================================
    
    Kirki::add_section('affirmed_colors_styling', array(
        'title'    => esc_html__('Colors & Styling', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 80,
    ));

    // Primary Button Color
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'color',
        'settings' => 'primary_button_color',
        'label'    => esc_html__('Primary Button Color', 'affirmed-theme'),
        'section'  => 'affirmed_colors_styling',
        'default'  => '#06b6d4',
        'priority' => 10,
        'output'   => array(
            array(
                'element'  => '.btn-primary',
                'property' => 'background-color',
            ),
        ),
    ));

    // Success Button Color
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'color',
        'settings' => 'success_button_color',
        'label'    => esc_html__('Success Button Color', 'affirmed-theme'),
        'section'  => 'affirmed_colors_styling',
        'default'  => '#10b981',
        'priority' => 20,
        'output'   => array(
            array(
                'element'  => '.btn-success',
                'property' => 'background-color',
            ),
        ),
    ));

    // Accent Color
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'color',
        'settings' => 'accent_color',
        'label'    => esc_html__('Accent Color', 'affirmed-theme'),
        'section'  => 'affirmed_colors_styling',
        'default'  => '#fbbf24',
        'priority' => 30,
        'output'   => array(
            array(
                'element'  => '.features-title, .footer-brand',
                'property' => 'color',
            ),
        ),
    ));

    // Custom CSS
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'code',
        'settings' => 'custom_css',
        'label'    => esc_html__('Custom CSS', 'affirmed-theme'),
        'section'  => 'affirmed_colors_styling',
        'default'  => '',
        'priority' => 40,
        'choices'  => array(
            'language' => 'css',
        ),
    ));

    // =============================================================================
    // ADVANCED SETTINGS
    // =============================================================================
    
    Kirki::add_section('affirmed_advanced_settings', array(
        'title'    => esc_html__('Advanced Settings', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 90,
    ));

    // Google Analytics Code
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'google_analytics',
        'label'    => esc_html__('Google Analytics Code', 'affirmed-theme'),
        'section'  => 'affirmed_advanced_settings',
        'default'  => '',
        'priority' => 10,
    ));

    // Custom Header Code
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'custom_header_code',
        'label'    => esc_html__('Custom Header Code', 'affirmed-theme'),
        'section'  => 'affirmed_advanced_settings',
        'default'  => '',
        'priority' => 20,
    ));

    // Custom Footer Code
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'custom_footer_code',
        'label'    => esc_html__('Custom Footer Code', 'affirmed-theme'),
        'section'  => 'affirmed_advanced_settings',
        'default'  => '',
        'priority' => 30,
    ));

    // Enable/Disable Features
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'toggle',
        'settings' => 'enable_animations',
        'label'    => esc_html__('Enable Scroll Animations', 'affirmed-theme'),
        'section'  => 'affirmed_advanced_settings',
        'default'  => true,
        'priority' => 40,
    ));

    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'toggle',
        'settings' => 'enable_back_to_top',
        'label'    => esc_html__('Enable Back to Top Button', 'affirmed-theme'),
        'section'  => 'affirmed_advanced_settings',
        'default'  => true,
        'priority' => 50,
    ));
}
add_action('after_setup_theme', 'affirmed_add_customizer_sections');med_theme_options[show_testimonials]',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    // Dynamic Testimonials
    $default_testimonials = array(
        1 => array(
            'name' => 'Andrea Johnson',
            'title' => 'www.templetraining.net',
            'content' => 'To have a good day, I believe it begins the night before. Learning bedtime affirmations was a tremendous help in getting a good night\'s sleep and setting up my mind to have a good day. Every night I affirm, \'By God\'s grace, I release myself from all negative energy, thoughts, and feelings. I declare I will have sweet sleep.\'',
            'image' => 'Andrea-Johnson.jpg'
        ),
        2 => array(
            'name' => 'Pastor Cory J. Lanier',
            'title' => 'Executive Pastor',
            'content' => 'There\'s a picture on my office wall with Philippians 4:8 written out underscored by the statement \'What we feed grows and what we starve dies!\' My dear brother, Tony Ray Smith supplies us with a tool to challenge and help us to take an honest inventory of our lives and affirm positive change.',
            'image' => 'Pastor-Cory.jpg'
        ),
        3 => array(
            'name' => 'Will Cravens',
            'title' => 'Author, 99 for 1',
            'content' => 'In these days riddled with a worldwide pandemic, constant political tensions and news channels filled with negative messages, it\'s difficult to know where to turn for inspiration. Pastor Tony has taken the time to compile a book filled with affirmations designed to lift your spirit.',
            'image' => 'Will-Cravens.jpg'
        )
    );

    for ($i = 1; $i <= 6; $i++) {
        $default_data = isset($default_testimonials[$i]) ? $default_testimonials[$i] : array(
            'name' => "Person {$i}",
            'title' => "Title {$i}",
            'content' => "Testimonial content {$i} goes here.",
            'image' => "testimonial{$i}.jpg"
        );

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'custom',
            'settings' => "testimonial{$i}_divider",
            'section'  => 'testimonials_section',
            'default'  => '<div style="padding: 20px 0; border-top: 1px solid #ddd; margin-top: 20px;"><h3 style="margin: 0; color: #333;">Testimonial ' . $i . '</h3></div>',
            'priority' => 30 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'image',
            'settings' => "testimonial{$i}_image",
            'label'    => esc_html__("Testimonial {$i} Image", 'affirmed-theme'),
            'section'  => 'testimonials_section',
            'default'  => get_template_directory_uri() . '/assets/img/' . $default_data['image'],
            'priority' => 31 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'text',
            'settings' => "testimonial{$i}_name",
            'label'    => esc_html__("Testimonial {$i} Name", 'affirmed-theme'),
            'section'  => 'testimonials_section',
            'default'  => $default_data['name'],
            'priority' => 32 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'text',
            'settings' => "testimonial{$i}_title",
            'label'    => esc_html__("Testimonial {$i} Title/Position", 'affirmed-theme'),
            'section'  => 'testimonials_section',
            'default'  => $default_data['title'],
            'priority' => 33 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'textarea',
            'settings' => "testimonial{$i}_content",
            'label'    => esc_html__("Testimonial {$i} Content", 'affirmed-theme'),
            'section'  => 'testimonials_section',
            'default'  => $default_data['content'],
            'priority' => 34 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_testimonials]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[testimonials_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));
    }

    // =============================================================================
    // FAQ SECTION (Dynamic)
    // =============================================================================
    
    Kirki::add_section('faq_section', array(
        'title'    => esc_html__('FAQ Section', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 65,
    ));

    // FAQ Title
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'faq_title',
        'label'    => esc_html__('FAQ Section Title', 'affirmed-theme'),
        'section'  => 'faq_section',
        'default'  => 'Frequently Asked Questions',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Show/Hide FAQ
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'toggle',
        'settings' => 'show_faq',
        'label'    => esc_html__('Show FAQ Section', 'affirmed-theme'),
        'section'  => 'faq_section',
        'default'  => true,
        'priority' => 20,
    ));

    // Number of FAQ Items
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'slider',
        'settings' => 'faq_count',
        'label'    => esc_html__('Number of FAQ Items', 'affirmed-theme'),
        'section'  => 'faq_section',
        'default'  => 5,
        'priority' => 30,
        'choices'  => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ),
        'active_callback' => array(
            array(
                'setting'  => 'affirmed_theme_options[show_faq]',
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));

    // Default FAQ Items
    $default_faqs = array(
        1 => array(
            'question' => 'Can I buy this book in stores?',
            'answer' => 'No. "Affirmed" is available only through our store and Amazon.'
        ),
        2 => array(
            'question' => 'Do you have a refund policy?',
            'answer' => 'Yes! If you are not 100% satisfied with your purchase, just reach out to our customer experience team within 30 days of your purchase. You will receive a full refund.'
        ),
        3 => array(
            'question' => 'When will I receive my book?',
            'answer' => 'You can expect to receive your book 5 - 7 business days after purchase. Shipping and delivery times vary depending on your location.'
        ),
        4 => array(
            'question' => 'Do you offer any discounts for purchasing more than one book?',
            'answer' => 'Yes! We offer discount pricing with every purchase of five or more books. Please contact our customer support team for assistance with discount purchasing.'
        ),
        5 => array(
            'question' => 'I have another question. Can I get some assistance?',
            'answer' => 'Absolutely! Our customer support team is waiting and ready to help. Just email us, and we\'ll take care of you.'
        )
    );

    // Dynamic FAQ Items
    for ($i = 1; $i <= 10; $i++) {
        $default_data = isset($default_faqs[$i]) ? $default_faqs[$i] : array(
            'question' => "FAQ Question {$i}?",
            'answer' => "FAQ Answer {$i} goes here."
        );

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'custom',
            'settings' => "faq{$i}_divider",
            'section'  => 'faq_section',
            'default'  => '<div style="padding: 20px 0; border-top: 1px solid #ddd; margin-top: 20px;"><h3 style="margin: 0; color: #333;">FAQ ' . $i . '</h3></div>',
            'priority' => 30 + ($i * 10),
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_faq]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[faq_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'text',
            'settings' => "faq{$i}_question",
            'label'    => esc_html__("FAQ {$i} Question", 'affirmed-theme'),
            'section'  => 'faq_section',
            'default'  => $default_data['question'],
            'priority' => 31 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_faq]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[faq_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));

        Kirki::add_field('affirmed_theme_config', array(
            'type'     => 'textarea',
            'settings' => "faq{$i}_answer",
            'label'    => esc_html__("FAQ {$i} Answer", 'affirmed-theme'),
            'section'  => 'faq_section',
            'default'  => $default_data['answer'],
            'priority' => 32 + ($i * 10),
            'transport' => 'postMessage',
            'active_callback' => array(
                array(
                    'setting'  => 'affirmed_theme_options[show_faq]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'affirmed_theme_options[faq_count]',
                    'operator' => '>=',
                    'value'    => $i,
                ),
            ),
        ));
    }'type'     => 'text',
        'settings' => 'testimonials_title',
        'label'    => esc_html__('Testimonials Section Title', 'affirmed-theme'),
        'section'  => 'testimonials_section',
        'default'  => 'Praise For "Affirmed"',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Show/Hide Testimonials
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'toggle',
        'settings' => 'show_testimonials',
        'label'    => esc_html__('Show Testimonials Section', 'affirmed-theme'),
        'section'  => 'testimonials_section',
        'default'  => true,
        'priority' => 20,
    ));

    // =============================================================================
    // CONTACT SECTION
    // =============================================================================
    
    Kirki::add_section('contact_section', array(
        'title'    => esc_html__('Contact Information', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 70,
    ));

    // Phone Number
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'contact_phone',
        'label'    => esc_html__('Phone Number', 'affirmed-theme'),
        'section'  => 'contact_section',
        'default'  => '703.957.0529',
        'priority' => 10,
        'transport' => 'postMessage',
    ));

    // Email Address
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'email',
        'settings' => 'contact_email',
        'label'    => esc_html__('Email Address', 'affirmed-theme'),
        'section'  => 'contact_section',
        'default'  => 'cs@tonyraysmith.com',
        'priority' => 20,
        'transport' => 'postMessage',
    ));

    // Office Hours
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'office_hours',
        'label'    => esc_html__('Office Hours', 'affirmed-theme'),
        'section'  => 'contact_section',
        'default'  => 'Monday to Saturday 9 AM - 6 PM',
        'priority' => 30,
        'transport' => 'postMessage',
    ));

    // Copyright Text
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'text',
        'settings' => 'copyright_text',
        'label'    => esc_html__('Copyright Text', 'affirmed-theme'),
        'section'  => 'contact_section',
        'default'  => 'Tony Ray Smith Enterprises, LLC | Copyright ©2021 | All Rights Reserved',
        'priority' => 40,
        'transport' => 'postMessage',
    ));

    // =============================================================================
    // COLORS & STYLING
    // =============================================================================
    
    Kirki::add_section('colors_styling', array(
        'title'    => esc_html__('Colors & Styling', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 80,
    ));

    // Primary Button Color
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'color',
        'settings' => 'primary_button_color',
        'label'    => esc_html__('Primary Button Color', 'affirmed-theme'),
        'section'  => 'colors_styling',
        'default'  => '#06b6d4',
        'priority' => 10,
        'output'   => array(
            array(
                'element'  => '.btn-primary',
                'property' => 'background-color',
            ),
        ),
    ));

    // Success Button Color
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'color',
        'settings' => 'success_button_color',
        'label'    => esc_html__('Success Button Color', 'affirmed-theme'),
        'section'  => 'colors_styling',
        'default'  => '#10b981',
        'priority' => 20,
        'output'   => array(
            array(
                'element'  => '.btn-success',
                'property' => 'background-color',
            ),
        ),
    ));

    // Accent Color
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'color',
        'settings' => 'accent_color',
        'label'    => esc_html__('Accent Color', 'affirmed-theme'),
        'section'  => 'colors_styling',
        'default'  => '#fbbf24',
        'priority' => 30,
        'output'   => array(
            array(
                'element'  => '.features-title, .footer-brand',
                'property' => 'color',
            ),
        ),
    ));

    // Custom CSS
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'code',
        'settings' => 'custom_css',
        'label'    => esc_html__('Custom CSS', 'affirmed-theme'),
        'section'  => 'colors_styling',
        'default'  => '',
        'priority' => 40,
        'choices'  => array(
            'language' => 'css',
        ),
    ));

    // =============================================================================
    // ADVANCED SETTINGS
    // =============================================================================
    
    Kirki::add_section('advanced_settings', array(
        'title'    => esc_html__('Advanced Settings', 'affirmed-theme'),
        'panel'    => 'affirmed_theme_panel',
        'priority' => 90,
    ));

    // Google Analytics Code
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'google_analytics',
        'label'    => esc_html__('Google Analytics Code', 'affirmed-theme'),
        'section'  => 'advanced_settings',
        'default'  => '',
        'priority' => 10,
    ));

    // Custom Header Code
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'custom_header_code',
        'label'    => esc_html__('Custom Header Code', 'affirmed-theme'),
        'section'  => 'advanced_settings',
        'default'  => '',
        'priority' => 20,
    ));

    // Custom Footer Code
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'textarea',
        'settings' => 'custom_footer_code',
        'label'    => esc_html__('Custom Footer Code', 'affirmed-theme'),
        'section'  => 'advanced_settings',
        'default'  => '',
        'priority' => 30,
    ));

    // Enable/Disable Features
    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'toggle',
        'settings' => 'enable_animations',
        'label'    => esc_html__('Enable Scroll Animations', 'affirmed-theme'),
        'section'  => 'advanced_settings',
        'default'  => true,
        'priority' => 40,
    ));

    Kirki::add_field('affirmed_theme_config', array(
        'type'     => 'toggle',
        'settings' => 'enable_back_to_top',
        'label'    => esc_html__('Enable Back to Top Button', 'affirmed-theme'),
        'section'  => 'advanced_settings',
        'default'  => true,
        'priority' => 50,
    ));
}
add_action('init', 'affirmed_add_customizer_sections');

/**
 * Helper function to get theme options with fallback
 */
function affirmed_get_option($option, $default = '') {
    $options = get_theme_mod('affirmed_theme_options', array());
    
    if (isset($options[$option])) {
        return $options[$option];
    }
    
    // Fallback to individual theme_mod for backward compatibility
    return get_theme_mod($option, $default);
}

/**
 * Enqueue Customizer CSS
 */
function affirmed_customizer_css() {
    $custom_css = affirmed_get_option('custom_css', '');
    
    if (!empty($custom_css)) {
        wp_add_inline_style('affirmed-style', $custom_css);
    }
}
add_action('wp_enqueue_scripts', 'affirmed_customizer_css');

/**
 * Add Custom Header/Footer Code
 */
function affirmed_custom_header_code() {
    $header_code = affirmed_get_option('custom_header_code', '');
    $analytics = affirmed_get_option('google_analytics', '');
    
    if (!empty($header_code)) {
        echo $header_code;
    }
    
    if (!empty($analytics)) {
        echo $analytics;
    }
}
add_action('wp_head', 'affirmed_custom_header_code');

function affirmed_custom_footer_code() {
    $footer_code = affirmed_get_option('custom_footer_code', '');
    
    if (!empty($footer_code)) {
        echo $footer_code;
    }
}
add_action('wp_footer', 'affirmed_custom_footer_code');

/**
 * Customizer Live Preview JavaScript
 */
function affirmed_customize_preview_js() {
    wp_enqueue_script(
        'affirmed-customizer-preview',
        get_template_directory_uri() . '/js/customizer-preview.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'affirmed_customize_preview_js');