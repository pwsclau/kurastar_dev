<?php 

if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

if ( ! function_exists('array_get') ) {
  function array_get($arr, $key, $default = null, $echo = false) {
    $out = $default;

    if ( isset($arr[$key]) ) {
      $out = $arr[$key];
    } 

    if ( ! $echo ) {
      return $out;
    }

    echo $out;
  }
}


if ( ! function_exists(('check_form_nonce')) ) {
    function check_form_nonce($field) {

        $nonce = $_REQUEST['_wpnonce'];
                
        if ( !wp_verify_nonce( $nonce, $field ) ) {

           $flash_message = new Flash_Message();

           $flash_message->set(__('Cheating?', 'wpcdi'), 'error');

           $flash_message->flash_messages();

           return;
        }

    }
}


//allow redirection, even if my theme starts to send output to the browser
add_action('init', 'do_output_buffer');
function do_output_buffer() {
        ob_start();
}


function my_get_menu_item_slug() {
  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


  $slug = trim($actual_link, "/");
  $link = explode("/", $slug);

  return end($link);
}

/*
* Custom args for search
*/
function args_func($get, $paged) {

  if($get['title'] != '') {


      $args = array(
          'post_type'      => 'acme_article',
          'post_title'     =>  $get['title'],
          'posts_per_page' => CUSTOM_POST_PER_PAGE,
          'post_status'    => 'publish',
          'paged'          => $paged,
          'order' => 'DESC', // Order DEscending
          'orderby' => 'post_date', // Order by post date
      );


  } else {


      $get['category'] = $get['category'] == 'all' ? '' : $get['category'];

      if($get['country'] == '' && $get['category'] == ''){

          $args = array(
              'post_type'      => 'acme_article',
              'posts_per_page' => CUSTOM_POST_PER_PAGE,
              'post_status'    => 'publish',
              'paged'          => $paged,
              'order' => 'DESC', // Order DEscending
              'orderby' => 'post_date', // Order by post date
          );

      }else{

          if($get['country'] != '' && $get['category'] == ''){

              $args = array(
                'post_type'      => 'acme_article',
                'posts_per_page' => CUSTOM_POST_PER_PAGE,
                'post_status'    => 'publish',
                'paged'          => $paged,
                'tax_query'      => array(
                                        'relation' => 'OR',
                                        array(
                                            'taxonomy' => 'article_country_cat',
                                            'field'    => 'name',
                                            'terms'    => $get['country'],
                                        ),
                                    ),
                   'order' => 'DESC', // Order DEscending
              'orderby' => 'post_date', // Order by post date
              );

          }elseif($get['country'] == '' && $get['category'] != ''){

              $args = array(
                      'post_type'      => 'acme_article',
                      'posts_per_page' => CUSTOM_POST_PER_PAGE,
                      'post_status'    => 'publish',
                      'paged'          => $paged,
                      'tax_query'      => array(
                                              'relation' => 'OR',
                                              array(
                                                  'taxonomy' => 'article_cat',
                                                  'field'    => 'name',
                                                  'terms'    =>  $get['category'],
                                              ),
                                          ),
                         'order' => 'DESC', // Order DEscending
              'orderby' => 'post_date', // Order by post date
              );

          }else{

              $args = array(
                  'post_type'      => 'acme_article',
                  'posts_per_page' => CUSTOM_POST_PER_PAGE,
                  'post_status'    => 'publish',
                  'paged'          => $paged,
                  'tax_query'      => array(
                                          'relation' => 'AND',
                                          array(
                                              'taxonomy' => 'article_country_cat',
                                              'field'    => 'name',
                                              'terms'    => $get['country'],
                                          ),
                                          array(
                                              'taxonomy' => 'article_cat',
                                              'field'    => 'name',
                                              'terms'    =>  $get['category'],
                                          ),
                                      ),
                     'order' => 'DESC', // Order DEscending
              'orderby' => 'post_date', // Order by post date
              );

          }
      }
  }
  $_SESSION['search_data'] = $get;

  return $args;
}


