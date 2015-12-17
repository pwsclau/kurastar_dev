<?php 

/*Template Name: Home-Banner*/
global $wp;
get_header(); ?>
	<div class="mainbanner">
		<div class="flexslider">
			<ul class="slides">
				<?php $row = 1; if(get_field('home_slider')): ?>
					 <?php while(has_sub_field('home_slider')): ?>
					 	<li><img src="<?php the_sub_field('slider_image'); ?>" /></li>
					 <?php $row++; endwhile; ?>
				<?php endif; ?>
			</ul>
		</div>
		<div class="defaultWidth center searchwrap">
			<form method="get" action="<?php echo site_url() ?>/search-results/">
				<div class="searchwrap-inner">
					<div class="transwrap">
						<input id="cty" type="text" name="country" value="select country" readonly />
					</div>
					<div class="transwrap">
						<input id="cat" type="text" name="category" value="select category" readonly />
					</div>
				<!-- 	<input type="submit" class="search-btn" value="post type curators-cat" name="post_type" /> -->
				<input type="submit" class="search-btn" value="" name="post_type" />
					
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
	<div class="defaultWidth center clear-auto bodycontent bodycontent-index ">
		<div class="contentbox">
			<h2 class="whatsnew">ー最新情報ー</h2>


			<ul class="post-list-thumb post-list-default">
			<?php
				 # get_wpposts();
#
			# 	$temp = $wp_query; 
  			#	$wp_query = null; 

				 #global $query_string;
			 	query_posts(array( 'post_type' => 'acme_article','posts_per_page' => 6, 'post_status' => 'publish', 'paged' => get_query_var('page')) );
				 if ( have_posts() ) : while ( have_posts() ) : the_post();
				# $wp_query = new WP_Query(  array( 'post_type' => 'acme_article', 'posts_per_page' => 9, 'post_status' => 'publish', 'paged' => get_query_var('page'))  );

				#  if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
			?>
				<li id="post-<?php echo the_ID() ?>" class="post-<?php echo the_ID() ?> post">
				  <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap">
                    <?php
                 	//Returns All Term Items for "my_taxonomy"
						$category          = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
						$countries         = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));
						$authorID          = get_the_author_meta($post->ID);
						$curator_profile   = get_cupp_meta($authorID, 'thumbnail');
						$custom_image_link = get_post_meta( $post->ID, '_custom_image_link', true);
          ?>
            <div class="postimg" style="background: url(<?php echo getArticleImage($post->ID); ?>)"></div>
          </a>
            <div class="labels ">
            	<?php if($countries): ?>
            		<?php foreach($countries as $country): ?>
            			<a href="<?php echo '/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat'; ?>" class="countrylabel">
            				<i class="fa fa-map-marker"></i> 
            				<span class="label-post"><?php echo $country; //フィリピン ?></span>
            				
            			</a>
            		<?php endforeach; ?>
            	<?php else: ?>
            		<a href="#" class="countrylabel"><i class="fa fa-map-marker"> No Country</i></a>
            	<?php endif; ?>

            	<?php if($category): ?>
            		<?php foreach($category as $cat): ?>
            			<a href="<?php echo '/search-results/?country=select+country&category='.$cat.'&post_type=post+type+curators-cat'; ?>" class="catlabel">
            				<i class="<?php echo categoryLogo(array('category' => $cat)); ?>"></i>
            				<span class="label-post"><?php echo $cat; //観光 ?> </span> 
            			</a>
            		<?php endforeach; ?>
            	<?php else: ?>
            		<!-- <a href="#" class="catlabel"><i class="fa fa-hotel"></i> No Category</a> -->
            	<?php endif; ?>               
            </div>
				</li>
			
			<?php endwhile ;   endif;  

    	//	load_more_button();

			//wp pagenavi plugin for pagination		
			  // if(function_exists("wp_pagenavi")):

			  // 	wp_pagenavi(); 

			  // endif;	

	  #  $wp_query = null; 

  	#	$wp_query = $temp;
			global $wp_query;

			$_SESSION['custom_max_pages'] = $wp_query->max_num_pages; //add this value to work with the load more

			 wp_reset_query(); 

			#wp_reset_postdata();?>
			</ul>

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