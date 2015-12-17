<?php 
/* Template Name: Login */
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