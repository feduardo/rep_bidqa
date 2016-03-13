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


function ProjectTheme_my_account_outstanding_projects_area_function()
{
		global $current_user, $wpdb, $wp_query;
		get_currentuserinfo();
		$uid = $current_user->ID;
		
?>
<div id="content" class="account-main-area">
        
       
                
                <?php
				global $current_user, $wpdb;
				get_currentuserinfo();
				$uid = $current_user->ID;
				
				
				global $wp_query;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 10;	
                
//                $querystr = "
//					SELECT distinct wposts.ID 
//					FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta2, $wpdb->postmeta wpostmeta3
//                    LEFT JOIN {$wpdb->prefix}project_bids AS b ON wposts.ID = b.pid
//					WHERE 
//                    b.uid = '$uid' AND b.outstanding = '1'
//                    AND wposts.ID = wpostmeta2.post_id AND
//					wpostmeta2.meta_key='winner' AND wpostmeta2.meta_value='$uid' AND
//					wposts.ID = wpostmeta3.post_id AND
//					wpostmeta3.meta_key='outstanding' AND wpostmeta3.meta_value='1' 
//					AND wposts.post_type = 'project' AND wposts.post_status = 'publish' ";
                $querystr = "
					SELECT p.ID
                    FROM $wpdb->posts AS p
                    LEFT JOIN {$wpdb->prefix}project_bids AS b ON p.ID = b.pid
                    LEFT JOIN {$wpdb->prefix}postmeta AS wpostmeta2 ON p.ID = wpostmeta2.post_id
                    LEFT JOIN {$wpdb->prefix}postmeta AS wpostmeta3 ON p.ID = wpostmeta3.post_id
                    WHERE 
                    b.uid = '916' AND b.outstanding = '1'
                    AND wpostmeta2.meta_key='winner' AND wpostmeta2.meta_value='916'
                    AND wpostmeta3.meta_key='outstanding' AND wpostmeta3.meta_value='1' 
                    AND p.post_type = 'project' AND p.post_status = 'publish' ";

				 $pageposts = $wpdb->get_col($querystr);
                 
                 if (empty($pageposts)) {
                
                            echo '<div class="my_box3 border_bottom_0"> <div class="box_content">   ';
                            _e("There are no outstanding projects yet.",'ProjectTheme');
                            echo '</div>  </div> ';
                 } else {
//				$outstanding = array(
//						'key' => 'outstanding',
//						'value' => "1",
//						'compare' => '='
//					);
//					
//				$winner = array(
//						'key' => 'winner',
//						'value' => $uid,
//						'compare' => '='
//					);		
				
//				$args = array('post_type' => 'project', 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $post_per_page,
//				'paged' => $query_vars['paged'], 'meta_query' => array($outstanding, $winner));
				$args = array('post_type' => 'project', 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $post_per_page,
				'paged' => $query_vars['paged'], 'post__in' => $pageposts);
				
				query_posts($args);

				if(have_posts()) :
				while ( have_posts() ) : the_post();
					projectTheme_get_post_outstanding_project();
				endwhile;
				
				if(function_exists('wp_pagenavi')):
				wp_pagenavi(); endif;
				
				 else:
				
				echo '<div class="my_box3 border_bottom_0"> <div class="box_content">   ';
				_e("There are no outstanding projects yet.",'ProjectTheme');
				echo '</div>  </div> ';
				
				endif;
                 }
				wp_reset_query();
				
				?>
                
    
        
        
  		</div>      
  		
<?php
		ProjectTheme_get_users_links();

}
	
?>