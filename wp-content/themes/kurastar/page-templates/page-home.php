<?php 

/*Template Name: Home*/
global $wp;
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
	<div class="defaultWidth center clear-auto bodycontent bodycontent-index ">
		<div class="contentbox">
			<h2 class="whatsnew">ー最新情報ー</h2>
			<ul class="post-list-thumb post-list-default">

				<div class="post-publish-wrapper">
				<?php
				     $paged = ( get_query_var('page') > 1 ) ? get_query_var('page') : 1;

		            $param = array( 
		                    'post_type'       => 'acme_article', 
		                    'posts_per_page'  => CUSTOM_POST_PER_PAGE, 
		                    'paged'           => $paged, 
		                    'post_status'     => 'publish',
		                    'orderby'         => 'post_date',
		                    'order'           => 'DESC');

		             $wp_query = new WP_Query( $param );

					 if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();

					 	//Returns All Term Items for "my_taxonomy"
						$category          = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
						$countries         = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));
						$authorID          = get_the_author_meta($post->ID);
						$curator_profile   = get_cupp_meta($authorID, 'thumbnail');
						$custom_image_link = get_post_meta( $post->ID, '_custom_image_link', true);

				    ?>
					<li id="post-<?php echo the_ID() ?>" class="post-<?php echo the_ID() ?> post">

						<a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap">
							<div class="postimg" style="background: url(<?php echo getArticleImage($post->ID); ?>)"></div>
						</a>

						<div class="labels ">
						<?php if($countries): ?>
							<?php foreach($countries as $country): ?>
								<a href="<?php echo '/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat'; ?>" class="countrylabel">
									<i class="fa fa-map-marker"></i> 
									<span class="label-post"> <?php echo $country; //フィリピン ?></span>
									
								</a>
							<?php endforeach; ?>
						<?php else: ?>
							<a href="#" class="countrylabel"><i class="fa fa-map-marker"> No Country</i></a>
						<?php endif; ?>

						<?php if($category): ?>
							<?php foreach($category as $cat): ?>
								<a href="<?php echo '/search-results/?country=select+country&category='.$cat.'&post_type=post+type+curators-cat'; ?>" class="catlabel">
									<i class="<?php echo categoryLogo(array('category' => $cat)); ?>"></i>
									<span class="label-post"> <?php echo $cat; //観光 ?> </span> 
								</a>
							<?php endforeach; ?>
						<?php else: ?>
						<?php endif; ?>               
						</div>

					</li>
				<?php endwhile ;  endif;  
				 wp_reset_postdata();?>
			 	 </div>
				<?php if ( $wp_query->have_posts() && $wp_query->found_posts > CUSTOM_POST_PER_PAGE) : ?>
					<a class="custom-defaultpagi custom-publish load-div" href="#">
						<span class="load-more">Load More</span></a>
						<input type="hidden" class="custom-paged" value="0">
					</a>
				<?php  endif; ?>
				<script type="text/javascript">
                /* <![CDATA[ */
                var custom_post_per_page = "<?php echo CUSTOM_POST_PER_PAGE;?>";
                /* ]]> */

                </script>
			</ul>
		</div>
		<!-- start sidebar -->

		<div class="sidebox">
			<div class="socketlabs">
				<a href="#">
					<img src="<?php echo of_get_option('right_sidebar_ad', 'no entry'); ?>" alt="">
				</a>
			</div>

			<a href="<?php echo bloginfo() ?>/curators/"><button type="button" class="btn btn-default curators">See Curators</button></a>	
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