<?php 
/*Template Name: Curators Page
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
<div class="defaultWidth center clear-auto bodycontent bodycontent-index ">
	<div class="contentbox">
		<div class="contentbox">
            <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                <?php if(function_exists('bcn_display'))
                {
                    bcn_display();
                }?>
            </div>
            <span class="search-results">
              Curator:
            </span>


            <!-- Tab panes -->
            <ul class="post-list-thumb curator-list-thumb">

            	<?php

              $users = get_users('orderby=nicename&post_per_page=2');   
           		// Start the Loop.
           		foreach($users as $user):
                
                $profile = getCurrentProfile(array('user_id' => $user->ID));
           			$post_count = count_user_posts($user->ID, 'acme_article');
           		?>
                <li>
                  <a href="<?php echo site_url(); ?>/curator-detail/?id=<?php echo $user->ID ?>" class="curator-list-thumb-wrap curator-list">
                    <div class="infobelow">
                      <div class="postimg user-<?php echo $user->ID ?>" style="background: url(<?php echo $profile; ?> )"></div>
                        <div class="curator-info">
                          <h4><?php echo $user->display_name; ?></h4>
                          <p><?php $description = get_user_meta($user->ID, 'description', true); 
                             if (strlen($description) > 80) {echo mb_strimwidth($description, 0, 65). '...'; } else {echo $description;}?></p>
                          <div class="clear"></div>
                        </div>
                      <span class="article-views smallpoints-right"><?php echo $post_count ?> <?php echo $post_count > 1 ? 'articles' : 'article'; ?></span>
                    </div>
                  </a>
                </li>
                 <?php endforeach;?>
            </ul>
		</div>
	</div>


	<div class="sidebox">
		<div class="socketlabs">
			<a href="#">
				<img src="<?php echo of_get_option('right_sidebar_ad', 'no entry'); ?>" alt="">
			</a>
		</div>

		<a href="<?php echo site_url() ?>/curators/"><button type="button" class="btn btn-default curators">See Curators</button></a>
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
<?php  get_footer(); ?>