function post_acme_article($post){

    $tags = explode(',', $post['tag_input']);


  if($post){
    $post_country      = explode('@', $post['post_country']);
    $post_country_id   = $post_country[0];
    $post_country_name = $post_country[1];

    $post_category      = explode('@', $post['post_category']);
    $post_category_id   = $post_category[0];
    $post_category_name = $post_category[1];

    $post_status = (isset($post['save'])) ? 'draft' : 'publish';
    $post_author = get_current_user_id();


        if(!$post['post_id']){
      $post_data = array(
          'post_title'    => wp_strip_all_tags( $post['post_title'] ),
          'post_content'  => $post['post_title'],
          'tax_input'     => array( 'article_country_cat' => $post_country_id, 'article_cat' => $post_category_id),
          'post_status'   => $post_status, 
          'post_type'     => $post['custom_post_type'],
          'post_author'   => $post_author // Use a custom post type if you want to
      );

      if(isset($post['save'])){
         $post_status  = 'draft';
         $message = 'Post saved to drafts.';

      }else{
          $post_status  = 'publish';
          $message = 'Post published.';
      }
        
      $post_id =  wp_insert_post( $post_data );
      // $message = 'Post '.$post_status.'.';
    }else{
      $post_data = array(
          'ID'            => $post['post_id'],
          'post_title'    => wp_strip_all_tags( $post['post_title'] ),
          'post_content'  => $post['post_title'],
          'tax_input'     => array( 'article_country_cat' => $post_country_id, 'article_cat' => $post_category_id),
          'post_status'   => $post_status, 
          'post_type'     => $post['custom_post_type'],
          'post_author'   => $post_author // Use a custom post type if you want to
      );
      $post_id =  wp_update_post( $post_data );

      if(isset($post['save'])){
       $post_status  = 'draft';
       $message = 'Post updated as draft.';

      }else{
          $post_status  = 'publish';
          $message = 'Post draft has been published.';
      }

      $post_id = $post['post_id'];
      // $message = 'Post '.$post_status.' updated.';
    }

    //save tag input in custom post type acme_article
      foreach( $tags as $term ) {

          $existent_term = term_exists( $term, 'post_tag' );

          if( $existent_term && isset($existent_term['term_id']) ) {

              $term_id = $existent_term['term_id'];

          } else {

              //intert the term if it doesn't exsit
              $term = wp_insert_term(
                  $term, // the term
                  'post_tag' // the tag
              );
              if( !is_wp_error($term ) && isset($term['term_id']) ) {
                  $term_id = $term['term_id'];
              }

          }

          $terms[] = (int) $term_id;
      }
      //assign the tag input to specific post using the $terms value which is the tag input
      wp_set_object_terms( $post_id, $terms, 'post_tag' );
      add_post_meta( $post_id, '_custom_location', $post['location'], true );


    if(isset($post['paste_featured_img'])){
      add_post_meta( $post_id, '_custom_image_link', $post['paste_featured_img'], true );
    }

    if(!empty($_FILES['post_featured_img']['name'])){
      $uploaddir = wp_upload_dir();
      $file = $_FILES["post_featured_img"]["name"];

      $uploadfile = $uploaddir['path'] . '/' . basename( $file );

      move_uploaded_file( $file , $uploadfile );
      $filename = basename( $uploadfile );

      $wp_filetype = wp_check_filetype(basename($filename), null );

      $attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
          'post_content'   => '',
          'post_status'    => 'inherit'
      );

      foreach($_FILES as $file => $value) {
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        $attach_id = media_handle_upload( $file, $post_id );            
        set_post_thumbnail( $post_id , $attach_id);
        update_post_meta($post_id,'_thumbnail_id',$attach_id);
      }

      $image_url = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
    }else{
       $image_url = '';
    }
    
    $status    = 'success';

  }else{
    $status  = 'error';
    $message = 'Please fill-up the required fields.';
  }
  
  wp_redirect(site_url().'/curator-detail/?id='.$post_author.'&status='.$post_status);
}

function unset_post() {
  unset($_POST);
}


function count_user_favorites($user_id) {

     $fav_args = array(
                  'post_type'       => 'acme_article', 
                  'posts_per_page'  => -1, 
                  'meta_query'        => array(
                    'relation'  => 'AND',
                      array(
                          'key' => '_user_liked',
                          'value' => $user_id,
                          'compare' => '='
                      )
                  )
                  );

     return count(query_posts($fav_args));
}

