<?php

/* 
 * From function.php
 */


function projectTheme_get_post_outstanding_project_function2()

{

	

			$ending 			= get_post_meta(get_the_ID(), 'ending', true);

			$sec 				= $ending - current_time('timestamp',0);

			$location 			= get_post_meta(get_the_ID(), 'Location', true);		

			$closed 			= get_post_meta(get_the_ID(), 'closed', true);

			$featured 			= get_post_meta(get_the_ID(), 'featured', true);

			

			$mark_coder_delivered 			= get_post_meta(get_the_ID(), 'mark_coder_delivered', true);

			$post							= get_post(get_the_ID());



			

			global $current_user;

			get_currentuserinfo();

			$uid = $current_user->ID;

			

			do_action('ProjectTheme_outstanding_proj_post_before');

			

?>

				<div class="post" id="post-<?php the_ID(); ?>">

                

                <?php if($featured == "1"): ?>

                <div class="featured-one"></div>

                <?php endif; ?>

                

                

                <?php if($private_bids == "yes" or $private_bids == "1"): ?>

                <div class="sealed-one"></div>

                <?php endif; ?>

                

                

                <div class="padd10_only_top">

                <div class="image_holder">

                 <?php

				

				$ProjectTheme_enable_images_in_projects = get_option('ProjectTheme_enable_images_in_projects');

				if($ProjectTheme_enable_images_in_projects == "yes"):

					

					$width 	= 40;

					$height = 32;

					$image_class = "image_class";

					

					

					$width 			= apply_filters("ProjectTheme_outstanding_proj_img_width", 	$width);

					$height 		= apply_filters("ProjectTheme_outstanding_proj_img_height", $height);

					$image_class 	= apply_filters("ProjectTheme_outstanding_proj_img_class", 	$image_class);

					

				?>

                

                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="<?php echo $image_class; ?>" 

                src="<?php echo ProjectTheme_get_first_post_image(get_the_ID(),$width,$height); ?>" alt="<?php the_title(); ?>" /></a>

               

               <?php endif; ?>

                </div>

                <div class="title_holder" > 

                     <h2><a class="post-title-class" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php 

					 do_action('ProjectTheme_outstanding_proj_title_before');

					 the_title(); 

					 do_action('ProjectTheme_outstanding_proj_title_after');

					 ?></a></h2>

                        

    

                        

                  <p class="mypostedon">

                        <?php _e("Posted in",'ProjectTheme');?>: <?php echo get_the_term_list( get_the_ID(), 'project_cat', '', ', ', '' ); ?> 

                        <?php _e("by",'ProjectTheme');?>: <a href="<?php bloginfo('siteurl'); ?>?p_action=user_profile&post_author=<?php echo $post->post_author; ?>"><?php the_author() ?></a> 

                  </p>

                       

                        

              <p class="task_buttons">   

                    <?php do_action('ProjectTheme_outstanding_proj_buttons'); ?>    

		

       				<?php if($mark_coder_delivered != "1"): ?>

       

                       <?php

					   

					   $cannot_mark_delivered = 0;

								$projectTheme_enable_paypal_ad = get_option('projectTheme_enable_paypal_ad');

									

									if($projectTheme_enable_paypal_ad == "yes")

									{

										$adaptive_done = get_post_meta(get_the_ID(),'adaptive_done',true);

										if(empty($adaptive_done)) $cannot_mark_delivered = 1;

									}

									

									if(!$cannot_mark_delivered)

									{

						?>

           

                            <a href="<?php echo get_bloginfo('siteurl'); ?>/?p_action=mark_delivered&pid=<?php the_ID(); ?>" 

                            class="green_btn"><?php echo __("Mark Delivered", "ProjectTheme");?></a>

                            

                            

                            <?php

							

									} else { echo '<div class="cpts_n1">'; _e('The Project Owner must deposit the money escrow through PayPal before the project starts.','ProjectTheme'); echo '</div>'; }

							?>

                   

				   <?php else: 

				   

				   		$dv = get_post_meta(get_the_ID(), 'mark_coder_delivered_date', true);

				   		$dv = date_i18n('d-M-Y H:i:s',$dv);

				   

				   ?>

                   

                   <span class="zbk_zbk">

                   <?php printf(__("Awaiting buyer response.<br/>Marked as delivered on: %s","ProjectTheme"), $dv); ?>

                   </span>

                   

                   <?php endif; ?>

                   



                  </p>

      </div> 

                     

                  <div class="details_holder"> 



                  

                  <ul class="project-details1 project-details1_a">

                  

                  			<?php do_action('ProjectTheme_outstanding_proj_details_before'); ?> 

                  		

                  

							<li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/price.png" width="15" height="15" /> 

								<h3><?php echo __("Budget",'ProjectTheme'); ?>:</h3>

								<p><?php 

								

								$sel = get_post_meta(get_the_ID(), 'budgets', true);

		  						echo ProjectTheme_get_budget_name_string_fromID($sel);

								

								 ?>

                                

                                </p>

							</li>

                            

                            

                            <li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/price.png" width="15" height="15" /> 

								<h3><?php echo __("Winning Bid",'ProjectTheme'); ?>:</h3>

								<p><?php 

								

								$bid = projectTheme_get_winner_bid(get_the_ID());

								echo ProjectTheme_get_show_price($bid->bid);

								 								

								 ?>

                                

                                </p>

							</li>

					

             

                        

							<li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/clock.png" width="15" height="15" /> 

								<h3><?php echo __("Delivery On",'ProjectTheme'); ?>:</h3>

								<p><?php 

								

								$tm_d = get_post_meta(get_the_ID(), 'expected_delivery', true);							

								echo date_i18n('d-M-Y H:i:s', $tm_d);

								

								?></p>

							</li>

							

							<?php do_action('ProjectTheme_outstanding_proj_details_after'); ?> 

                    

						</ul>

                      

               

                  </div>   

                     

                     </div></div></div> <?php	

					 

					 do_action('ProjectTheme_outstanding_proj_post_after');

}




