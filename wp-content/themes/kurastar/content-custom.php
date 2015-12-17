<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="defaultWidth center clear-auto bodycontent bodycontent-index">
		<div class="searchbox">
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

		<div class="contentbox">
			<h2 class="whatsnew asd"><?php the_title() ?></h2>

			<p> <?php the_content(); ?></p>

	 	</div>
	

	    <div class="sidebox">

			<div class="socketlabs">
				<a href="#">
				  <img src="<?php echo get_template_directory_uri(); ?>/images/socketlabs.jpg" alt="">
				</a>
			</div>

			<div class="sideboxcontent ad300">
			</div>

			<?php 
			/*
			* Ranking article sidebar
			*  @hook: ranking_article_func
			*/
			?>
			<?php echo do_shortcode( '[ranking_article]' ) ?>

	    </div>
  	</div>
</article><!-- #post-## -->