function check_user_liked($id,$user) {
global $wpdb;

  $user_liked = $wpdb->get_results("SELECT DISTINCT *  FROM  {$wpdb->prefix}postmeta WHERE {$wpdb->prefix}postmeta.post_id = '$id' AND {$wpdb->prefix}postmeta.meta_key ='_user_liked' AND {$wpdb->prefix}postmeta.meta_value ='$user' ");
 
 if($user_liked) {

    return 1;

  }
  
  return 0;
}

function kura_facebook_count( $url )
{
    /* build the pull URL */
    $url = 'http://graph.facebook.com/?id=' . urlencode($url);

    /* get json */
    $json = json_decode(file_get_contents($url), FALSE);
    if (isset($json->shares)) return (int)$json->shares;

    return 0;
}

function kura_twitter_count( $url ) {
    /* build the pull URL */
    $url = 'http://cdn.api.twitter.com/1/urls/count.json?url=' . urlencode( $url );
  
    /* get json */
    $json = json_decode( file_get_contents( $url ), false );
    if( isset( $json->count ) ) return (int) $json->count;
  
    return 0;
}


function kura_gplus_count( $url ) {
    /* get source for custom +1 button */
    $contents = file_get_contents( 'https://plusone.google.com/_/+1/fastbutton?url=' .  $url );
 
    /* pull out count variable with regex */
    preg_match( '/window\.__SSR = {c: ([\d]+)/', $contents, $matches );
 
    /* if matched, return count, else zed */
    if( isset( $matches[0] ) ) 
        return (int) str_replace( 'window.__SSR = {c: ', '', $matches[0] );
    return 0;
}


add_action('init', 'update_user_info');

function update_user_info(){

  if(isset($_POST['update_user_info'])) {
    $user_id = $_POST['user_id'];

    if($_FILES['profile']){
        $uploadedfile     = $_FILES['profile'];
        $upload_overrides = array( 'test_form' => false );
        $movefile         = wp_handle_upload( $uploadedfile, $upload_overrides );

        if($movefile && !isset($movefile['error'])){

            $profile_url = $movefile['url'];

             $check = get_the_author_meta( 'profile_url', $user_id );

            if($check){
                
                if($check != NULL){
                  update_user_meta( $user_id, 'profile_url', $profile_url ); 
                }
            
            }else{
                add_user_meta( $user_id, 'profile_url', $profile_url);
            }

        }else{
            /**
             * Error generated by _wp_handle_upload()
             * @see _wp_handle_upload() in wp-admin/includes/file.php
             */
            // echo $movefile['error'];
            $profile_url = null;
        }


    }

    $userdata = array(
        'ID'            => $user_id,
        'user_nicename' => $_POST['full_name'],
        'display_name'  => $_POST['full_name']
    );

    $result = wp_update_user( $userdata ); //update user info of the $userdata paramter

    update_user_meta( $user_id, 'description', $_POST['user_description'] ); //update user meta description
        
  }

}

function categoryLogo($params)
{
  $category = $params['category'];

  switch ($category){
    case 'Gourmet':
      return "fa fa-cutlery";
    break;
    case 'Leisure':
      return "fa fa-bed";
    break;
    case 'Fashion':
      return "fa fa-briefcase";
    break;
    case 'Study':
      return "fa fa-leanpub";
    break;
    case 'Business':
      return "fa fa-dollar";
    break;
    case 'Hotel':
      return "fa fa-hotel";
    break;
    case 'Buzz':
      return "fa fa-bell";
    break;
    case 'Music':
      return "fa fa-music";
    break;
    default:
      return "fa fa-question";
    break;
  }

}

function getSearchKeyword()
{
  $search = trim($_SERVER["HTTP_HOST"] . $_SERVER["REDIRECT_URL"], '/');              
  $search = explode('/', $search);
  return ucwords(end($search));
}

function getCurrentProfile($params)
{
  $user_id              = $params['user_id'];
  $fb_profile_picture   = get_user_meta( $user_id, 'fb_profile_picture', true ); 
  $fb_user_access_token = get_user_meta( $user_id, 'fb_user_access_token', true ); 

  if($fb_user_access_token != ''){
    $profile =  get_user_meta( get_the_author_meta( 'ID' ), 'fb_profile_picture', true ); 
  }else{
    if(get_the_author_meta( 'profile_url', $user_id )) {
      $profile = get_the_author_meta( 'profile_url', $user_id );
    }else{
      $profile = get_template_directory_uri()."/images/default-image.jpg";
    }
  }

  $url = @getimagesize($profile);
  if(!$url){
    $src = get_template_directory_uri()."/images/default-image.jpg";
  }else{
    $src = $profile;
  }

  return $src;
}

