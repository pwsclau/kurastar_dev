<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

    // This gets the theme name from the stylesheet (lowercase and without spaces)
    $themename = get_option( 'stylesheet' );
    $themename = preg_replace("/\W/", "_", strtolower($themename) );

    $optionsframework_settings = get_option('optionsframework');
    $optionsframework_settings['id'] = $themename;
    update_option('optionsframework', $optionsframework_settings);

    // echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

    $options = array();

    // Footer Social Media Tab
    $options[] = array(
        'name' => __('Footer Social Media', 'options_check'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Facebook Link', 'options_check'),
        'desc' => __('', 'options_check'),
        'id' => 'facebook_link',
        'type' => 'text');
    $options[] = array(
        'name' => __('Twitter Link', 'options_check'),
        'desc' => __('', 'options_check'),
        'id' => 'twitter_link',
        'type' => 'text');
    $options[] = array(
        'name' => __('Google Plus Link', 'options_check'),
        'desc' => __('', 'options_check'),
        'id' => 'google_plus_link',
        'type' => 'text');
    $options[] = array(
        'name' => __('Hatena Link', 'options_check'),
        'desc' => __('', 'options_check'),
        'id' => 'hatena_link',
        'type' => 'text');

    // Ads Tab
    $options[] = array(
        'name' => __('Ads', 'options_check'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Right Sidebar Ad Url', 'options_check'),
        'desc' => __('Upload the image of the Ad.', 'options_check'),
        'id' => 'right_sidebar_ad',
        'type' => 'upload');

    return $options;
}

/*
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */

if ( !function_exists( 'of_get_option' ) ) {
    function of_get_option($name, $default = false) {

        $optionsframework_settings = get_option('optionsframework');

        // Gets the unique option id
        $option_name = $optionsframework_settings['id'];

        if ( get_option($option_name) ) {
            $options = get_option($option_name);
        }

        if ( isset($options[$name]) ) {
            return $options[$name];
        } else {
            return $default;
        }
    }
}