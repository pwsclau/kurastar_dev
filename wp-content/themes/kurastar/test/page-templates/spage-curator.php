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


$args = array(
      'post_type'      => 'acme_article',
      'author'         => $user->ID,
      'orderby'        => 'post_date',
      'order'          => 'ASC',
      'posts_per_page' => -1
    );

$posts = get_posts($args);
$curator_profile = get_avatar_url(get_avatar( $current_user->ID ));


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
<div class="defaultWidth center clear-auto bodycontent bodycontent-index ">
	<div class="contentbox">
      <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
          <?php if(function_exists('bcn_display'))
          {
              bcn_display();
          }?>
      </div>
      <div class="curator-detail-wrap">
        <div class="pointer2"></div>
        
        
        <?php if(get_the_author_meta( 'profile_url', $user->ID )){ ?>
            <img id="blah"  src="<?php echo get_the_author_meta( 'profile_url', $user->ID ); ?>" class="avatar avatar-96 photo" height="96" width="96">
        <?php }else{ ?>
            <img id="blah"  src="<?php echo $curator_profile; ?>" class="avatar avatar-96 photo" height="96" width="96">
        <?php } ?>
        <div class="labels labels2">
          <span class="countrylabel"><b><?php echo $user_posts ?></b> <?php echo $user_posts > 1 ? 'Articles' : 'Article'?></span>
          <span class="catlabel"><b><?php echo count_user_favorites($user->ID) ?></b> Favorites
          </span>
        </div>
        <div class="curator-info">

          <form method="POST" id="form-curator-info" enctype="multipart/form-data">
            <div class="user_details">
              <span id="edit-form">
                <h4>
                 <?php echo $user->display_name ?> </h4>
                <p > <?php echo get_the_author_meta( 'description', $user->ID ) ?></p>
              </span>
              <?php if ( is_user_logged_in() ) : ?>
              <!-- <span class="catlabel"> <a href="<?php echo get_edit_user_link( $current_user->ID ); ?>"><b>Edit</b> </a></span> -->
              <span class="catlabel"><a href="#" class="edit">Edit</a> </span>
   <!--       <span id="edit" class="catlabel"><b>Edit</b> </span>
              <span id="save" class="catlabel"><b>Save</b> </span> -->
              <?php endif; ?>
            </div>
            <div style="display:none;" class="userinfo_section">
              <div class="row">
                <div class="form-grp form-placeholder-offset">
                  <img src="<?php echo get_template_directory_uri().'/images/icons/camera.png'; ?>" id="image-button" class="avatar avatar-96 photo" style="height:10; width:10; display: none; ">
                  <input type="file" name="profile" id="imgInp" accept="image/*" class="form-control form-control-stroked" style="visibility: hidden;">
                  <input type="text" name="full_name" class="form-control form-control-stroked" id="full_name" placeholder="Full Name" value="<?php echo $user->display_name ?>">
                </div>
              </div>
               <div class="row">
                <div class="form-grp form-placeholder-offset">
                  <textarea name="user_description" class="form-control form-control-stroked"><?php echo get_the_author_meta( 'description', $user->ID ) ?></textarea>
                </div>
              </div>
               <input type="hidden" name="update_user_info" value="_update_user_info">
               <input type="hidden" name="user_id" value="<?php echo $user->ID ?>">
               <a href="#" class="btn catlabel update_user_info"><?php _e('Save', 'wp') ?></a>
               <a href="#" class="btn catlabel cancel_user_info"><?php _e('Cancel', 'wp') ?></a>
            </div>
            <div class="clear"></div>
          </form>
        </div>
        <div class="points-detail">
          <?php echo do_shortcode( '[post_view]' ); ?><span>points</span>
        </div>
        <div class="clear"></div>
      </div>
              

    <div class="tab-form-panel">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs curator-tabs" role="tablist">
        <li role="presentation" class="active curator-tab-list">
          <a href="#1" aria-controls="1" role="tab" data-toggle="tab">Articles</a>
        </li>
        <li role="presentation" class="curator-tab-list">
          <a href="#2" aria-controls="2" role="tab" data-toggle="tab">Favorites</a>
        </li>
        <li role="presentation" class="curator-tab-list">
          <a href="#3" aria-controls="3" role="tab" data-toggle="tab">Draft</a>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content curator-tab-content curator-tab-content">
        <div role="tabpanel" class="tab-pane active" id="1">
          <ul class="post-list-thumb">
          <?php
             # get_wpposts();
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $param = array( 
                    'post_type'       => 'acme_article', 
                    'posts_per_page'  => 6, 
                    'paged'           => $paged, 
                    'author'          => $user->ID, 
                    'orderby'         => 'post_date',
                    'order'           => 'DESC');

              query_posts( $param );
              if ( have_posts() ) : while ( have_posts() ) : the_post();
          ?>
            <li class="list-thumb">
              <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap post-id<?php echo $post->ID ?>">
              <?php
                $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
                
                //Returns All Term Items for "my_taxonomy"
                $category = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
                $countries  = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));

                $authorID = get_the_author_meta($post->ID);
                $curator_profile = get_cupp_meta($authorID, 'thumbnail');

                $custom_image_link =  get_post_meta( $post->ID, '_custom_image_link', true);

              ?>
              <div class="postimg" style="background: url(<?php echo $custom_image_link != '' ? $custom_image_link : $src[0]; ?> )"></div>
                <div class="labels">

                  <?php if($countries): ?>
                    <?php foreach($countries as $country): ?>
                      <span class="countrylabel"><i class="fa fa-map-marker"></i> <?php echo $country; //フィリピン ?></span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="countrylabel"><i class="fa fa-map-marker"> No Country</i></span>
                  <?php endif; ?>

                  <?php if($category): ?>
                    <?php foreach($category as $cat): ?>
                      <span class="catlabel"><i class="<?php echo categoryLogo(array('category' => $cat)); ?>"></i> <?php echo $cat; //観光 ?> </span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <!-- <span class="catlabel"><i class="fa fa-hotel"></i> No Category</span> -->
                  <?php endif; ?>               
                </div>
                <!-- <div class="desc">
                  <h2><?php the_title(); ?></h2>
                 <p><?php the_content(); ?></p>
                </div> -->
                <!-- <div class="infobelow">
                  <i class="fa fa-heart"></i>
                  <span class="smallpoints smallpoints-left"><?php echo count_total_favorites($post->ID) ?>  likes</span>
                  <div class="profile-thumb-wrap">

                      <span class="smallpoints smallpoints-left"><?php echo do_shortcode( '[post_view]' ); ?> views</span>

                      <img src="<?php echo $curator_profile ?>">
                      <div class="curator">
                          <span>CURATORS</span><br>
                          <a href="<?php echo site_url() ?>/curator-detail/?id=<?php echo get_the_author_meta( 'ID' ) ?>"><h3><?php the_author() ?></h3></a>
                      </div>


                  </div>
                </div> -->
              </a>
            </li>

          
          <?php 
          endwhile ;   
          else:?>
          <li><p> No available articles.</p></li>
          <?php endif;  

          //wp pagenavi plugin for pagination   
            if(function_exists("wp_pagenavi")):

              wp_pagenavi(); 

            endif;  

           wp_reset_query();?>
          </ul>
        </div><!--tab 1-->
        <div role="tabpanel" class="tab-pane" id="2">
           <?php 


          $fav_args = array(
                  'post_type'       => 'acme_article', 
                  'posts_per_page'  => -1, 
                  'meta_query'        => array(
                    'relation'  => 'AND',
                      array(
                          'key' => '_user_liked',
                          'value' => $user->ID,
                          'compare' => '='
                      )
                  )
              );


             ?>
            <ul class="post-list-thumb">
             
                <?php 

                 query_posts( $fav_args );
              if ( have_posts() ) : while ( have_posts() ) : the_post();
              ?>  
              <li>
              <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap post-id<?php echo $post->ID ?>">
              <?php
                $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
                
                //Returns All Term Items for "my_taxonomy"
                $category          = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
                $countries         = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));
                $authorID          = get_the_author_meta($post->ID);
                // $curator_profile   = get_cupp_meta($authorID, 'thumbnail');
                $curator_profile   = get_avatar( $authorID );
                $custom_image_link = get_post_meta( $post->ID, '_custom_image_link', true);

              ?>
              <div class="postimg" style="background: url(<?php echo $custom_image_link != '' ? $custom_image_link : $src[0]; ?> )"></div>
                <div class="labels">

                  <?php if($countries): ?>
                    <?php foreach($countries as $country): ?>
                      <span class="countrylabel"><i class="fa fa-map-marker"></i> <?php echo $country; //フィリピン ?></span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="countrylabel"><i class="fa fa-map-marker"> No Country</i></span>
                  <?php endif; ?>

                  <?php if($category): ?>
                    <?php foreach($category as $cat): ?>
                      <span class="catlabel"><i class="<?php echo categoryLogo(array('category' => $cat)); ?>"></i> <?php echo $cat; //観光 ?> </span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <!-- <span class="catlabel"><i class="fa fa-hotel"></i> No Category</span> -->
                  <?php endif; ?>               
                </div>
               <!--  <div class="desc">
                  <h2><?php the_title(); ?></h2>
                  <p><?php the_content(); ?></p>
                </div> -->
                <!-- <div class="infobelow">
                  <i class="fa fa-heart"></i>
                  <span class="smallpoints smallpoints-left"><?php echo count_total_favorites($post->ID) ?>  likes</span>
                  <div class="profile-thumb-wrap">

                      <span class="smallpoints smallpoints-left"><?php echo do_shortcode( '[post_view]' ); ?> views</span>

                      <?php echo $curator_profile ?>
                      <div class="curator">
                          <span>CURATORS</span><br>
                          <a href="<?php echo site_url() ?>/curator-detail/?id=<?php echo get_the_author_meta( 'ID' ) ?>"><h3><?php the_author() ?></h3></a>
                      </div>
                  </div>
                </div> -->
              </a>
            </li>
              <?php
 
                
              endwhile;
               else:?>
              <li><p> No available articles.</p></li>
              <?php endif;  

              //wp pagenavi plugin for pagination   
                if(function_exists("wp_pagenavi")):

                  wp_pagenavi(); 

                endif;  

               wp_reset_query();?>
           

                 ?>
             
            </ul>
        </div><!--tab 2-->
        <div role="tabpanel" class="tab-pane" id="3">
           <ul class="post-list-thumb">
          <?php
             # get_wpposts();
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $param = array( 
                    'post_type'       => 'acme_article', 
                    'posts_per_page'  => 6, 
                    'paged'           => $paged, 
                    'author'          => $user->ID, 
                    'post_status'     => 'draft',
                    'orderby'         => 'post_date',
                    'order'           => 'DESC');

              query_posts( $param );
              if ( have_posts() ) : while ( have_posts() ) : the_post();
          ?>
            <li>
              <a href="<?php echo get_permalink(); ?>" class="post-list-thumb-wrap post-id<?php echo $post->ID ?>">
              <?php
                $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
                
                //Returns All Term Items for "my_taxonomy"
                $category = wp_get_post_terms($post->ID, 'article_cat', array("fields" => "names"));
                $countries  = wp_get_post_terms($post->ID, 'article_country_cat', array("fields" => "names"));

                $authorID = get_the_author_meta($post->ID);
                $curator_profile = get_cupp_meta($authorID, 'thumbnail');

                $custom_image_link =  get_post_meta( $post->ID, '_custom_image_link', true);

              ?>
              <div class="postimg" style="background: url(<?php echo $custom_image_link != '' ? $custom_image_link : $src[0]; ?> )"></div>
                <div class="labels">

                  <?php if($countries): ?>
                    <?php foreach($countries as $country): ?>
                      <span class="countrylabel"><i class="fa fa-map-marker"></i> <?php echo $country; //フィリピン ?></span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="countrylabel"><i class="fa fa-map-marker"> No Country</i></span>
                  <?php endif; ?>

                  <?php if($category): ?>
                    <?php foreach($category as $cat): ?>
                      <span class="catlabel"><i class="<?php echo categoryLogo(array('category' => $cat)); ?>"></i> <?php echo $cat; //観光 ?> </span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <!-- <span class="catlabel"><i class="fa fa-hotel"></i> No Category</span> -->
                  <?php endif; ?>               
                </div>
                <!-- <div class="desc">
                  <h2><?php the_title(); ?></h2>
                  <p><?php the_content(); ?></p>
                </div> -->
                <!-- <div class="infobelow">
                  <i class="fa fa-heart"></i>
                  <span class="smallpoints smallpoints-left"><?php echo count_total_favorites($post->ID) ?>  likes</span>
                  <div class="profile-thumb-wrap">

                      <span class="smallpoints smallpoints-left"><?php echo do_shortcode( '[post_view]' ); ?> views</span>

                      <img src="<?php echo $curator_profile ?>">
                      <div class="curator">
                          <span>CURATORS</span><br>
                          <a href="<?php echo site_url() ?>/curator-detail/?id=<?php echo get_the_author_meta( 'ID' ) ?>"><h3><?php the_author() ?></h3></a>
                      </div>
                  </div>
                </div> -->
                
              </a>
            </li>

          
          <?php 
          endwhile ;   
          else:?>
          <li><p> No available articles.</p></li>
          <?php endif;  

          //wp pagenavi plugin for pagination   
            if(function_exists("wp_pagenavi")):

              wp_pagenavi(); 

            endif;  

           wp_reset_query();?>
          </ul>
        </div><!--tab 3-->
      </div>
    </div>

	</div>


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
		?>
	</div>	

	
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$(function(){



      $(document).on('mouseenter', "#blah", function(e) {
        $( "#image-button" ).show();
      }).on('mouseleave', "#blah", function(e) {    
        $('#image-button').fadeOut('slow');
      });

      $(document).on('click', "#image-button", function(e) {
        $('#imgInp').trigger('click');
      });

      function readURL(input) {

          if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function (e) {
                  $('#blah').attr('src', e.target.result);
              }

              reader.readAsDataURL(input.files[0]);
          }
      }

      // $("#imgInp").change(function(){
      $(document).on('change', "#imgInp", function(e) {
          readURL(this);
      });
  
     $(document).on('click', ".edit", function(e) {
         e.preventDefault();

         $('.user_details').hide();
         $('.userinfo_section').show();

     });

     $(document).on('click', ".update_user_info", function() {

        if (confirm("Are you sure you want to save the chages?") == true) {

          $('#form-curator-info').submit();

        } else {

          cancellation();
            
        }

     });

    $(document).on('click', ".cancel_user_info", function(e) {
         e.preventDefault();

         cancellation();
     });

     
     function cancellation() {

         $('.userinfo_section').hide();
         $('.user_details').show();

     }

});
</script>
<?php 
get_footer();?>