function getArticleImage($post_id)
{
  $custom_image_link = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), array( 5600,1000 ), false, '' );
  $custom_image_link = $custom_image_link[0];
  
  // Check for not found images
  $url = @getimagesize($custom_image_link);
  if(!$url){
    $src = get_template_directory_uri().'/images/blank-img.png';
  }else{
    $src = $custom_image_link;
  }

  return $src;
}


add_action('init', 'update_article_info');

function update_article_info(){



  if(isset($_POST['update_article_info'])) {

  //print_r($_POST); die();
      $post_id = $_POST['post_id'];

      $post_data = array(
          'ID'            => $_POST['post_id'],
          'post_title'    => wp_strip_all_tags( $_POST['post_title'] ),
          'tax_input'     => array( 'article_country_cat' => $_POST['country'], 'article_cat' => $_POST['category']),
          'post_status'   => $_POST['post_status'],
      );


    if(!empty($_FILES['post_image']['name'])){

      $uploaddir = wp_upload_dir();
      $file = $_FILES["post_image"]["name"];

      $uploadfile = $uploaddir['path'] . '/' . basename( $file );

      move_uploaded_file( $file , $uploadfile );
      $filename = basename( $uploadfile );

      $wp_filetype = wp_check_filetype(basename($filename), null );

      $attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
          'post_content'   => '',
          'post_status'    => 'inherit'
      );

      foreach($_FILES as $file => $value) {
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        $attach_id = media_handle_upload( $file, $post_id );            
        set_post_thumbnail( $post_id , $attach_id);
        update_post_meta($post_id,'_thumbnail_id',$attach_id);
      }

      #$image_url = wp_get_attachment_url( get_post_thumbnail_id($post_id) );

    }

      $posts =  wp_update_post( $post_data );
        
  }

}

function get_tax_country($value) {
  ob_start();
  ?>
    <select name="country">
            <option value="">-- 国を選ぶ --</option>
            <?php

            $taxonomy = array( 
                'article_country_cat'
            );

            $args = array(
                'orderby'           => 'name', 
                'order'             => 'ASC',
                'hide_empty'        => false, 
                'hierarchical'      => true, 
                'pad_counts'        => false,
                'parent'      => 0
            ); 

            $parents = get_terms($taxonomy, $args);

            foreach ($parents as $key => $parent):
            ?>
                <optgroup label="<?php echo $parent->name ?>">

                <?php
                $param = array(
                      'orderby'           => 'name', 
                        'order'             => 'ASC',
                                'taxonomy' => $taxonomy,
                                'parent'   => $parent->term_id,
                                'hide_empty'        => false, 
                              );

                    $subcategories = get_categories($param);      
                    foreach($subcategories as $sub):
                    ?>
                       <option value="<?php echo $sub->term_id ?>" <?php echo $sub->name == $value ? 'selected="selected"' : ''; ?>><?php echo $sub->name ?></option>
                    <?php
                    endforeach;
                    ?>
                    </optgroup>

                    <?php

            endforeach;
            ?>

          </select>
  <?php
  return ob_get_clean();
}


function get_tax_category($value) {
    ob_start();
    ?>

    <select name="category" id="category">
      <option value="">-- ジャンルを選ぶ --</option>
      <?php
      $taxonomy = '';
      $args = '';

      $taxonomy = array( 
          'article_cat'
      );

      $args = array(
          'orderby'           => 'name', 
          'order'             => 'ASC',
          'hide_empty'        => false, 
          'hierarchical'      => true, 
          'child_of'          => 0,
          'childless'         => false,
          'pad_counts'        => false
      ); 

      $categories = get_terms($taxonomy, $args);
      if($categories):
        foreach ($categories as $key => $category): ?>
          <option value="<?php echo $category->term_id ?>" <?php echo $category->name == $value ? 'selected="selected"' : ''; ?>><?php echo $category->name ?></option>
          <?php
        endforeach;
      endif;  
      ?>

    </select>
    <?php
    return ob_get_clean();
}