function projectTheme_get_post_awaiting_compl_function_old()

{

		$ending 			= get_post_meta(get_the_ID(), 'ending', true);

			$sec 				= $ending - current_time('timestamp',0);

			$location 			= get_post_meta(get_the_ID(), 'Location', true);		

			$closed 			= get_post_meta(get_the_ID(), 'closed', true);

			$featured 			= get_post_meta(get_the_ID(), 'featured', true);

			

			$mark_coder_delivered 			= get_post_meta(get_the_ID(), 'mark_coder_delivered', true);

			

			$post				= get_post(get_the_ID());



			

			global $current_user;

			get_currentuserinfo();

			$uid = $current_user->ID;

			

?>

				<div class="post" id="post-<?php the_ID(); ?>"><div class="padd10">

                

                <?php if($featured == "1"): ?>

                <div class="featured-one"></div>

                <?php endif; ?>

                

                

                <?php if($private_bids == "yes" or $private_bids == "1"): ?>

                <div class="sealed-one"></div>

                <?php endif; ?>

                

                

                <div class="padd10_only_top">

                <div class="image_holder">

                 <?php

				

				$ProjectTheme_enable_images_in_projects = get_option('ProjectTheme_enable_images_in_projects');

				if($ProjectTheme_enable_images_in_projects == "yes"):

					

					$width 	= 40;

					$height = 32;

					$image_class = "image_class";

					

					

					$width 			= apply_filters("ProjectTheme_awaiting_completion_proj_img_width", 	$width);

					$height 		= apply_filters("ProjectTheme_awaiting_completion_proj_img_height", 	$height);

					$image_class 	= apply_filters("ProjectTheme_awaiting_completion_proj_img_class", 	$image_class);

					

					

				?>

                

                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img alt="<?php the_title(); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="<?php echo $image_class; ?>" 

                src="<?php echo ProjectTheme_get_first_post_image(get_the_ID(),$width,$height); ?>" /></a>

               

               <?php endif; ?>

               

                </div>

                <div class="title_holder" > 

                     <h2><a class="post-title-class" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

                        

    

                        

                  <p class="mypostedon">

                        <?php _e("Posted in",'ProjectTheme');?>: <?php echo get_the_term_list( get_the_ID(), 'project_cat', '', ', ', '' ); ?> 

                        <?php _e("by",'ProjectTheme');?>: <a href="<?php bloginfo('siteurl'); ?>?p_action=user_profile&post_author=<?php echo $post->post_author; ?>"><?php the_author() ?></a> 

                  </p>

                       

                        

              <p class="task_buttons">   

                        

		

       				<?php if($mark_coder_delivered != "1"): ?>

       

                        <?php _e('The winner must mark this as delivered.','ProjectTheme'); ?>

                        <?php

						

							if(!projecttheme_escrow_was_made_for_project_done(get_the_ID())):

							

							$ProjectTheme_enable_credits_wallet = get_option('ProjectTheme_enable_credits_wallet');

							if($ProjectTheme_enable_credits_wallet != 'no'):

													

						?> 

                        <br/>

                        <a href="<?php echo ProjectTheme_get_payments_page_url_redir('escrow') ?>" class="post_bid_btn"><?php _e('Make Escrow','ProjectTheme') ?></a>

                        

                        <?php endif; else: echo '<br/>'; _e('Escrow was made for this project.','ProjectTheme'); endif;

                   

				     else: 

				   

				   		$dv = get_post_meta(get_the_ID(), 'mark_coder_delivered_date', true);

				   		$dv = date_i18n('d-M-Y H:i:s',$dv);

				   

				   ?>

                   

                   <span class="zbk_zbk">

                   <?php printf(__("Marked as delivered on: %s","ProjectTheme"), $dv); ?><br/><br/>

                   <?php _e('Accept this project and: ','ProjectTheme'); ?>

                     <a href="<?php echo get_bloginfo('siteurl'); ?>/?p_action=mark_completed&pid=<?php the_ID(); ?>" 

                        class="green_btn"><?php echo __("Mark Completed", "ProjectTheme");?></a>

                   

                   </span>

                   

                   <?php endif; ?>

                   



                  </p>

      </div> 

                     

                  <div class="details_holder"> 



                  

                  <ul class="project-details1 project-details1_a">

							<li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/price.png" width="15" height="15" /> 

								<h3><?php echo __("Budget",'ProjectTheme'); ?>:</h3>

								<p><?php 

								

								  $sel = get_post_meta(get_the_ID(), 'budgets', true);

		  						echo ProjectTheme_get_budget_name_string_fromID($sel);

								

								 ?>

                                

                                </p>

							</li>

                            

                            

                            <li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/price.png" width="15" height="15" /> 

								<h3><?php echo __("Winning Bid",'ProjectTheme'); ?>:</h3>

								<p><?php 

								

								$bid = projectTheme_get_winner_bid(get_the_ID());

								echo ProjectTheme_get_show_price($bid->bid);

								  

								

								 ?>

                                

                                </p>

							</li>

					

             				

                            <li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/location.png" width="15" height="15" /> 

								<h3><?php echo __("Winner",'ProjectTheme'); ?>:</h3>

								<p><?php 

								

								$winner = get_post_meta(get_the_ID(), 'winner', true);



								$winner = get_userdata($winner);

								

								echo '<a href="'.ProjectTheme_get_user_profile_link($winner->ID).'">'.$winner->user_login.'</a>';

								

								?></p>

							</li>

                        



							

                            <li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/clock.png" width="15" height="15" /> 

								<h3><?php echo __("Delivery On",'ProjectTheme'); ?>:</h3>

								<p><?php 

								

								$tm_d = get_post_meta(get_the_ID(), 'expected_delivery', true);							

								echo date_i18n('d-M-Y H:i:s', $tm_d);

								

								?></p>

							</li>

							

					

                    

						</ul>

                      

               

                  </div>   

                     

                     </div></div></div> <?php		
}





