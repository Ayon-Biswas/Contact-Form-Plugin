<?php
/* 
* Plugin Name: Contact Form Pro
* Description: A simple plugin to demonstrate contact form entries to WorPress CPT---assignment from interactive cares
* Version: 1.0
 Author: Ayon Biswas
*/ 
//prevent direct access
defined('ABSPATH') or exit();
define('CFR_PLUGIN_URL',plugin_dir_url(__FILE__));
define('CFR_PLUGIN_PATH',plugin_dir_path(__FILE__));

class Contact_Form_Pro_Plugin{
    function __construct(){
        $this->include_resources();
        $this->init();
        add_action('admin_menu',[$this,'add_admin_menu']); //hook for admin menu
    }
        function add_admin_menu(){
        add_menu_page(
			'Contact Submissions',
			'All Forms + Submissions',
			'manage_options',
			'cfp-admin-page',
			[$this, 'display_submissions_page'],
			'dashicons-feedback',
			30
		);
    }
    function display_submissions_page(){
        $admin =  new CFP_Admin_Page(); //initializing admin class
        $admin->display_cpt_entries(); //called the method from admin class. whatever we echo will be added 
    }

    function include_resources(){
        require_once(CFR_PLUGIN_PATH.'/includes/class-cfp-shortcode.php');
        require_once(CFR_PLUGIN_PATH.'/includes/class-cfp-submission.php');
        require_once(CFR_PLUGIN_PATH.'/includes/class-submission-handler.php');
        require_once(CFR_PLUGIN_PATH.'/includes/class-cpt.php');
        require_once(CFR_PLUGIN_PATH.'/includes/class-cfp-admin.php');
    }
    function init(){
        new CFP_Contact_Form();
        new CFP_Submission_Handler();
        new CFP_Custom_Post_Types();
        new CFP_Admin_Page();
    }
}
new Contact_Form_Pro_Plugin();