<?php
/*
Class: Moderator
Description: This class is used to catch the new comments and moderate them
Version: 1.0
Author: Sirbu Ruslan
Author URI: https://github.com/InterTuts
*/

/**
 * Moderator
 */
class Moderator {

    // Generative Language Model
    private string $model = 'gemini-1.5-flash-latest';

    // Generative Language URL
    private string $gl;

    /**
     * Class Constructor
     */
	public function __construct() {

        // Prepare the Generative Language URL
        $this->gl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";

        // Create the page with settings
		add_action('comment_post', array( $this, 'processComment' ), 10, 3);

	}

    /**
     * Process New Comments
     * 
     * @param int $comment_id
     * @param int|string $comment_approved
     * @param array $comment_data
     */
    public function processComment($comment_id, $comment_approved, $comment_data): void {

        // Get the moderator options
        $moderator_options = get_option('ai_comments_moderator_options');
        
        // Check if moderator options exists
        if ( !empty($moderator_options['ai_comments_moderator_gemini_api_key']) && !empty($moderator_options['ai_comments_moderator_conditions']) ) {

            // Get the comment content
            $comment_content = $comment_data['comment_content'];

            // Moderation rules
            $rules = $moderator_options['ai_comments_moderator_conditions'];
            
            // Prepare the body data
            $body = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => "Analyze this text \"{$comment_content}\" and tell me with Yes or No if it meets the rules described here \"{$rules}\""
                            ]
                        ]
                    ]
                ]
            ];
            
            // Request arguments
            $args = array(
                'body'        => json_encode($body),
                'headers'     => array(
                    'Content-Type' => 'application/json',
                ),
                'method'      => 'POST',
                'data_format' => 'body',
            );
            
            // Send the request
            $response = wp_remote_post($this->gl . '?key=' . $moderator_options['ai_comments_moderator_gemini_api_key'], $args);

            // Check if no errors occurred
            if (!is_wp_error($response)) {

                // Retrieve the body
                $body = wp_remote_retrieve_body($response);

                // Get the body data from the json
                $data = json_decode($body, true);
                
                // Process the response
                if (isset($data['candidates'][0]['output']) && ($data['candidates'][0]['output'] === 'Yes')) {
                    // Move comment to spam
                    wp_set_comment_status($comment_id, 'spam');
                }

            }

        }

    }

}