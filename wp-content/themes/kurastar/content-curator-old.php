<?php
	/* 
	Template Name: Curator OLD
	*/
get_header();?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="defaultWidth center clear-auto bodycontent article-detail-page">
					<div class="contentbox">
						<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
			                <?php if(function_exists('bcn_display'))
			                {
			                    bcn_display();
			                }?>
			            </div>
						<div class="curator-detail-wrap article-detail-wrap">
							<div class="pointer2"></div>
							<?php
		                      $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
		                    ?>
		                    <a class="example-image-link" href="<?php echo $src[0]; ?>" data-lightbox="example-1"><div class="postimg postimg2" style="background: url(<?php echo $src[0]; ?> )"></div></a>
							<div class="labels">
								<span class="countrylabel"><i class="fa fa-map-marker"></i> フィリピン</span>
								<span class="catlabel"><i class="fa fa-hotel"></i> 観光</span>
							</div>
							<div class="curator-info">
								<h4><?php the_title(); ?></h4>
								<p><?php the_content(); ?></p>
							</div>
							<div class="infobelow">
								<ul class="social_reviews">
									<?php $row = 1; if(get_field('social_media_lists')): ?>
      									<?php while(has_sub_field('social_media_lists')): ?>
											<li><a href="<?php the_sub_field('social_link'); ?>">
												<img src="<?php the_sub_field('social_image');?>">
												<img src="<?php the_sub_field('social_image_likes');?>"></a>
											</li>
										<?php $row++; endwhile; ?>
									<?php endif; ?>
								</ul>
								<div class="profile-thumb-wrap">
									<?php $row = 1; if(get_field('article_curator_profile')): ?>
      									<?php while(has_sub_field('article_curator_profile')): ?>
											<img src="<?php the_sub_field('article_curator_profile_image'); ?>">
											<div class="curator">
												<span>CURATORS</span><br>
												<h3><?php the_sub_field('article_curator_profile_name'); ?></h3>
											</div>
										<?php $row++; endwhile; ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="clear"></div>
						</div>
						  <!-- Nav tabs -->
						  	<div class="curator-tabs">
							  <ul class="nav nav-tabs" role="tablist">
							    <li role="presentation"><a class="active" href="#drafts" aria-controls="home" role="tab" data-toggle="tab">DRAFTS</a></li>
							    <li role="presentation"><a href="#photo" aria-controls="profile" role="tab" data-toggle="tab">PHOTO</a></li>
							    <li role="presentation"><a href="#favorites" aria-controls="messages" role="tab" data-toggle="tab">FAVORITES</a></li>
							  </ul>

							  <!-- Tab panes -->
							  <div class="tab-content">
							    <div role="tabpanel" class="tab-pane active" id="drafts">
							    	<ul class="post-list-thumb">
									<?php
										query_posts( array( 'post_type' => 'acme_curator', 'posts_per_page' => '3' ) );
										  if ( have_posts() ) : while ( have_posts() ) : the_post();
										?>
										<li>
										  <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap">
							                    <?php
							                      $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
							                    ?>
							                    <div class="postimg" style="background: url(<?php echo $src[0]; ?> )"></div>
							                      <div class="labels">
							                        <span class="countrylabel"><i class="fa fa-map-marker"></i> フィリピン</span>
							                        <span class="catlabel"><i class="fa fa-hotel"></i> 観光</span>
							                      </div>
							                      <div class="desc">
							                        <h2><?php the_title(); ?></h2>
							                        <p><?php the_content(); ?></p>
							                      </div>
							                      <div class="infobelow">
							                        <i class="fa fa-heart"></i>
							                        <span class="smallpoints smallpoints-left">14,091 likes</span>
							                        <div class="profile-thumb-wrap">
							                          <span class="smallpoints smallpoints-left">999 views</span>
							                          <?php $row = 1; if(get_field('article_curator_profile')): ?>
							                              <?php while(has_sub_field('article_curator_profile')): ?>
							                                <img src="<?php the_sub_field('article_curator_profile_image'); ?>">
							                                <div class="curator">
							                                <span>CURATORS</span><br>
							                                <h3><?php the_sub_field('article_curator_profile_name'); ?></h3>
							                            </div>
							                            <?php $row++; endwhile; ?>
							                          <?php endif; ?>
							                        </div>
							                      </div>
							                    </a>
										</li>
									<?php endwhile; endif; wp_reset_query(); ?>
								</ul>
							    </div>
							    <div role="tabpanel" class="tab-pane" id="photo">
							    	<ul class="post-list-thumb">
									<?php
										query_posts( array( 'post_type' => 'acme_article', 'posts_per_page' => '3' ) );
										  if ( have_posts() ) : while ( have_posts() ) : the_post();
										?>
										<li>
										  <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap">
							                    <?php
							                      $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
							                    ?>
							                    <div class="postimg" style="background: url(<?php echo $src[0]; ?> )"></div>
							                      <div class="labels">
							                        <span class="countrylabel"><i class="fa fa-map-marker"></i> フィリピン</span>
							                        <span class="catlabel"><i class="fa fa-hotel"></i> 観光</span>
							                      </div>
							                      <div class="desc">
							                        <h2><?php the_title(); ?></h2>
							                        <p><?php the_content(); ?></p>
							                      </div>
							                      <div class="infobelow">
							                        <i class="fa fa-heart"></i>
							                        <span class="smallpoints smallpoints-left">14,091 likes</span>
							                        <div class="profile-thumb-wrap">
							                          <span class="smallpoints smallpoints-left">999 views</span>
							                          <?php $row = 1; if(get_field('article_curator_profile')): ?>
							                              <?php while(has_sub_field('article_curator_profile')): ?>
							                                <img src="<?php the_sub_field('article_curator_profile_image'); ?>">
							                                <div class="curator">
							                                <span>CURATORS</span><br>
							                                <h3><?php the_sub_field('article_curator_profile_name'); ?></h3>
							                            </div>
							                            <?php $row++; endwhile; ?>
							                          <?php endif; ?>
							                        </div>
							                      </div>
							                    </a>
										</li>
									<?php endwhile; endif; wp_reset_query(); ?>
								</ul>
							    </div>
							    <div role="tabpanel" class="tab-pane" id="favorites">
							    	<ul class="post-list-thumb">
									<?php
										query_posts( array( 'post_type' => 'acme_country', 'posts_per_page' => '3' ) );
										  if ( have_posts() ) : while ( have_posts() ) : the_post();
										?>
										<li>
										  <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap">
							                    <?php
							                      $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
							                    ?>
							                    <div class="postimg" style="background: url(<?php echo $src[0]; ?> )"></div>
							                      <div class="labels">
							                        <span class="countrylabel"><i class="fa fa-map-marker"></i> フィリピン</span>
							                        <span class="catlabel"><i class="fa fa-hotel"></i> 観光</span>
							                      </div>
							                      <div class="desc">
							                        <h2><?php the_title(); ?></h2>
							                        <p><?php the_content(); ?></p>
							                      </div>
							                      <div class="infobelow">
							                        <i class="fa fa-heart"></i>
							                        <span class="smallpoints smallpoints-left">14,091 likes</span>
							                        <div class="profile-thumb-wrap">
							                          <span class="smallpoints smallpoints-left">999 views</span>
							                          <?php $row = 1; if(get_field('article_curator_profile')): ?>
							                              <?php while(has_sub_field('article_curator_profile')): ?>
							                                <img src="<?php the_sub_field('article_curator_profile_image'); ?>">
							                                <div class="curator">
							                                <span>CURATORS</span><br>
							                                <h3><?php the_sub_field('article_curator_profile_name'); ?></h3>
							                            </div>
							                            <?php $row++; endwhile; ?>
							                          <?php endif; ?>
							                        </div>
							                      </div>
							                    </a>
										</li>
									<?php endwhile; endif; wp_reset_query(); ?>
								</ul>
							    </div>
							  </div>
							</div>	
	</div>
	<div class="sidebox">
		<div class="socketlabs">
			<a href="#">
				<img src="<?php echo get_template_directory_uri(); ?>/images/socketlabs.jpg" alt="">
			</a>
		</div>
		<a href="http://wpkurastar.local/curators-cat/curators"><button type="button" class="btn btn-default curators">See Curators</button></a>
		<div class="sideboxcontent ad300">
			<img src="<?php echo get_template_directory_uri(); ?>/images/300x300.jpg" />
		</div>
		<?php dynamic_sidebar('sidebar-1'); ?>
		<?php dynamic_sidebar('sidebar-2'); ?>
	</div>
</div>

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<footer class="entry-footer">
		<?php twentyfifteen_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
<?php get_footer(); ?>
