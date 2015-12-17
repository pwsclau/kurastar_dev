<?php 
/* Template Name: Content with right sidebar */
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

<div class="defaultWidth center clear-auto bodycontent bodycontent-index">
	<div class="contentbox">


		<?php 
			while (have_posts()) : the_post();?>
					<h2 class="whatsnew"><?php  the_title(); ?></h2>
			<?php
			the_content();
			endwhile;
		?>
		
	</div>
	<!-- start sidebar -->

		<div class="sidebox">
			<div class="socketlabs">
				<a href="#">
					<img src="<?php echo get_template_directory_uri(); ?>/images/socketlabs.jpg" alt="">
				</a>
			</div>

			<a href="<?php echo site_url() ?>/curator/"><button type="button" class="btn btn-default curators">See Curators</button></a>
			<?php echo do_shortcode( '[most_view]' ); ?> 
			<div class="sideboxcontent ad300">
				<img src="<?php echo get_template_directory_uri(); ?>/images/300x300.jpg" />
			</div>
			
 			<?php 
 				/*
 				* Ranking article sidebar
 				*  @hook: ranking_article_func
 				*/
 			 ?>
			<?php echo do_shortcode( '[ranking_article]' ) ?>
			<?php 
 				/*
 				* Ranking country sidebar
 				*  @hook: ranking_country_func
 				*/
 			 ?>
			<?php echo do_shortcode( '[ranking_country]' ) ?>
			
		</div>
</div>
<?php get_footer(); ?>