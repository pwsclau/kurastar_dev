<?php 
/*Template Name: Create Article
*/
acf_form_head(); 
get_header(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<?php 
	global $wp_query;

	if (!is_user_logged_in()):
		wp_redirect( '/user-registration' ); exit();
	endif;

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
		
		<div class="contentbox">
            <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                <?php if(function_exists('bcn_display'))
                {
                    bcn_display();
                }?>
            </div>

	    	<div class="form-results">
			<?php $result = false; ?>	
			<?php if(!empty( $_POST['action'] )): $result = post_acme_article($_POST); endif; ?>
			<?php if($result): ?>

					<?php $image_url = wp_get_attachment_url( get_post_thumbnail_id($result['post_id']) ); ?>
					<?php if($result['status'] == 'success'): ?>
						<div class="result-post alert result-post post-success" role="alert">
							<span class="glyphicon glyphicon-ok" aria-hidden="false"></span>
							<?php echo $result['msg'];  ?>	
						</div>
					<?php else: ?>
						<div class="result-post alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="false"></span>
							<?php echo $result['msg'];  ?>	
						</div>
					<?php endif; ?>

			<?php endif; ?>
    		</div>
    	</div>

    </div>
</div>
<div class="container">

	<form data-toggle="validator" role="form" class="createform" id="acme-article-post-type" name="acme_article_post_type" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">


		<div class="form-content">
	    	<p class="text-center title"><!-- fill up  custom post below --></p>
	    	<div class="gap-30"></div>
	    	<div class="col-md-4">
	    		<!-- <p>image preview</p> -->
	    		<div class="img-holder">
	    		<?php if(isset($image_url)): ?>
	  				<img id="article_featured_image_preview" src="<?php echo $image_url; ?>" alt="">
	  			<?php else: ?>
	  				<img id="article_featured_image_preview" src="<?php echo site_url() ?>/wp-content/themes/kurastar/images/blank-img.png" alt="">
	  			<?php endif; ?>
	  			</div>

	    		<div class="fileUpload">
					<input type="file" class="upload" id="upload-image" name="post_featured_img"/>
				</div>
	    	</div>
	    	<div class="col-md-8">
	    		<div class="form-grp">
	    			<div class="select-form">
	    				<p>select country</p>
						<select id="cty" name="post_country">
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
						    'parent'			=> 0
						); 

						$parents = get_terms($taxonomy, $args);

						foreach ($parents as $key => $parent):
						?>
							<option disabled>-----<?php echo $parent->name ?>-----</option>
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
					          
				        	<option value="<?php echo $sub->term_id ?>"><?php echo $sub->name ?></option>
					        <?php
					        endforeach;

						endforeach;
						?>

						</select>
					</div>
					<div class="select-form">
						<p>select category</p>
						<select id="cat" name="post_category">
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


							foreach ($categories as $key => $category):
							?>
								<option value="<?php echo $category->term_id?>"><?php echo $category->name ?></option>
							<?php 		
							endforeach;
							?>
					    </select>
					</div>
	    		</div>
	    		<!-- <div class="form-grp">
					<input type="text" name="post_title" id="post-title" placeholder="Title" value="<?php echo isset($_POST['post_title']) ? $_POST['post_title'] : ''  ?>">
				</div> -->
	    		<div class="form-grp" style="display:none;" >
					<input type="text" name="post_id" id="post-id" placeholder="Post ID" value="<?php echo isset($result['post_id']) ? $result['post_id'] : ''  ?>">
				</div>
				<div class="form-grp">
					<textarea name="post_desc" class="text-height" placeholder="Description"><?php echo isset($_POST['post_desc']) ? $_POST['post_desc'] : ''  ?></textarea>
				</div>
	    	</div>
    	
    		<?php wp_nonce_field( '_wp_custom_post','_wp_custom_post_nonce_field' ); ?>

			<input type="hidden" name="custom_post_type" id="post-type" value="acme_article" />
			<input type="hidden" name="action" value="save_custom_post" />
			<input type="hidden" name="image_action" id="image-action" value=""/>
			<input type="hidden" name="trigger_set_image" id="trigger-set-image"/>
			
			<input type="submit" name="publish" value="Publish" class="btn btn-default pull-right">
			<input type="submit" name="save" value="Save" class="btn btn-default pull-right">
			
	    </div>
	</form>
</div>

<script type="text/javascript">
$(document).ready(function(){
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><input type="text" name="title[]" value=""/><input type="file" name="image[]" value=""/><input type="text" name="body[]" value=""/><input type="text" name="reference[]" value=""/><img src="remove-icon.png"/></a></div>'; //New input field html 
	var x = 1; //Initial field counter is 1
	$(addButton).click(function(){ //Once add button is clicked
		if(x < maxField){ //Check maximum number of input fields
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
});
</script>
<?php
get_footer();?>
<script type="text/javascript">

$('#upload-image').change(function() {

	getImageContent(this);

	$('#trigger-set-image').val('1');
	$('#image-action').val('upload_file');
	//$('.link_image').remove();

});

// Changes
function readURL(input) {

  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#article_featured_image_preview').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
  }
}
$(document).on('change', "#upload-image", function(e) {
  readURL(this);
});


</script>