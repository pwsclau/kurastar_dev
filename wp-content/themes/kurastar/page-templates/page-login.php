<?php 
/* Template Name: Login */
get_header(); ?>
<div class="banner">
	
	<?php 
      /*
      * Search form
      * @hook: do_custom_search_form
      */
     ?>
    <?php echo do_shortcode( '[custom_search_form]' ) ?>
    
</div>
<div class="defaultWidth center clear-auto bodycontent registration-page loginbox">
	<div class="contentbox nosidebar">

		<?php echo do_shortcode( '[do_login]') ?>
		<?php
			if ( !is_user_logged_in() ) {
		?>
				<div class="sns-login sns-desktop">
					<h2>SNS Login:</h2>
					<ul class="list-inline">
						<?php $row = 1; if(get_field('sns_log_in_list', 11)): ?>
								<?php while(has_sub_field('sns_log_in_list', 11)): ?>
								<li>
									<?php the_sub_field('sns_social_link', 11); ?>
										<?php the_sub_field('sns_social', 11); ?>
									</a>
								</li>
							<?php $row++; endwhile; ?>
						<?php endif; ?>
					</ul>
				</div>
		<?php }  ?>
		
	</div>
</div>
<?php get_footer(); ?>