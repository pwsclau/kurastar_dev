<?php 
/*Template Name: Curator Page
*/
get_header(); 

 $user_id = $_GET['id'];

 if(!$user_id) {
    wp_redirect( '/curators' ); exit();
 } 

$user = get_userdata( $user_id );
if ( $user === false ) {
  wp_redirect( '/curators' ); exit();
} 


$user_posts = count_user_posts($user->ID, 'acme_article');

// x
$args = array(
      'post_type'      => 'acme_article',
      'author'         => $user->ID,
      'orderby'        => 'post_date',
      'order'          => 'ASC',
      'posts_per_page' => -1
    );

$posts = get_posts($args);
$curator_profile = get_avatar_url(get_avatar( $user->ID ));


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
<div class="defaultWidth center clear-auto bodycontent bodycontent-index ">
  <div class="contentbox">

      <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
          <?php echo function_exists('custom_breadcrumb') ? custom_breadcrumb() : ''; ?>
     </div><!-- .breadcrumb -->';

      <div class="curator-detail-wrap">

        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="pointer2"></div>
        <?php $profile = getCurrentProfile(array( 'user_id' => $user->ID )); ?>
        
          <?php 
            $current_user_id = get_current_user_id();
            if($current_user_id == $user->ID){ 
          ?>
            <div class="img-round cur-pic">
                  <img id="uploaded_image"  src="<?php echo $profile; ?>" class="avatar avatar-96 photo " >
                  <span class="icon-cam-holder">
                    <img src="<?php echo get_template_directory_uri().'/images/icons/camera.png'; ?>" id="change-image" class="avatar avatar-96 photo">
                  </span>
            </div>
          <?php }else{ ?>
            <div class="img-round">
                <img id="uploaded_image"  src="<?php echo $profile; ?>" class="avatar avatar-96 photo " height="96" width="96" >
            </div>
          <?php } ?>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-8">

            <div class="article-content">
              <div class="labels labels2">
                <span class="countrylabel"><b><?php echo $user_posts ?></b> <?php echo $user_posts > 1 ? 'Articles' : 'Article'?></span>
                <span class="catlabel"><b><?php echo count_user_favorites($user->ID) ?></b> Favorites </span>
              </div>

              <div class="curator-info">
                <form method="POST" id="edit-custom-form" enctype="multipart/form-data">
                  <div class="display_details">
                    <span id="edit-form">
                      <h4>
                          <?php echo $user->display_name ?> 
                      </h4>
                      <?php
                        $start  = get_the_author_meta( 'description', $user->ID );
                        $seemore = "";
                        $end     = "";

                         if (strlen($start) > 200) { 
                            $original        = $start;
                            $length_of_title = strlen($start);
                            $divided         = $length_of_title - 200;
                            // truncate string
                            $start           = substr($original, 0, 200);
                            $end             = substr($original, 200, $length_of_title);
                            // make sure it ends in a word so assassinate doesn't become an ass...
                            $seemore     = "<a href='#' id='seemore-button' title='view details'>...read more</a>";
                          }
                          
                      ?>
                      <p> <?php echo $start; ?><span id="seemore" style="display: none;"><?php echo $end; ?>.</span> <?php echo $seemore; ?></p>
                    </span>
                    <?php 

                      $current_user    = wp_get_current_user(); 
                    ?>
                    <?php if(is_user_logged_in() && $current_user->ID == $user->ID) : ?>
                      <span class="catlabel"><a href="#" class="edit-custom-form">Edit</a> </span>
                    <?php endif; ?>
                  </div>

                  <!-- <div style="display:none;" class="userinfo_section"> -->
                  <div style="display:none;" class="display_section">
                    <div class="row">
                      <div class="form-grp form-placeholder-offset input-user">
                        <input type="file" name="profile" id="post_image" accept="image/*" class="form-control form-control-stroked" style="visibility: hidden;">
                        <input type="text" name="full_name" class="form-control form-control-stroked" id="full_name" placeholder="Full Name" value="<?php echo $user->display_name ?>">

                      </div>
                    </div>
                     <div class="row">
                      <div class="form-grp form-placeholder-offset desc-user">
                        <?php $settings = array(
                          'wpautop' => true,
                          'media_buttons' => false,
                          'tinymce' => array(
                          'theme_advanced_buttons1' => 'bold,italic,underline,blockquote,|,undo,redo,|,fullscreen',
                          'theme_advanced_buttons2' => '',
                          'theme_advanced_buttons3' => '',
                          'theme_advanced_buttons4' => ''
                          ),
                          'quicktags' => array(
                          'buttons' => 'b,i,ul,ol,li,link,close'
                          )
                          );     
                        ?>
                        <?php  wp_editor(get_the_author_meta( 'description', $user->ID ), 'user_description', $settings ); ?>

                    </div>
                    </div>
                     <input type="hidden" name="update_user_info" value="_update_user_info">
                     <input type="hidden" name="user_id" value="<?php echo $user->ID ?>">
                     <a href="#" class="btn catlabel update_process"><?php _e('Save', 'wp') ?></a>
                     <a href="#" class="btn catlabel cancel_process"><?php _e('Cancel', 'wp') ?></a>
                  </div>
                  <div class="clear"></div>
                </form>
              </div>

              <div class="points-detail">
                0<span>View</span>
               <?php //echo get_post_views($post->ID); ?>
              </div>
            <div class="clear"></div>
              </div>
          </div>
        </div>
            
            
        

          
      </div>
        
    <?php
      if(isset($_GET['status'])){

        if($_GET['status'] == 'publish'){
            $articles = 'active';
        }elseif($_GET['status'] == 'draft'){
            $draft = 'active';
        }

      }else{
         $articles = 'active';
      }

      if(!isset($draft)){
        $draft = '';
      }
      if(!isset($articles)){
        $articles = '';
      }
    ?>
    <div class="tab-form-panel">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs curator-tabs" role="tablist">
        <li role="presentation" class="<?php echo $articles;  ?> curator-tab-list">
          <a href="#1" aria-controls="1" role="tab" data-toggle="tab">Articles</a>
        </li>
        <li role="presentation" class="curator-tab-list">
          <a href="#2" aria-controls="2" role="tab" data-toggle="tab">Favorites</a>
        </li>

        <li role="presentation" class="<?php echo $draft; ?> curator-tab-list">
          <a href="#3" aria-controls="3" role="tab" data-toggle="tab">Drafts</a>
        </li>
      </ul>


      <!-- ARTICLES -->

      <!-- Tab panes -->
      <div class="tab-content curator-tab-content curator-tab-content">
        <div role="tabpanel" class="tab-pane <?php echo $articles; ?>" id="1">
          <ul class="post-list-thumb post-publish">
             <div class="post-publish-wrapper"> 
          <?php

            $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
            $param = array( 
                    'post_type'       => 'acme_article', 
                    'posts_per_page'  => CUSTOM_POST_PER_PAGE, 
                    'paged'           => $paged, 
                    'author'          => $user->ID, 
                    'post_status'     => 'publish',
                    'orderby'         => 'post_date',
                    'order'           => 'DESC');

            $wp_query = new WP_Query( $param );


              if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
          ?>
           
              <li id="post-publish-<?php echo the_ID() ?>" class="post-publish-<?php echo the_ID() ?> post-publish-list list-thumb">
                <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap post-id<?php echo $post->ID ?>">
                <?php
                  //Returns All Term Items for "my_taxonomy"
                  $category = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
                  $countries  = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));

                  $authorID = get_the_author_meta($post->ID);
                  $curator_profile = get_cupp_meta($authorID, 'thumbnail');

                  $custom_image_link =  get_post_meta( $post->ID, '_custom_image_link', true);

                ?>
                <div class="postimg" style="background: url(<?php echo getArticleImage($post->ID); ?>)"></div>
                  
                </a>
                <div class="labels">

                    <?php if($countries): ?>
                      <?php foreach($countries as $country): ?>
                        <a href="<?php echo '/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat'; ?>" class="countrylabel">
                          <i class="fa fa-map-marker"></i> 
                          <?php echo $country; //フィリピン ?>
                        </a>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <!-- <a href="#" class="countrylabel"><i class="fa fa-map-marker"> No Country</i></a> -->
                    <?php endif; ?>

                    <?php if($category): ?>
                      <?php foreach($category as $cat): ?>
                        <a href="<?php echo '/search-results/?country=select+country&category='.$cat.'&post_type=post+type+curators-cat'; ?>" class="catlabel">
                          <i class="<?php echo categoryLogo(array('category' => $cat)); ?>"></i> 
                          <?php echo $cat; //観光 ?> 
                        </a>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <!-- <a href="#" class="catlabel"><i class="fa fa-hotel"></i> No Category</a> -->
                    <?php endif; ?>               
                  </div>
              </li>
          
             
          
          <?php 
          endwhile ;   
          else:?>
          <li><p> No available articles.</p></li>
          <?php endif;   
           wp_reset_postdata();
           ?>
             </div>
             <?php if ( $wp_query->have_posts() && $wp_query->found_posts > CUSTOM_POST_PER_PAGE) : ?>
             <!-- <p class="load-div load-publish">
              <a class="custom custom-publish" href="#" data-slug="curator-detail" data-post-type="acme_article" data-post-per-page="2" data-paged="1" data-author="<?php echo $user->ID ?>" data-status="publish" data-orderby="post_date" data-order="DESC">
                <span class="load-more">Load More</span></a>
                <input type="hidden" class="custom-publish-pp" value="<?php echo $paged ?>">
              </p> -->
              <a class="custom-defaultpagi custom-publish load-div" href="#">
                <span class="load-more">Load More</span></a>
                <input type="hidden" class="custom-paged" value="0">
              </a>
            <?php endif; ?>
          </ul>
        </div>
        
        
        <!-- FAVORITES -->
        <!--tab 1-->
        <div role="tabpanel" class="tab-pane" id="2">

            <ul class="post-list-thumb post-favorite">
             <div class="post-favorite-wrapper">
           <?php 
            $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;

            $fav_args = array(
                  'post_type'       => 'acme_article', 
                  'posts_per_page'  => CUSTOM_POST_PER_PAGE, 
                  'paged'           => $paged, 
                  'meta_query'        => array(
                    'relation'  => 'AND',
                      array(
                          'key' => '_user_liked',
                          'value' => $user->ID,
                          'compare' => '='
                      )
                  )
              );

              //    query_posts( $fav_args );
              // if ( have_posts() ) : while ( have_posts() ) : the_post();

              $query_favorite = new WP_Query( $fav_args );

              if ( $query_favorite->have_posts() ) : while ( $query_favorite->have_posts() ) : $query_favorite->the_post();
              //Returns All Term Items for "my_taxonomy"
                $category          = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
                $countries         = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));
                $authorID          = get_the_author_meta($post->ID);
                // $curator_profile   = get_cupp_meta($authorID, 'thumbnail');
                $curator_profile   = get_avatar( $authorID );
                $custom_image_link = get_post_meta( $post->ID, '_custom_image_link', true);

              ?>  
              <li id="post-favorite-<?php echo the_ID() ?>" class="post-favorite-<?php echo the_ID() ?> post-favorite-list list-thumb">
              <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap post-id<?php echo $post->ID ?>">
              <div class="postimg" style="background: url(<?php echo getArticleImage($post->ID); ?>)"></div>
                
              </a>
              <div class="labels">
                  <?php if($countries): ?>
                    <?php foreach($countries as $country): ?>
                      <a href="<?php echo '/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat'; ?>" class="countrylabel">
                        <i class="fa fa-map-marker"></i> 
                        <?php echo $country; //フィリピン ?>
                      </a>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <a href="#" class="countrylabel"><i class="fa fa-map-marker"> No Country</i></a>
                  <?php endif; ?>
                  <?php if($category): ?>
                    <?php foreach($category as $cat): ?>
                      <a href="<?php echo '/search-results/?country=select+country&category='.$cat.'&post_type=post+type+curators-cat'; ?>" class="catlabel">
                        <i class="<?php echo categoryLogo(array('category' => $cat)); ?>"></i> 
                        <?php echo $cat; //観光 ?> 
                      </a>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <a href="#" class="catlabel"><i class="fa fa-hotel"></i> No Category</a>
                  <?php endif; ?>               
                </div>
            </li>
              <?php
              endwhile;
               else:?>
              <li><p> No available articles.</p></li>
              <?php endif;  

               wp_reset_postdata();
               ?>
                </div>
                <?php if($query_favorite->have_posts() && $query_favorite->found_posts > CUSTOM_POST_PER_PAGE): ?>
                 <!-- <p class="load-div load-favorite">
                  <a class="custom-favpagi custom-favorite" href="#" data-slug="curator-detail" data-author="<?php echo $user->ID ?>" data-status="favorite">
                    <span class="load-more">Load More</span></a>
                    <input type="hidden" class="custom-favorite-pp" value="<?php echo $paged ?>">
                  </p> -->
                  <a class="custom-defaultpagi custom-publish load-div" href="#">
                    <span class="load-more">Load More</span></a>
                    <input type="hidden" class="custom-paged" value="0">
                  </a>
                <?php endif; ?>
            </ul>
        </div>
        
        <!-- DRAFT -->
        <!--tab 2-->
        <div role="tabpanel" class="tab-pane <?php echo $draft; ?>" id="3">
           <ul class="post-list-thumb post-draft">
            <div class="post-draft-wrapper">
          <?php
  
            $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
            $param = array( 
                    'post_type'       => 'acme_article', 
                    'posts_per_page'  => CUSTOM_POST_PER_PAGE, 
                    'paged'           => $paged, 
                    'author'          => $user->ID, 
                    'post_status'     => 'draft',
                    'orderby'         => 'post_date',
                    'order'           => 'DESC');


            $query_draft = new WP_Query( $param );

              if ( $query_draft->have_posts() ) : while ( $query_draft->have_posts() ) : $query_draft->the_post();

               //Returns All Term Items for "my_taxonomy"
                $category = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
                $countries  = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));

                $authorID = get_the_author_meta($post->ID);
                $curator_profile = get_cupp_meta($authorID, 'thumbnail');

                $custom_image_link =  get_post_meta( $post->ID, '_custom_image_link', true);

            ?>
            <li id="post-draft-<?php echo the_ID() ?>" class="post-draft-<?php echo the_ID() ?> post-draft-list list-thumb">
              <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap post-id<?php echo $post->ID ?>">
              <div class="postimg" style="background: url(<?php echo getArticleImage($post->ID); ?>)"></div>
                
              </a>
              <div class="labels">

                  <?php if($countries): ?>
                    <?php foreach($countries as $country): ?>
                      <a href="<?php echo '/search-results/?country='.$country.'&category=select+category&post_type=post+type+curators-cat'; ?>" class="countrylabel">
                        <i class="fa fa-map-marker"></i> 
                        <?php echo $country; //フィリピン ?>
                      </a>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <a href="#" class="countrylabel"><i class="fa fa-map-marker"> No Country</i></a>
                  <?php endif; ?>

                  <?php if($category): ?>
                    <?php foreach($category as $cat): ?>
                      <a href="<?php echo '/search-results/?country=select+country&category='.$cat.'&post_type=post+type+curators-cat'; ?>" class="catlabel">
                        <i class="<?php echo categoryLogo(array('category' => $cat)); ?>"></i> 
                        <?php echo $cat; //観光 ?> 
                      </a>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <a href="#" class="catlabel"><i class="fa fa-hotel"></i> No Category</a>
                  <?php endif; ?>               
                </div>
            </li>

          
          <?php 
          endwhile ;   
          else:?>
          <li><p> No available articles.</p></li>
          <?php endif;  
           wp_reset_postdata();?>
            </div>
            <?php if ( $query_draft->have_posts() && $query_draft->found_posts > CUSTOM_POST_PER_PAGE) : ?>
             <!-- <p class="load-div load-draft">
              <a class="custom custom-draft" href="#" data-slug="curator-detail" data-post-type="acme_article" data-post-per-page="2" data-paged="1" data-author="<?php echo $user->ID ?>" data-status="draft" data-orderby="post_date" data-order="DESC">
                <span class="load-more">Load More</span></a>
                <input type="hidden" class="custom-draft-pp" value="<?php echo $paged ?>">
              </p> -->
              <a class="custom-defaultpagi custom-publish load-div" href="#">
                <span class="load-more">Load More</span></a>
                <input type="hidden" class="custom-paged" value="0">
              </a>
             <?php  endif; ?>
          </ul>
        </div><!--tab 3-->
      </div>
    </div>

  </div>


  <div class="sidebox">
    <div class="socketlabs">
      <a href="#">
        <img src="<?php echo of_get_option('right_sidebar_ad', 'no entry'); ?>" alt="">
      </a>
    </div>

    <a href="<?php echo site_url() ?>/curator/"><button type="button" class="btn btn-default curators">See Curators</button></a>
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
    ?>
  </div>  

  
</div>
<script type="text/javascript">


</script>
<?php 
get_footer();