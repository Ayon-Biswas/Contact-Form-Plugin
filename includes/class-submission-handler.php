<?php

class CFP_Submission_Handler{
    function __construct(){
        add_action('admin_post_cfp_form_submit', [$this, 'handle_submission']);
        add_action('admin_post_nopriv_cfp_form_submit', [$this,'handle_submission']);
    }
//     function handle_submission(){
//           //verify nonce
//      if( !isset($_POST['cfp_nonce']) || !wp_verify_nonce($_POST['cfp_nonce'], 'cfp_form_nonce') ){
//         wp_die('Security check failed (invalid nonce)');
//      }

//         //form input validation
//     if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['cfp_submission']) && $_POST['cfp_submission'] == 'Submit') {
//     //if server gives error we wont "echo" values. If there is no error we will "echo" the values
//      $status = false;
//       if(!is_string($_POST['name'])){
//         echo "Error: Name must be a string";
//         $status = true;
//       }
//       if(!is_email($_POST['email'])){
//         echo "Error: Email must be a valid email account";
//         $status = true;
//       }
//       if(!is_string($_POST['message'])){
//         echo "Error: Massage must be a string";
//         $status = true;
//       }
//     }
//         // //verify nonce
//         // if( ! isset($_POST['cfp_nonce']) || ! wp_verify_nonce($_POST['cfp_nonce'], 'cfp_form_nonce') ){
//         // wp_die('Security check failed (invalid nonce)');
//         // }
//         //sanitization
//         $name = sanitize_text_field($_POST['name']);
//         $email = sanitize_text_field($_POST['email']);
//         $message = sanitize_text_field($_POST['message']);
//         $form_id = $_POST['form_id'];

//         if(empty($name) || empty($email) || empty($message)){
//             wp_send_json_error('All fields are required.');
//         }
//         $subject = 'contact form submission from ' . $name;
//         $body = "Name: $name\nEmail: $email\nSubject: $subject\nMassage: $message\nForm ID: $form_id";
//         $post_data = [
//             'post_title'=> "Submission from {$name}",
//             'post_content'=>$body,
//             'post_status'=>'private',
//             'post_type'=>'cfp_submission'
//         ];
//         $post_id = wp_insert_post($post_data);

//         if($post_id){
//             update_post_meta($post_id,'submitter_name',$name);
//             update_post_meta($post_id,'submitter_email',$email);
//             update_post_meta($post_id,'form_subject',$subject);
//             update_post_meta($post_id,'submitter_message',$message);
//             update_post_meta($post_id,'form_id',$form_id);

//             //update_post_meta($post_id,'submitter_ip',); 
//             echo 'message sent successfully';
//         }
//         else{
//             echo 'failed';;
//         }
//   }
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
            wp_die(implode("<br>", $errors));
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
            wp_redirect(home_url('/security-essentials/')); //security-essentials/
            exit;
        } else {
            wp_die("Failed to save submission.");
        }
    }
}

}