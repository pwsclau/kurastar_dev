<?php 
/*Template Name: Register
*/
get_header(); ?>
	<div class="mainbanner subpage-banner">
		<div class="flexslider">
			<ul class="slides">
				<?php $row = 1; if(get_field('home_slider', 6)): ?>
					 <?php while(has_sub_field('home_slider', 6)): ?>
					 	<li><img src="<?php the_sub_field('slider_image', 6); ?>" /></li>
					 <?php $row++; endwhile; ?>
				<?php endif; ?>
			</ul>
		</div>
		<div class="defaultWidth center searchwrap subpage-searchwrap">
			<form method="get" action="<?php echo site_url() ?>/search-results/">
				<div class="searchwrap-inner">
					<div class="transwrap">
						<input id="cty" type="text" name="country" value="select country" readonly />
					</div>
					<div class="transwrap">
						<input id="cat" type="text" name="category" value="select category" readonly />
					</div>
					<input type="submit" class="search-btn" value="post type curators-cat" name="post_type" />
					
					<?php 
						/*
						* Country Dropdown
						* @hook: dropdown_country_func
						*/
					 ?>
					 <?php echo do_shortcode( '[dropdown_country]' ) ?>


					 <?php 
						/*
						* Category Dropdown
						* @hook: dropdown_category_func
						*/
					 ?>
					 <?php echo do_shortcode( '[dropdown_category]' ) ?>

				</div>
			</form>
		</div>
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
			  <?php// echo do_shortcode('[contact-form-7 id="10" title="User Registration"]'); ?>
			  <?php echo do_shortcode('[do_registration]'); ?>


			</div>
		  </div>
		  <div class="col-md-6 form-right">
		  	<div class="user-login">
		  		<h2>Login:</h2>
			 	<?php //echo do_shortcode('[contact-form-7 id="16" title="Log in"]'); ?>
			 	<?php echo do_shortcode( '[do_login]') ?>
			</div>
			<?php if ( !is_user_logged_in() ) { ?>
			<div class="sns-login sns-desktop">
				<div><?php //echo do_shortcode('[wordpress_social_login]'); ?></div>
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
					<!-- <li><a href="#"><i class="fa fa-instagram"></i></a></li>
					<li><a href="#"><i class="fa fa-yahoo"></i></a></li> -->
				</ul>
			</div>
			<?php } ?>
		  </div>
	  </div>
</div>
</div>
<?php get_footer(); ?>