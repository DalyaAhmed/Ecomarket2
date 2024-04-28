<?php

// For admin settings
if (!is_admin()) {
    return;
}

// Function to add a submenu page under the "Settings" menu in the admin dashboard.
function mytheme_add_settings() {
    add_submenu_page(
        "options-general.php",
        "Butik",
        "Butik",
        "edit_pages",
        "butik",
        "mytheme_add_setting_callback"
    );
}

// Function to render the settings page content.
function mytheme_add_setting_callback() {
    ?>
    <div class="wrap">
        <h2>Butiksinställningar</h2>
        <form action="options.php" method="post">
            <?php
            // Ensure consistency by using the same option group in settings_fields as in register_setting
            settings_fields("butik_options");
            do_settings_sections("butik");
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Add action to create settings page
add_action('admin_menu', 'mytheme_add_settings');

// Add action to initialize settings
add_action('admin_init', 'mytheme_add_settings_init');

// Function to initialize settings
function mytheme_add_settings_init() {
    // Add section for general settings
    add_settings_section(
        'butik_general',
        'General',
        'mytheme_add_settings_section_general',
        'butik'
    );

    // Add setting for Store Message - Placed at the top
    add_settings_field(
        "store_message",           //id
        "Store Message",           //title(will be shown on setting-butik page)
        "mytheme_section_setting", //callback function
        "butik",                   //page
        "butik_general",           //section
        array(                     //multiple parameter
            "option_name" => "store_message",
            "option_type" => "text"
        )
    );

    // Add setting for other fields here if needed

    // Register settings
    register_setting(
        "butik_options",  // This is the option group
        "store_message"
    );
}

// Function to display description for general settings section
function mytheme_add_settings_section_general() {
    echo "<p>Generella inställningar för butiken</p>";
}

// Function to display settings field
function mytheme_section_setting($args) {
    $option_name = $args["option_name"];
    $option_type = $args["option_type"];
    $option_value = get_option($args["option_name"]);

    echo '<input type="' . $option_type .'" 
                 id="' . $option_name . '" 
                 name="' . $option_name . '" 
                 value="'. $option_value. '"
          />';
}
