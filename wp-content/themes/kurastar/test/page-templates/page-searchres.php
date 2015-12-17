<?php 

/*Template Name: Search Results*/

get_header(); ?>

<?php  
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $args = args_func($_GET, $paged); 
    $query = new WP_Query($args);

    //static 9 is used because the value of post_per_page is 9;    
    $startpost=1;
    $startpost=9*($paged - 1)+1;
    $endpost = (9*$paged < $query->found_posts ? 9*$paged : $query->found_posts);

 ?>
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
            <?php   
              if(isset($_GET['country'])){
                if($_GET['country'] != 'all'){
                  $country = $_GET['country']; 
                }
                if($_GET['country'] == 'select country'){
                  $country = 'All'; 
                }
              }

              if(isset($_GET['category'])){
                if($_GET['category'] != 'all'){
                  $category = $_GET['category']; 
                }
                if($_GET['category'] != 'select category'){
                  $category = $_GET['category']; 
                }else{
                  $category = ''; 
                }
              }
              echo $country.' '.$category; 
            ?>
            <!-- フィリピン, グルメ  -->
            <?php echo $query->post_count > 1 ? 'results' : 'result'?> (<?php echo $startpost.'-'.$endpost.' of '.$query->found_posts ?> <?php echo $query->post_count > 1 ? 'items' : 'item' ?>):

            </span>

            <!-- Tab panes -->
            <ul class="post-list-thumb">
              <?php
                while (  $query->have_posts() ) : $query->the_post(); 
              ?>

              <li>
                <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap">
                  <?php
                    $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
                    
                    //Returns All Term Items for "my_taxonomy"
                    $category = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
                    $countries  = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));

                    $authorID = get_the_author_meta($post->ID);
                    $curator_profile = get_cupp_meta($authorID, 'thumbnail');
                    
                  ?>
                  <div class="postimg" style="background: url(<?php echo $src[0]; ?> )"></div>
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
                endwhile;

                //wp pagenavi plugin for pagination   
                if(function_exists("wp_pagenavi")):

                 wp_pagenavi( array( 'query' => $query ) ); 

                endif;  

               wp_reset_query();?>
              ?>
            </ul>

    </div>
    <div class="sidebox">
      <div class="socketlabs">
        <a href="#">
          <img src="<?php echo get_template_directory_uri(); ?>/images/socketlabs.jpg" alt="">
        </a>
      </div>
      <a href="?<?php echo site_url() ?>/curator/"><button type="button" class="btn btn-default curators">See Curators</button></a>
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