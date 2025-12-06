<?php
class CFP_Admin_Page{
    function display_cpt_entries(){
        function __construct(){
            add_action('admin_enqueue_scripts', 'enqueue_admin_assets');
            
        }
        function enqueue_admin_assets($hook){
            var_dump($hook); //hook value not showing in admin page. admin css enqueue failed
        }
        ?>
        <div class="wrap">
            <h1>Welcome to Contact Form Pro</h1>
            <p>This is plugin demonstrates Form Submission saved as CPT and Data Retrieve in Admin Page</p>
            <h2>All Form Submisions</h2>
            <?php
            $args =array(
                'post_type' => 'cfp_submission',
                'post_status'=> ['private'],
                'posts_per_page' => -1,
                'order' => 'id',
                
            );
            $query = new WP_Query($args);
             if ( $query->have_posts() ) {
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead>
                    <tr>
                        <th>Form ID</th>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>';
            echo '<tbody>';
            while ( $query->have_posts() ) {
                $query->the_post();
                $form_id = get_post_meta(get_the_ID(),'form_id',true);
                $name = get_post_meta(get_the_ID(),'submitter_name',true);
                $email = get_post_meta(get_the_ID(),'submitter_email',true);
                $subject = get_post_meta(get_the_ID(),'form_subject',true);
                $message = get_post_meta(get_the_ID(),'submitter_message',true);
                ?>
                <tr>
                    <td><?php echo esc_html($form_id)?></td>
                    <td><?php the_title(); ?></td>
                    <td><?php echo esc_html($name)?></td>
                    <td><?php echo esc_html($email)?></td>
                    <td><?php echo esc_html($subject)?></td>
                    <td><?php echo esc_html($message)?></td>
                    <td><?php echo get_the_date(); ?></td>
                    <td><?php echo get_post_status(); ?></td>
                    <!-- <td><?php //echo $query('orderby'=>array('key' => 'form_id'))?></td> -->
                </tr>
                <?php
            }
            echo '</tbody>';
            echo '</table>';
            wp_reset_postdata(); // Reset post data after the loop
        } else {
            echo '<p>No custom posts found.</p>';
        }
            ?>
        </div>
        <?php
    }
}