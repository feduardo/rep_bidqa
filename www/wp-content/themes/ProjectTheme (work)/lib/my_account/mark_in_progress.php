<?php
if(!is_user_logged_in()) { wp_redirect(get_bloginfo('siteurl')."/wp-login.php"); exit; }
//-----------

	add_filter('sitemile_before_footer', 'projectTheme_my_account_before_footer');
	function projectTheme_my_account_before_footer()
	{
		echo '<div class="clear10"></div>';		
	}
	
	//----------

	global $wpdb,$wp_rewrite,$wp_query;
	$pid = $wp_query->query_vars['pid'];
    $bid = Bid::get_by_id($wp_query->query_vars['bid']);

	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;

	$post_pr = get_post($pid);
	
	//---------------------------
	
	if($uid != $post_pr->post_author) { wp_redirect(get_bloginfo('siteurl')); exit; }
	
	//---------------------------
	
	if(isset($_POST['yes']))
	{
		$tm = current_time('timestamp',0);
		$mark_coder_delivered = Bid::get_field_by_id($bid->id, 'mark_coder_delivered', true);
        
        $reason = $_POST['reason'];
		
		if(!empty($mark_coder_delivered))
		{
			
//			update_post_meta($pid, 'mark_seller_accepted',		"1");
            Bid::update_meta_by_id($bid->id, 'mark_seller_accepted',	"0");
            Bid::update_meta_by_id($bid->id, 'mark_seller_accepted_date',	"0");
            Bid::update_meta_by_id($bid->id, 'mark_coder_delivered',	"0");
            Bid::update_meta_by_id($bid->id, 'mark_coder_delivered_date',	"0");
            
			/////my_edits
//			update_post_meta($pid, 'closed',		"1");
			////
//			update_post_meta($pid, 'mark_seller_accepted_date',		$tm);
			
			
//			update_post_meta($pid, 'outstanding',	"0");
//			update_post_meta($pid, 'delivered',		"1");
            Bid::update_meta_by_id($bid->id, 'outstanding',	"1");
            Bid::update_meta_by_id($bid->id, 'delivered',	"0");
            
            //update postmeta project
            Project::update_postmeta($pid, 'mark_seller_accepted');
            Project::update_postmeta($pid, 'mark_coder_delivered');
            Project::update_postmeta($pid, 'outstanding');
            Project::update_postmeta($pid, 'delivered');
			
			//------------------------------------------------------------------------------
//			$projectTheme_get_winner_bid = projectTheme_get_winner_bid($pid);
			
			ProjectTheme_send_email_in_progress_project_to_bidder($pid, $bid->uid, $reason);
			ProjectTheme_send_email_in_progress_project_to_owner($pid, $bid->uid, $reason);
		
		}
		
		wp_redirect(get_permalink(get_option('ProjectTheme_my_account_active_projects_id')));
		exit;
	}
	
	if(isset($_POST['no']))
	{
		wp_redirect(get_permalink(get_option('ProjectTheme_my_account_awaiting_completion_id')));
		exit;			
	}
	
	
	
	//---------------------------------
	
	get_header();

?>
                <div class="page_heading_me">
                        <div class="page_heading_me_inner">
                            <div class="mm_inn"><?php  printf(__("Mark the project as completed: %s",'ProjectTheme'), $post_pr->post_title); ?> </div>
                  	            
                                        
                        </div>
                    
                    </div> 
<!-- ########## -->

<div id="main_wrapper">
		<div id="main" class="wrapper"><div class="padd10">


	
			<div class="my_box3">
            	<div class="padd10">
            
            	 
                <div class="box_content">   
               <?php
			   
			   printf(__("You are about to mark this project as in progress again: %s",'ProjectTheme'), $post_pr->post_title); echo '<br/>';
			  _e("The QA engineer will be notified about this action.",'ProjectTheme') ;echo '<br/>';
              _e("Enter a reason, please:",'ProjectTheme') ;
			   
			   ?> 
                
                <div class="clear10"></div>
               
               <form method="post"  > 
               <input type="hidden" name="bid" value="<?php echo $_GET['bid']; ?>">
                
               <textarea name="reason" required=""></textarea>
               
               <input type="submit" name="yes" value="<?php _e("Yes, Mark in Progress",'ProjectTheme'); ?>" />
               <input type="submit" name="no"  value="<?php _e("No",'ProjectTheme'); ?>" />
                
               </form>
    </div>
			</div>
			</div>
        
        
        <div class="clear100"></div>
            
    
    
    </div></div></div>
            
<?php

get_footer();

?>                        