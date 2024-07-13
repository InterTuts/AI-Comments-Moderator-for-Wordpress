<?php
/*
Class: Main Page
Description: This class is used to create the main page in the administrator panel with all settings.
Version: 1.0
Author: Sirbu Ruslan
Author URI: https://github.com/InterTuts
*/

/**
 * Main Page
 */
class MainPage {

    /**
     * Class Constructor
     */
	public function __construct() {

        // Create the page with settings
		add_action('cmb2_admin_init', array( $this, 'createPage' ) );
	}

    /**
     * Method used to create the administrator page
     */
    public function createPage(): void {

        // First of all will be created the page
        $cmb = new_cmb2_box(array(
            'id'           => 'ai_comments_moderator_metabox',
            'title'        => __('AI Comments Moderator', 'ai_comments_moderator'),
            'object_types' => array('options-page'),
            'option_key'   => 'ai_comments_moderator_options',
        ));

        // Then should be created the field for API Key
        $cmb->add_field(array(
            'name'        => __('Gemini API Key', 'ai_comments_moderator'),
            'desc'        => __('Enter your Gemini API Key here.', 'ai_comments_moderator'),
            'id'          => 'ai_comments_moderator_gemini_api_key',
            'type'        => 'text',
        ));

        // Finally create the field for moderation rules
        $cmb->add_field(array(
            'name'        => __('Remove Rules', 'ai_comments_moderator'),
            'desc'        => __('Enter the rules for the comments content which should be removed.', 'ai_comments_moderator'),
            'id'          => 'ai_comments_moderator_conditions',
            'type'        => 'textarea',
        ));

    }

}