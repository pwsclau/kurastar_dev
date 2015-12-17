<?php 
/* Template Name: Content with sidebar */
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

<div class="defaultWidth center clear-auto bodycontent bodycontent-index content-sidebar">
	<div class="contentbox">


		<?php 
			while (have_posts()) : the_post();?>
					<h1 class="whatsnew"><?php  the_title(); ?></h1>
					<?php  the_content(); ?>
			<?php
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

			<a href="<?php echo bloginfo() ?>/curators/"><button type="button" class="btn btn-default curators">See Curators</button></a>
			<?php echo do_shortcode( '[most_view]' ); ?>
			
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