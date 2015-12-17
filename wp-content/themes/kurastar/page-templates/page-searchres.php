<?php 

/*Template Name: Search Results*/

get_header(); ?>

<?php  
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    if($_GET['country'] != 'all' ||$_GET['country'] != '' ){
      $country = $_GET['country']; 
      echo $country;
    }
       
    if($_GET['category'] != 'all' || $_GET['category'] != ''){
      $category = $_GET['category']; 
      echo $category;
    }

    if($_GET['country'] == "select country"){
      $_GET['country'] = "";
    }
    if($_GET['category'] == "select category"){
      $_GET['category'] = "";
    }

    $args = args_func($_GET, $paged);

    if(isset($_GET['title'])) {
      if($_GET['title'] != '') {
          add_filter( 'posts_where', 'title_filter', 10, 2 );
          $query = new WP_Query($args);
          remove_filter( 'posts_where', 'title_filter', 10, 2 );
      }
    } else {
        $query = new WP_Query($args);
    }


    //static 9 is used because the value of post_per_page is 9;    
    $startpost = 1;
    $startpost = CUSTOM_POST_PER_PAGE * ($paged - 1) + 1;
    $endpost   = (CUSTOM_POST_PER_PAGE * $paged < $query->found_posts ? CUSTOM_POST_PER_PAGE * $paged : $query->found_posts);

 ?>
<div class="banner">
  
    <?php 
      /*
      * Search form
      * @hook: do_custom_search_form
      */
     ?>
    <?php echo do_shortcode( '[custom_search_form]' ) ?>
    
</div>
<?php if (  $query->have_posts() ) : ?>
<div class="defaultWidth center clear-auto bodycontent bodycontent-index result-page ">
    <div class="contentbox">
    <!-- Nav tabs -->
            <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                <?php if(function_exists('bcn_display'))
                {
                    bcn_display();
                }?>
            </div>
            <span class="search-results">
            Search
            <?php echo $query->post_count > 1 ? 'results' : 'result'?> 
            <?php echo 'for:' ?>
            <?php   
                if($_GET['country'] != 'all' ||$_GET['country'] != '' ){
                  $country = $_GET['country']; 
                  echo $country;
                }
                   
                if($_GET['category'] != 'all' || $_GET['category'] != ''){
                  $category = $_GET['category']; 
                  echo $category;
                }
            ?>
            </span>

            <!-- Tab panes -->
            <ul class="post-list-thumb">
              <div class="post-publish-wrapper">
              <?php
                while (  $query->have_posts() ) : $query->the_post(); 
              ?>

              <li>
                <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap">
                  <?php
                    //Returns All Term Items for "my_taxonomy"
                    $category        = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
                    $countries       = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));

                    $authorID        = get_the_author_meta($post->ID);
                    $curator_profile = get_cupp_meta($authorID, 'thumbnail');
                    
                  ?>
                  <div class="postimg" style="background: url(<?php echo getArticleImage($post->ID); ?>)"></div>
                  </a>
                  <div class="labels">
                        
                      <?php if($countries): ?>
                        <?php foreach($countries as $country): ?>
                          <a href="<?php echo '/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat'; ?>" class="countrylabel">
                            <i class="fa fa-map-marker"></i> 
                            <?php echo $country; ?>
                          </a>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <a href="#" class="countrylabel"><i class="fa fa-map-marker"> No Country</i></a>
                      <?php endif; ?>

                      <?php if($category): ?>
                        <?php foreach($category as $cat): ?>
                          <a href="<?php echo '/search-results/?country=select+country&category='.$cat.'&post_type=post+type+curators-cat'; ?>" class="catlabel">
                            <i class="<?php echo categoryLogo(array('category' => $cat)); ?>"></i> 
                            <?php echo $cat; ?>
                          </a>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <!-- <a href="#" class="catlabel"><i class="fa fa-hotel"></i> No Category</a> -->
                      <?php endif; ?>               
                    </div>
              </li>
              <?php  
                endwhile; wp_reset_postdata();
              ?>
              </div>
              <?php if ( $query->have_posts() && $query->found_posts > CUSTOM_POST_PER_PAGE) : ?>
                <!-- <p class="load-div">
                  <a class="custom-search custom-publish" href="#">
                  <span class="load-more">Load More</span></a>
                  <input type="hidden" class="custom-paged" value="0">
                </p> -->
                <a class="custom-defaultpagi custom-publish load-div" href="#">
                  <span class="load-more">Load More</span></a>
                  <input type="hidden" class="custom-paged" value="0">
                </a>
                <script type="text/javascript">
                /* <![CDATA[ */
                var custom_post_per_page = "<?php echo CUSTOM_POST_PER_PAGE;?>";
                /* ]]> */

                </script>
              <?php endif; ?>

            </ul>

    </div>
    <div class="sidebox">
      <div class="socketlabs">
        <a href="#">
          <img src="<?php echo of_get_option('right_sidebar_ad', 'no entry'); ?>" alt="">
        </a>
      </div>
      <a href="?<?php echo site_url() ?>/curator/"><button type="button" class="btn btn-default curators">See Curators</button></a>
      
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
<?php 
// Previous/next page navigation.
the_posts_pagination( array(
    'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
    'next_text'          => __( 'Next page', 'twentyfifteen' ),
    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
) );

// If no content, include the "No posts found" template.
else :
  get_template_part( 'content', 'none' );
endif;
        ?>


<?php get_footer(); ?>