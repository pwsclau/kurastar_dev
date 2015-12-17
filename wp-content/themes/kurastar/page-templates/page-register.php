<?php 
/*Template Name: Register
*/
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
	<div class="defaultWidth center clear-auto bodycontent registration-page">
	<div class="contentbox nosidebar">
		<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
        <?php if(function_exists('bcn_display'))
        {
            bcn_display();
        }?>
    </div>
	  <div class="row">
		  <div class="col-md-6 form-left">
		  	<h2>User registration:</h2>
		  	<div class="user-register">
			  	<p class="reg-copy">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				  <?php echo do_shortcode('[do_registration]'); ?>


				</div>
		  </div>
		  <div class="col-md-6 form-right">
		  	<div class="user-login">
		  		<h2>Login:</h2>
			 	<?php echo do_shortcode( '[do_login]') ?>
			</div>
			<?php if ( !is_user_logged_in() ) { ?>
			<div class="sns-login sns-desktop">
				<div></div>
				<h2>SNS Login:</h2>
				<ul class="list-inline">
					<?php $row = 1; if(get_field('sns_log_in_list')): ?>
	      				<?php while(has_sub_field('sns_log_in_list')): ?>
							<li>
								<?php the_sub_field('sns_social_link'); ?>
									<?php the_sub_field('sns_social'); ?>
								</a>
							</li>
						<?php $row++; endwhile; ?>
					<?php endif; ?>
				</ul>
			</div>
			<div class="sns-login sns-mobile">

				<h2>SNS Login:</h2>

				<ul class="list-inline">
					<li><a href="#"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter"></i></a></li>
				</ul>
			</div>
			<?php } ?>
		  </div>
	  </div>
</div>
</div>
<?php get_footer(); ?>