function projectTheme_get_post_main_function2( $arr = '')

{



			if($arr[0] == "winner") 	$pay_this_me = 1;

			if($arr[0] == "winner_not") $pay_this_me2 = 1;

			if($arr[0] == "unpaid") 	$unpaid = 1;



			$ending 			= get_post_meta(get_the_ID(), 'ending', true);

			$sec 				= $ending - current_time('timestamp',0);

			$location 			= get_post_meta(get_the_ID(), 'Location', true);		

			$closed 			= get_post_meta(get_the_ID(), 'closed', true);

			$featured 			= get_post_meta(get_the_ID(), 'featured', true);

			$private_bids 		= get_post_meta(get_the_ID(), 'private_bids', true);

			$paid		 		= get_post_meta(get_the_ID(), 'paid', true);

			$post				= get_post(get_the_ID());



			//echo $paid;

			

			global $current_user;

			get_currentuserinfo();

			$uid = $current_user->ID;

			

			

			do_action('ProjectTheme_regular_proj_post_before');

			

?>

				<div class="post" id="post-<?php the_ID(); ?>"><div class="padd10">

                

                <?php if($featured == "1"): ?>

                <div class="featured-one"></div>

                <?php endif; ?>

                

                

                <?php if($private_bids == "yes" or $private_bids == "1"): ?>

                <div class="sealed-one"></div>

                <?php endif; ?>

                

                

                <div class="padd10_only_top">

                

               

                

                <div class="image_holder">

                

                 <?php

				

				$ProjectTheme_enable_images_in_projects = get_option('ProjectTheme_enable_images_in_projects');

				if($ProjectTheme_enable_images_in_projects == "yes"):

					

					$width 	= 40;

					$height = 32;

					$image_class = "image_class";

					

					

					$width 			= apply_filters("ProjectTheme_regular_proj_img_width", 	$width);

					$height 		= apply_filters("ProjectTheme_regular_proj_img_height", $height);

					$image_class 	= apply_filters("ProjectTheme_regular_proj_img_class", 	$image_class);

					

					

				?>

                

                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img alt="<?php the_title(); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="<?php echo $image_class; ?>" 

                src="<?php echo ProjectTheme_get_first_post_image(get_the_ID(),$width,$height); ?>" /></a>

               

               <?php endif; ?>

               

                </div>

  

                

                <div class="title_holder" > 

                     <h2><a class="post-title-class" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">

                        <?php 

						

						do_action('ProjectTheme_regular_proj_title_before');

                        the_title(); 

						do_action('ProjectTheme_regular_proj_title_after');

                        

                        ?></a></h2>

                        

                        

                  <?php if(1) { ?>     

                        

                      

                        

                  <p class="mypostedon">

                        <?php _e("Posted in",'ProjectTheme');?>: <?php echo get_the_term_list( get_the_ID(), 'project_cat', '', ', ', '' ); ?> 

                        <?php _e("by",'ProjectTheme');?>: <a href="<?php bloginfo('siteurl'); ?>?p_action=user_profile&post_author=<?php echo $post->post_author; ?>"><?php the_author() ?></a> 

                        

                        <?php

							

							$projectTheme_admin_approves_each_project = get_option('projectTheme_admin_approves_each_project');

							

							if($post->post_status == "draft" && $closed == "0" && $paid == "1" && $projectTheme_admin_approves_each_project == "yes")

							{

								echo '<br/><em>' . __('Your project is awaiting moderation.','ProjectTheme') . "</em>";	

								

							}

						

						?>

                        

                        

                        </p>

                       

                        

                        

                        

                                <p class="task_buttons">   

                        <?php if($pay_this_me == 1): ?>

                        <a href="<?php echo ProjectTheme_get_pay4project_page_url(get_the_ID()); ?>" 

                        class="post_bid_btn"><?php echo __("Pay This", "ProjectTheme");?></a>

                        <?php endif; ?>

                        

                   <?php if(1 ) { ?>  

                 

                  <?php if( $pay_this_me != 1): ?>

                  <a href="<?php the_permalink(); ?>" class="post_bid_btn"><?php echo __("Read More", "ProjectTheme");?></a>

                  <?php endif; ?>

                  

                  <?php if( $unpaid == 1): 

				  

				  	$finalised_posted = get_post_meta(get_the_ID(),'finalised_posted',true);

					if($finalised_posted == "1") $finalised_posted = 3; else $finalised_posted = "1";

				  	

					$finalised_posted = apply_filters('ProjectTheme_publish_prj_posted', $finalised_posted);

					

				  ?>

                  <a href="<?php echo ProjectTheme_post_new_with_pid_stuff_thg(get_the_ID(), $finalised_posted); ?>" class="post_bid_btn"><?php echo __("Publish", "ProjectTheme");?></a>

                  <?php endif; ?>

                  

                  

                

                  

				  <?php if($post->post_author == $uid) { ?>

                  <a href="<?php bloginfo('siteurl') ?>/?p_action=edit_project&pid=<?php the_ID(); ?>" class="post_bid_btn"><?php echo __("Edit Project", "ProjectTheme");?></a>

                  <?php }   ?>

                  

                  <?php if($post->post_author == $uid) //$closed == 1) 

				  { ?> 

                  

                   <?php if($closed == "1") //$closed == 1) 

				  { ?>

                  <a href="<?php bloginfo('siteurl') ?>/?p_action=repost_project&pid=<?php the_ID(); ?>" class="post_bid_btn"><?php echo __("Repost Project", "ProjectTheme");?></a>

                  

                  <?php } /*} else { */  ?>

                	<?php

					

					$winner = get_post_meta(get_the_ID(),'winner', true);

					

					if(empty($winner)):

					?>

                   <a href="<?php bloginfo('siteurl') ?>/?p_action=delete_project&pid=<?php the_ID(); ?>" class="post_bid_btn"><?php echo __("Delete", "ProjectTheme");?></a>

                  <?php endif; ?>

                  

                  <?php } ?>

                  

                  <?php } ?>

                  </p>

                        

                        

                     </div> 

                     

                  <div class="details_holder"> <?php } ?>

                  

                  

                  

                  <ul class="project-details1">

							<li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/price.png" width="15" height="15" /> 

								<h3><?php echo __("Budget:",'ProjectTheme'); ?></h3>

								<p><?php 

								

								  $sel = get_post_meta(get_the_ID(), 'budgets', true);

		  						echo ProjectTheme_get_budget_name_string_fromID($sel);

								

								 ?>

                                

                                </p>

							</li>

					

             			<?php

		

			$ProjectTheme_enable_project_location = get_option('ProjectTheme_enable_project_location');

			if($ProjectTheme_enable_project_location == "yes"):

		

		?>

                        

							<li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/location.png" width="15" height="15" /> 

								<h3><?php echo __("Location:",'ProjectTheme'); ?></h3>

								<p><?php echo get_the_term_list( get_the_ID(), 'project_location', '', ', ', '' ); ?></p>

							</li>

                            

			<?php endif; ?>				

					

							<li>

								<img src="<?php echo get_bloginfo('template_url'); ?>/images/clock.png" width="15" height="15" /> 

								<h3><?php echo __("Expires in:",'ProjectTheme'); ?></h3>

								<p><?php echo ($closed=="1" ? __('Closed', 'ProjectTheme') : ProjectTheme_prepare_seconds_to_words($ending - current_time('timestamp',0))); ?></p>

							</li>

							

						</ul>

                      

               

                  </div>   

                     

                     </div></div></div>

<?php

	

	do_action('ProjectTheme_regular_proj_post_after');



}