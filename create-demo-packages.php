<?php
/**
 * Create Demo Packages
 * Run this file once to create demo package posts
 *
 * To run: Visit yoursite.com/wp-content/themes/yacht-rental/create-demo-packages.php
 * Or run via WP-CLI: wp eval-file create-demo-packages.php
 */

// Load WordPress
require_once('../../../wp-load.php');

// Check if user is logged in and is admin
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    die('Unauthorized access');
}

// Demo packages data
$packages = array(
    array(
        'title' => 'Yacht Birthday Party Dubai',
        'content' => 'Want the coolest yacht birthday party Dubai has to offer? Instead of the regular restaurant celebrations – imagine blowing out candles while cruising past Dubai\'s iconic skyline! Our birthday yacht rental Dubai packages turn your special day into a memory you won\'t forget.',
        'package_title' => 'Choose Your Birthday Yacht Rental Dubai Package',
        'features' => "Included in a package
3hr+ luxury yacht cruise
Yacht beautifully decorated with balloons
Birthday cake with a personalized message
Red carpet welcome & welcome drinks
Water, ice and soft drinks
Add-ons
Fine-dinning catering from 5-star restaurants
DJ, premium sound system, and disco lighting onboard
Photographer, videographer, drone shooting",
        'whatsapp_number' => '+971501234567',
        'image_url' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?q=80&w=1200'
    ),
    array(
        'title' => 'Corporate Event Yacht Rental Dubai',
        'content' => 'Elevate your corporate events with a luxury yacht experience in Dubai. Perfect for team building, client entertainment, or company celebrations. Impress your guests with stunning views and professional service.',
        'package_title' => 'Premium Corporate Event Packages',
        'features' => "Included in package
4hr+ private yacht charter
Professional crew and captain
Conference setup with AV equipment
Complimentary beverages and snacks
Wi-Fi connectivity
Optional add-ons
Gourmet catering from premium restaurants
Professional photographer for corporate shots
Branding and custom decorations
Live entertainment or DJ services",
        'whatsapp_number' => '+971501234567',
        'image_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1200'
    ),
    array(
        'title' => 'Marina Parking & Yacht Storage Dubai',
        'content' => 'Secure, convenient marina parking solutions for yacht owners in Dubai. Premium berth locations with 24/7 security, maintenance services, and easy access to Dubai\'s beautiful waters.',
        'package_title' => 'Flexible Marina Parking Solutions',
        'features' => "Included in service
Secure berth in premium marina location
24/7 security and surveillance
Fresh water and electricity hookup
Waste disposal services
Access to marina facilities
Additional services
Regular cleaning and maintenance
Fueling services
Crew assistance
Concierge services
Winter storage options",
        'whatsapp_number' => '+971501234567',
        'image_url' => 'https://images.unsplash.com/photo-1540946485063-a40da27545f8?q=80&w=1200'
    ),
    array(
        'title' => 'New Year Party Yacht Dubai',
        'content' => 'Ring in the New Year with Dubai\'s most spectacular yacht party! Watch the fireworks from the best seat in the house while cruising past iconic landmarks. Create unforgettable memories as you celebrate on the water.',
        'package_title' => 'Exclusive New Year Yacht Celebration',
        'features' => "Included in package
5hr+ premium yacht charter
Prime viewing position for fireworks
Champagne toast at midnight
Elegant New Year decorations
Red carpet welcome
Premium sound system with DJ
Unlimited soft drinks and water
Special add-ons
5-star gourmet dinner menu
Premium bar package
Professional photography and videography
Live band or entertainment",
        'whatsapp_number' => '+971501234567',
        'image_url' => 'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?q=80&w=1200'
    ),
    array(
        'title' => 'Romantic Proposal Yacht Package Dubai',
        'content' => 'Pop the question in the most romantic setting Dubai has to offer. Our proposal packages create the perfect intimate atmosphere for your special moment, complete with stunning sunset views and luxurious touches.',
        'package_title' => 'Create Your Perfect Proposal Moment',
        'features' => "Included in package
2-3hr private yacht charter
Romantic decorations with roses and candles
Champagne and chocolate-covered strawberries
Professional photographer to capture the moment
Sunset cruise timing
Privacy and exclusivity
Luxury add-ons
Violinist or live musician
Gourmet dinner setup
Custom floral arrangements
Engagement cake
Fireworks display",
        'whatsapp_number' => '+971501234567',
        'image_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1200'
    )
);

echo "<h1>Creating Demo Packages...</h1>";

foreach ($packages as $index => $package_data) {
    // Create the post
    $post_id = wp_insert_post(array(
        'post_title'    => $package_data['title'],
        'post_content'  => $package_data['content'],
        'post_status'   => 'publish',
        'post_type'     => 'cpt_packages',
        'post_author'   => get_current_user_id(),
    ));

    if (is_wp_error($post_id)) {
        echo "<p style='color:red;'>Error creating package: " . $package_data['title'] . "</p>";
        continue;
    }

    // Add custom meta fields
    update_post_meta($post_id, '_package_title', $package_data['package_title']);
    update_post_meta($post_id, '_package_features', $package_data['features']);
    update_post_meta($post_id, '_whatsapp_number', $package_data['whatsapp_number']);

    // Download and set featured image
    $image_url = $package_data['image_url'];
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);

    if ($image_data) {
        $filename = basename($image_url);
        $filename = 'package-' . ($index + 1) . '-' . time() . '.jpg';

        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }

        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($post_id, $attach_id);
    }

    echo "<p style='color:green;'>✓ Created: <strong>" . $package_data['title'] . "</strong> (ID: $post_id)</p>";
}

echo "<h2>Done! All demo packages created successfully.</h2>";
echo "<p><a href='" . admin_url('edit.php?post_type=cpt_packages') . "'>View Packages in Admin</a></p>";
echo "<p style='color:red;'><strong>Important:</strong> Delete this file (create-demo-packages.php) after running it for security reasons.</p>";
