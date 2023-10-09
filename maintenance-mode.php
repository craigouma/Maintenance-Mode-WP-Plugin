<?php

/*
Plugin Name: Maintenance Mode Plugin
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Displays a maintenance page to visitors when the site is undergoing updates. Users can customize the message.
Version: 1.0
Author: CRAIG
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

// Enqueue the CSS for styling the maintenance page.
function maintenance_mode_enqueue_styles() {
    wp_enqueue_style('maintenance-style', plugin_dir_url(__FILE__) . 'maintenance-style.css');
}
add_action('wp_enqueue_scripts', 'maintenance_mode_enqueue_styles');

// Add a menu item to the admin menu.
function maintenance_mode_menu() {
    add_menu_page('Maintenance Mode', 'Maintenance Mode', 'manage_options', 'maintenance-mode-settings', 'maintenance_mode_settings_page');
}
add_action('admin_menu', 'maintenance_mode_menu');

// Callback function for the settings page.
function maintenance_mode_settings_page() {
    if (isset($_POST['maintenance_mode_toggle'])) {
        update_option('maintenance_mode_enabled', $_POST['maintenance_mode_enabled']);
        update_option('maintenance_mode_message', $_POST['maintenance_mode_message']);
        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    $maintenance_mode_enabled = get_option('maintenance_mode_enabled', false);
    $maintenance_mode_message = get_option('maintenance_mode_message', 'We are currently undergoing maintenance. Please check back later.');

    echo '<div class="wrap">';
    echo '<h2>Maintenance Mode Settings</h2>';
    echo '<form method="post" action="">';
    echo '<label for="maintenance_mode_enabled">Enable Maintenance Mode:</label>';
    echo '<input type="checkbox" id="maintenance_mode_enabled" name="maintenance_mode_enabled" value="1" ' . checked(1, $maintenance_mode_enabled, false) . '>';
    echo '<br><br>';
    echo '<label for="maintenance_mode_message">Custom Message:</label>';
    echo '<textarea id="maintenance_mode_message" name="maintenance_mode_message" rows="4" cols="50">' . esc_textarea($maintenance_mode_message) . '</textarea>';
    echo '<br><br>';
    echo '<input type="submit" name="maintenance_mode_toggle" class="button-primary" value="Save Settings">';
    echo '</form>';
    echo '</div>';
}

// Check if maintenance mode is enabled and display the maintenance page.
function maintenance_mode_check() {
    $maintenance_mode_enabled = get_option('maintenance_mode_enabled', false);
    if ($maintenance_mode_enabled && !current_user_can('manage_options')) {
        include(plugin_dir_path(__FILE__) . 'maintenance-page.php');
        exit;
    }
}
add_action('template_redirect', 'maintenance_mode_check');
