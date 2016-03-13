<?php
/***************************************************************************
*
*	ProjectTheme - copyright (c) - sitemile.com
*	The only project theme for wordpress on the world wide web.
*
*	Coder: Andrei Dragos Saioc
*	Email: sitemile[at]sitemile.com | andreisaioc[at]gmail.com
*	More info about the theme here: http://sitemile.com/products/wordpress-project-freelancer-theme/
*	since v1.2.5.3
*
***************************************************************************/

function ProjectTheme_my_account_outstanding_payments_area_function()
{
		global $current_user, $wpdb, $wp_query;
		get_currentuserinfo();
		$uid = $current_user->ID;
		
?>
    	<div id="content" class="account-main-area">
   
				
                
                <?php
				
				global $current_user;
				get_currentuserinfo();
				$uid = $current_user->ID;
				
				
				global $wp_query, $wpdb;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 10;				
				
                $querystr = "
                        SELECT distinct p.ID 
                        FROM $wpdb->posts AS p
                        LEFT JOIN {$wpdb->prefix}project_bids AS pb ON p.ID = pb.pid
                        WHERE   p.post_author = '$uid'
                            AND pb.winner = '1'
                            AND pb.paid = '0'
                            AND pb.delivered = '1'
                            AND p.post_type = 'project' ";
										 
				$pageposts = $wpdb->get_col($querystr);
                 
                if (empty($pageposts)) {
                    echo '<div class="my_box3 border_bottom_0"> <div class="box_content">   ';
                    _e("There are no projects yet.",'ProjectTheme');
                    echo '</div>  </div> ';
                 } else {
					
//				$paid = array(
//						'key' => 'paid_user',
//						'value' => "0",
//						'compare' => '='
//					);	
//					
//				$delivered = array(
//						'key' => 'delivered',
//						'value' => "1",
//						'compare' => '='
//					);		
//					                
//				$args = array('post_type' => 'project', 'author' => $uid, 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $post_per_page,
//				'paged' => $query_vars['paged'], 'meta_query' => array($paid, $delivered));
				$args = array('post_type' => 'project', 'author' => $uid, 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $post_per_page,
				'paged' => $query_vars['paged'], 'post__in' => $pageposts);
				
				query_posts( $args);

				if(have_posts()) :
				while ( have_posts() ) : the_post();
					projectTheme_get_post_pay();
				endwhile;
				
				if(function_exists('wp_pagenavi')):
				wp_pagenavi(); endif;
				
				 else:
				
				echo '<div class="my_box3 border_bottom_0"> <div class="box_content">   ';
				_e("There are no projects yet.",'ProjectTheme');
				echo '</div>  </div> ';
				
				endif;
				
				wp_reset_query();
                 }
				?>
                
             
       
        
        
  		</div>      
<?php
		ProjectTheme_get_users_links();

}
	
?>