<?php

class CFP_Submission_Handler{
    function __construct(){
        add_action('admin_post_cfp_form_submit', [$this, 'handle_submission']);
        add_action('admin_post_nopriv_cfp_form_submit', [$this,'handle_submission']);
    }

function handle_submission() {
    // 1. verify nonce first
    if (!isset($_POST['cfp_nonce']) || !wp_verify_nonce($_POST['cfp_nonce'], 'cfp_form_nonce')) {
        wp_die('Security check failed (invalid nonce)');
    }

    // 2. validate
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cfp_submission'])) {

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);
        $form_id = sanitize_text_field($_POST['cfp_form_id']);

        $errors = [];

        if (empty($name))  $errors[] = "Name is required.";
        if (!is_email($email)) $errors[] = "Invalid email address.";
        if (empty($message)) $errors[] = "Message is required.";

        if (!empty($errors)) {
            $redirect_url = add_query_arg(['cfp_error' => urlencode(implode(', ', $errors)),], wp_get_referer());
            wp_redirect($redirect_url);
            exit;

        }
        // create CPT entry
        $subject = 'contact form submission from ' . $name;
        $body = "Name: $name\nEmail: $email\nSubject: $subject\nMassage: $message\nForm ID: $form_id";
        $post_id = wp_insert_post([
            'post_title'   => "Submission from {$name}",
            'post_content' => $body,
            'post_status'  => 'private',
            'post_type'    => 'cfp_submission'
        ]);

        if ($post_id) {
            update_post_meta($post_id, 'submitter_name', $name);
            update_post_meta($post_id, 'submitter_email', $email);
            update_post_meta($post_id,'form_subject',$subject);
            update_post_meta($post_id, 'submitter_message', $message);
            update_post_meta($post_id, 'form_id', $form_id);

            // redirect after success
            $redirect_url = add_query_arg(['cfp_success' => '1'], wp_get_referer());

            wp_redirect($redirect_url);
            exit;

            
        } else {
            wp_die("Failed to save submission.");
        }
    }
}

}