<?php
/*
Plugin Name: AI Comments Moderator
Plugin URI: https://github.com/InterTuts/AI-Comments-Moderator-for-Wordpress
Description: A simple Wordpress plugin used to auto moderate the Wordpress comments using AI. This plugin uses the Gemini API to moderate the new created comments.
Version: 1.0
Author: Sirbu Ruslan
Author URI: https://github.com/InterTuts
License: GPL2
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Require CMB2 for UI
if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/cmb2/init.php';
}

/**
 * include the admin files only if in the admin area
 */
if ( is_admin() ) {
    
    // Request the class for Main administrator page
    require_once( dirname( __FILE__ ) . '/admin/pages/MainPage.php' );

    // Initiate the class
    new MainPage();

} else {

    // Request the class for Moderator class
    require_once( dirname( __FILE__ ) . '/comments/Moderator.php' );

    // Initiate the class
    new Moderator();

}