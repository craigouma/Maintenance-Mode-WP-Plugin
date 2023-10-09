<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Maintenance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            padding: 50px;
        }
        .maintenance-message {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<div class="maintenance-message">
    <?php
    // Get the custom maintenance message from the options
    $maintenance_mode_message = get_option('maintenance_mode_message', 'We are currently undergoing maintenance. Please check back later.');

    // Allow shortcodes in the maintenance message
    echo do_shortcode(wp_kses_post($maintenance_mode_message));
    ?>
</div>
</body>
</html>
