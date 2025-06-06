# Affirmed WordPress Theme

A responsive one-page landing page WordPress theme designed for books, personal development content, and similar products. Built with Kirki Customizer Framework for easy content management.

## Features

- **One-Page Design**: Perfect for landing pages and product showcases
- **Fully Responsive**: Works seamlessly on desktop, tablet, and mobile devices
- **Kirki Customizer Integration**: Easy content management through WordPress Customizer
- **AJAX Form Handling**: Smooth form submission without page reload
- **SEO Optimized**: Clean, semantic HTML structure
- **Font Awesome Icons**: Beautiful icons throughout the design
- **Smooth Animations**: Engaging scroll animations and hover effects
- **Contact Form**: Built-in order/contact form with validation
- **Testimonials Section**: Showcase customer reviews
- **FAQ Section**: Answer common questions
- **Author Bio Section**: Highlight the author/creator
- **Features Showcase**: Highlight key product benefits

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Kirki Customizer Framework plugin (recommended)

## Installation Guide

### Step 1: Download and Install the Theme

1. **Download the theme files** and create a ZIP file containing all theme files
2. **Login to your WordPress admin dashboard**
3. **Navigate to Appearance > Themes**
4. **Click "Add New"** and then **"Upload Theme"**
5. **Choose the ZIP file** and click **"Install Now"**
6. **Activate the theme** once installation is complete

### Step 2: Install Required Plugin (Automatic)

The theme will automatically detect if Kirki Customizer Framework is missing and show an installation notice:

1. **Automatic Detection:** When you activate the theme, it will check for Kirki
2. **One-Click Installation:** Click the "Install Kirki Plugin" button in the admin notice
3. **Automatic Activation:** The plugin will be installed and activated automatically

**Manual Installation (if needed):**

- Go to **Plugins > Add New**
- Search for **"Kirki Customizer Framework"**
- Install and activate the plugin

_Note: The theme will work without Kirki using basic WordPress customizer, but you'll have limited options._

### Step 3: Set Up Your Content

1. **Go to Appearance > Customize**
2. **You'll see several new sections:**
   - Hero Section
   - Book Section
   - Author Section
   - Features Section
   - Sample Section
   - Contact Information

### Step 4: Upload Your Images

Create an `assets/img/` folder in your theme directory and upload the following images:

- Book cover image
- Author portrait
- Feature images (3 images)
- Testimonial images
- Any other promotional images

## Content Update Guide

### Updating Text Content

1. **Login to WordPress Admin**
2. **Go to Appearance > Customize**
3. **Select the section you want to edit:**

#### Hero Section

- **Hero Title**: Main headline text
- **Hero Subtitle**: Secondary headline text
- **Hero Background Color**: Background color picker

#### Book Section

- **Book Cover Image**: Upload your book cover
- **Book Section Title**: Title for the book description area
- **Book Description**: Main book description text

#### Author Section

- **Author Name**: Full name of the author
- **Author Image**: Upload author photo
- **Author Bio**: Biography text

#### Features Section

- **Features Section Title**: Main title for features area
- **Feature 1-3 Images**: Upload feature images
- **Feature 1-3 Titles**: Individual feature titles
- **Feature 1-3 Descriptions**: Feature description text

#### Sample Section

- **Sample Title**: Title for the sample content
- **Sample Content**: Sample text/affirmation content

#### Contact Information

- **Phone Number**: Contact phone number
- **Email Address**: Contact email
- **Copyright Text**: Footer copyright text

### Updating Images

1. **Prepare your images:**

   - **Book Cover**: 400x600px (recommended)
   - **Author Portrait**: 256x320px (recommended)
   - **Feature Images**: 400x300px (recommended)
   - **Testimonial Images**: 128x128px (recommended)

2. **Upload through Customizer:**
   - Go to the relevant section in Customizer
   - Click on the image field
   - Upload new image or select from Media Library
   - Click "Publish" to save changes

### Adding/Editing Testimonials

Testimonials are currently hardcoded in the theme. To modify them:

1. **Edit the `index.php` file**
2. **Find the "Testimonials Section"**
3. **Update the testimonial content, images, and author information**

### Customizing Colors and Styling

1. **Go to Appearance > Customize > Additional CSS**
2. **Add custom CSS to override theme styles**

Example custom CSS:

```css
/* Change button colors */
.btn-primary {
  background-color: #your-color;
}

/* Modify hero section */
.hero-section {
  background: linear-gradient(135deg, #your-color1, #your-color2);
}

/* Customize fonts */
body {
  font-family: "Your Font", sans-serif;
}
```

### Form Configuration

The contact form is handled via AJAX. To integrate with a payment processor or email service:

1. **Edit `functions.php`**
2. **Find the `affirmed_handle_form_submission` function**
3. **Add your integration code** (payment processor, email service, etc.)

Example integration:

```php
function affirmed_handle_form_submission() {
    // Your custom form handling code here
    // Integration with payment processors, email services, etc.
}
```

## Customization Options

### Available Customizer Sections

- **Hero Section**: Main banner content and styling
- **Book Section**: Product/book information and images
- **Author Section**: Author biography and photo
- **Features Section**: Product features and benefits
- **Sample Section**: Sample content or excerpts
- **Contact Information**: Contact details and footer content

### Custom Post Types (Optional)

You can extend the theme by adding custom post types for:

- Testimonials
- FAQ items
- Features
- Team members

### Widget Areas

The theme includes a footer widget area where you can add:

- Social media links
- Additional contact information
- Newsletter signup
- Custom content

## Troubleshooting

### Common Issues

**1. Customizer Options Not Showing**

- Ensure Kirki plugin is installed and activated
- Check for plugin conflicts
- Clear any caching plugins

**2. Images Not Displaying**

- Check file paths in the customizer
- Ensure images are uploaded to the correct directory
- Verify image file permissions

**3. Form Not Working**

- Check JavaScript console for errors
- Ensure AJAX is properly configured
- Verify nonce security tokens

**4. Mobile Responsiveness Issues**

- Clear browser cache
- Test on actual devices
- Check for conflicting CSS

### Performance Optimization

1. **Optimize Images**: Use compressed images (WebP format recommended)
2. **Enable Caching**: Use a caching plugin
3. **Minify CSS/JS**: Use optimization plugins
4. **CDN**: Consider using a Content Delivery Network

## Support

For theme support and customization help:

- Check WordPress.org documentation
- Review theme files for inline comments
- Test with default WordPress themes to isolate issues

## File Structure

```
affirmed-theme/
├── style.css (Main stylesheet with theme information)
├── index.php (Main template file)
├── header.php (Header template)
├── footer.php (Footer template)
├── functions.php (Theme functions and Kirki setup)
├── js/
│   └── script.js (JavaScript functionality)
├── assets/
│   └── img/ (Theme images - create this folder)
├── inc/ (Include files - for future extensions)
└── README.md (This file)
```

## License

This theme is licensed under the GPL v2 or later.

## Changelog

### Version 1.0

- Initial release
- Kirki Customizer integration
- Responsive design
- AJAX form handling
- SEO optimization
