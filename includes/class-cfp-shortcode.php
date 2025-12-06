<?php
defined('ABSPATH') or exit();

class CFP_Contact_Form{
    function __construct(){
        add_shortcode('cfp_form',[$this,'cfp_render_form']);

    }
    function cfp_render_form($atts){
        //shortcode atts form id
        $defaults =[
            'id' => 0
        ];
        $form = shortcode_atts($defaults,$atts);
        $form_id = $form['id'];

        //enqueue style for the form
        wp_enqueue_style('cfp-form-style',CFR_PLUGIN_URL . "assets/frontend.css",[],time());

        //creating nonce
        $nonce = wp_create_nonce('cfp_form_nonce');

        ob_start();
        ?>
         <form id="contact-form-pro" method="POST" action="<?php echo admin_url('admin-post.php'); ?>">

         <input type="hidden" name="action" value="cfp_form_submit">
         <input type="hidden" name="cfp_form_id" value="<?php echo esc_attr($form_id)?>">
         <input type="hidden" name="cfp_nonce" value="<?php echo esc_attr($nonce)?>">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required minlength="2"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea><br>

            <button type="submit" name="cfp_submission" value="Submit">Send Message</button>
         </form>
         <div id="contact-form-pro-result">
            <?php if (isset($_GET['cfp_error'])): ?>
            <div>
            <?php echo esc_html($_GET['cfp_error']); ?>
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['cfp_success'])): ?>
            <div>
                Thank you! Your message has been submitted.
            </div>
            <?php endif; ?>

            </div>
            <?php


        return ob_get_clean();
    }

}