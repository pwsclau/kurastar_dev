<?php

if ( ! class_exists('MyShortcode') ) {

class MyShortcode {

	public static function ranking_country_func() {
				
		$taxonomy = 'article_country_cat';

		$args = array(
		    'orderby'           => 'count', 
		    'order'             => 'DESC',
		    'hide_empty'        => true, 
		    'number' => '5'
		); 

		$countries = get_terms($taxonomy, $args);

		ob_start();?>

			<div class="sideboxcontent rankwrap">
				<h3 class="sidetitle">Ranking Country</h3>
				<ul class="rankarticle rankcountry">
					<?php
					 foreach($countries as $key => $country):
					 	
						if($country->count > 0):
						?>
							<li>
								<a href="<?php echo get_term_link($country) ?>">
									<span class="rank rank1"><?php echo $key ?></span>
									<div class="siderankimage2"style="background-image:url(<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url($country->term_id); ?>);"></div>
									<h4 class="ranktitle">
									<?php echo $country->name; ?>
									</h4>
									<span class="smallpoints smallpoints-right"><?php echo $country->count ?> <?php echo $country->count > 1 ? 'articles' : 'article';?></span>
								</a>
							</li>
					<?php endif; ?>
				<?php endforeach; ?>
				</ul>
			</div>

		<?php 

		return ob_get_clean();
	}


	public static function ranking_article_func() {

		ob_start();
		?>

		<div class="sideboxcontent rankwrap">

			<h3 class="sidetitle">Ranking Article</h3>
			<ul class="rankarticle list-articles">

				<?php
					 $args = array(
						'post_type' => 'acme_article',
						'posts_per_page' => 5,
						'meta_key' => 'post_views_count',  
						'orderby' => 'meta_value_num',
						'order' => 'DESC',
						                  
					);


					query_posts($args); 

				  if ( have_posts() ) : while ( have_posts() ) : the_post();
				?>
				<li>
					<a href="<?php echo get_permalink(); ?>">
						<span class="rank rank1">1</span>
						<?php
							global $wp_query;
							$post = $wp_query->post;
							//var_dump($post);
	                    ?>
						<div class="siderankimage"style="background-image:url(<?php echo getArticleImage($post->ID); ?>); background-position: center;"></div>
						<h4 class="ranktitle"><?php if (strlen($post->post_title) > 10) {echo mb_strimwidth(the_title($before = '', $after = '', FALSE), 0, 10). '...'; } else {the_title();} ?></h4>
						<span class="smallpoints smallpoints-right"><?php echo get_post_views($post->ID);?></span>
				</li>
			<?php endwhile; endif; wp_reset_query(); ?>	
			</ul>
		</div>
			
		<?php 
		
		return ob_get_clean();

	}


	public static function dropdown_country_func() {
		ob_start();
		?>

		<!-- <div class="dropcountry">
			<div class="pointer"></div>
			
			<div class="mCustomScrollbar light" data-mcs-theme="minimal-dark">
				<div class="droplistcountry">
					<div>
						<ul id="menu-country-menu" class="menu">
							
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
								<li class="menu-continent disabled menu-item menu-item-type-custom menu-item-object-custom menu-item-<?php echo $parent->term_id ?>">
									<a><?php echo $parent->name ?></a>
								</li>


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
						           <li class="option menu-item menu-item-type-custom menu-item-object-custom menu-item-<?php echo $parent->term_id ?>"><a><?php echo $sub->name ?></a></li>
						        <?php
						        endforeach;

						endforeach;
						?>

						</ul>

					</div>
				</div>
			</div>
		</div> -->	

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
						    'parent'			=> 0
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
						           <option value="<?php echo $sub->name ?>"><?php echo $sub->name ?></option>
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

	// new template shortcode for footer_country
	public static function footer_country_func() {
		ob_start();
		?>
		<?php
		$taxonomy = array( 
		    'article_country_cat'
		);

		$args = array(
		    'hide_empty'        => false, 
		    'hierarchical'      => true, 
		    'pad_counts'        => false,
		    'parent'			=> 0
		); 
		$parents = get_terms($taxonomy, $args);
		foreach ($parents as $key => $parent):
		?>
		<div class="group2">
			<div class="origdiv">
				<h4><?php echo $parent->name; ?></h4>
				<ul>
				<?php
				$param = array(
                'taxonomy' => $taxonomy,
                'parent'   => $parent->term_id,
                'hide_empty'        => false
                );

		        $subcategories = get_categories($param);      
		        foreach($subcategories as $sub):
		        ?>
					<li>
						<a href="<?php echo get_term_link( $sub ); ?>">
							<img src="<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url($sub->term_id); ?>" alt="">
							<?php echo $sub->name; ?>
						</a>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php endforeach; ?>
		<!-- // end new template shortcode  -->
		<?php
		return ob_get_clean();
	}
	

	public static function dropdown_category_func() {
		ob_start();
		?>
		<!-- <div class="dropcategory">
		<div class="pointer"></div>
			<div class="mCustomScrollbar light" data-mcs-theme="minimal-dark">
				<div class="droplistcategory">
					<div>
					<ul id="menu-category-menu" class="menu">
						<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-all">
							<a>all</a>
						</li>
						
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
						<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-<?php echo $category->term_id ?>">
							<a><?php echo $category->name ?></a>
						</li>
					<?php 		
					endforeach;
					?>
					
					</ul>
					</div>
					<div></div>
				</div>
			
			</div>
		</div> -->


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
					<option value="<?php echo $category->name ?>"><?php echo $category->name ?></option>
					<?php
				endforeach;
			endif; 	
			?>

		</select>
		<?php
		return ob_get_clean();
	}


	public static function footer_category_func() {
		ob_start();
		?>

		<div class="menu-header-menu-container">
			<ul id="menu-header-menu-1" class="menu">
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

					<li class="icon-<?php echo $category->slug?> menu-item menu-item-type-taxonomy menu-item-object-article_cat menu-item-<?php echo $category->term_id ?>">
						<a href="<?php echo get_term_link( $category ) ?>"><?php echo $category->name ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
		return ob_get_clean();
	}


	public static function registration_func() {
		$flash_messages = new Flash_Message();

	   	ob_start();

	    if ( ! is_user_logged_in() ) {

	        self::registration_form();
	        
	    } else {

			$flash_messages->set(__('You are already logged in. <a href="/create-article"> Create Article</a>', 'wp'), 'error');

			$flash_messages->flash_messages();
	    }

	   
	    $content = ob_get_clean();

	    return $content;
	}



	private static function registration_form() {

			$flash_messages = new Flash_Message();

			$post = array();

			if ( isset( $_POST['submit_user_registration'] ) ) {
            	
            	check_form_nonce('wp_custom_registration');

	            $post = $_POST;				

	            if ( self::submit_registration_form($post) ) {
	            	$post = array();
	            }

	        }

			$full_name 		= array_get($post, 'full_name');
			$email_address 	=  array_get($post, 'email_address');
			$password 		=  array_get($post, 'password');
			$password2 		=  array_get($post, 'password_confirm');
			$username 		= array_get($post, 'username');


			?>
			<form role="form" method="POST">

				<?php $flash_messages->flash_messages(); ?>

				<?php wp_nonce_field( 'wp_custom_registration' ) ?>

				<!-- new register-form-template -->
<!--				<div class="row">-->
<!--					<div class="form-grp form-placeholder-offset">-->
<!--						<input type="text" name="full_name" class="form-control form-control-stroked" id="full_name" placeholder="Full Name" value="--><?php //echo $full_name ?><!--" required>-->
<!--					</div>-->
<!--				</div>-->
				<div class="row">
					<div class="form-grp form-placeholder-offset">
						<input type="email" name="email_address" class="form-control form-control-stroked" id="email_address" placeholder="Email Address" value="<?php echo $email_address ?>" required>
					</div>
					<div class="form-grp form-placeholder-offset">
						<input type="text" class="form-control form-control-stroked" name="username" id="username" placeholder="Username" value="<?php echo $username ?>" required>
					</div>
				</div>
				<div class="row">
					<div class="form-grp form-placeholder-offset">
						<input type="password" name="password" class="form-control form-control-stroked" id="password" placeholder="Password" value="<?php echo $password ?>" required>
					</div>
					<div class="form-grp form-placeholder-offset">
						<input type="password" name="password_confirm" class="form-control form-control-stroked" id="password_confirm" placeholder="Confirm Password" value="<?php echo $password2 ?>" required>
					</div>
				</div>
				<!-- end new-register-form-template -->
				<button type="submit" name="submit_user_registration" class="btn-action btn btn-orange btn-orange-secondary"><?php _e('Submit', 'wp') ?></button>
			</form>
			<?php
		}


	private static function submit_registration_form($post) {

		$flash_messages = new Flash_Message();

		//$full_name = array_get($post, 'full_name');
		$email_address =  array_get($post, 'email_address');
		$password =  array_get($post, 'password');
		$password2 =  array_get($post, 'password_confirm');
		$username = array_get($post, 'username');


//		if ( trim($full_name) == '' ) {
//			$flash_messages->set(__('Full Name is required.', 'wp'), 'error');
//		}

		if ( trim($email_address) == '' ) {
			$flash_messages->set(__('Email-address is required.', 'wp'), 'error');
		} elseif ( ! filter_var($email_address, FILTER_VALIDATE_EMAIL) ) {
			$flash_messages->set(__('Email-address invalid format.', 'wp'), 'error');
		}

		if(!preg_match('/^[a-zA-Z0-9]{4,16}$/', $username))
	    {
           $flash_messages->set(__('Username must be 4-16 characters and contain letters and numbers only.', 'wp'), 'error');
	    }

		if ( trim($password) == '' ) {
			$flash_messages->set(__('Password is required.', 'wp'), 'error');
		} elseif(!preg_match('/^[a-zA-Z0-9]{4,16}$/', $password))
	    {
           $flash_messages->set(__('Password must be 4-16 characters and contain letters and numbers only.', 'wp'), 'error');
	    }

		if ( trim($password2) == '' ) {
			$flash_messages->set(__('Confirm Password is required.', 'wp'), 'error');
		} elseif ( $password != $password2 ) {
			$flash_messages->set(__('Password not match.', 'wp'), 'error');
		}
		

		//Check if message is empty
		if ( ! $flash_messages->is_empty() ) return false;

		$userdata = array(
	        'user_login' 	=> $username,
	        'user_pass'  	=> $password2,
	        'user_email' 	=> $email_address,
	        'first_name' 	=> '',
	        'last_name'  	=> '',
	        'user_nicename' => $username//$first_name.' '.$last_name
	    );

	    $user_id = wp_insert_user( $userdata ) ;

	  

	    // Return
	    if( !is_wp_error($user_id) ) {

    	     wp_update_user( array ('ID' => $user_id, 'role' => 'subscriber' ) ) ;

	    	$flash_messages->set(__('Successfully saved the information!', 'wp'), 'updated');

	    	wp_redirect(home_url().'/user-login/');

	    	return true;

	    } else {

	    	$flash_messages->set($user_id->get_error_message(), 'error');

	    	return false;

		}
	}	


	public static function login_func() {

		$flash_messages = new Flash_Message();

       	ob_start();

        if ( ! is_user_logged_in() ) {

            self::login_form();
            
        } else {

 			$flash_messages->set(__('You are already logged in. <a href="/create-article"> Create Article </a>', 'wp'), 'error');

 			$flash_messages->flash_messages();
        }

       
        $content = ob_get_clean();

        return $content;
	}

	private static function login_form() {
		
		$flash_messages = new Flash_Message();

		$post = array();



		if ( isset( $_POST['submit_user_login'] ) ) {
        	
        	check_form_nonce('wp-custom-login');

            $post = $_POST;				

            if ( self::submit_login_form($post) ) {

            	unset_post();
            	$post = array();
            }

        }

		$password =  array_get($post, 'password');
		$remember_me =  array_get($post, 'remember_me');
		$username = array_get($post, 'username');
		?>
		<form method="post">
			<?php $flash_messages->flash_messages(); ?>
			<?php wp_nonce_field( 'wp-custom-login' ); ?>
			<div class="form-group">
				<label for="username"><?php _e('Username', 'wp') ?></label>
				<input type="text" class="form-control" name="username" id="username" placeholder="username" value="<?php echo $username ?>" required>
			</div>
			<div class="form-group">
				<label for="password"><?php _e('Password', 'wp') ?></label>
				<input type="password" name="password" class="form-control" id="password" placeholder="password" value="<?php echo $password ?>" required>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" value="1" name="remember_me" <?php checked( 1, $remember_me ); ?>> <?php _e('Remember me', 'wp') ?>
				</label>
			</div>
			<input type="submit" value="Submit" class="btn btn-default" name="submit_user_login">
		</form>
		<?php

	}

	private static function submit_login_form() {

		$flash_messages = new Flash_Message();

        $post = $_POST;

		$info['user_login'] = array_get($post, 'username');
	    $info['user_password'] = array_get($post, 'password');

	    $info['remember'] = array_get($post, 'remember_me');


	    $user_signon = wp_signon( $info, false );

	    if($user_signon && !is_wp_error($user_signon) ) {

    	   $user = new WP_User( $user_signon->ID );

		    if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		        foreach ( $user->roles as $role )
		           $user_role = $role;
		    }

	        wp_redirect(home_url());
	     	die();
	       
	    } else {
	    	$flash_messages->set(__('You entered invalid Username and Password. Please try again.', 'wp'), 'error');
	    	return false;
	    
	    	
	    }
	    
	}


	public static function do_custom_search_form() {

		ob_start();
		?>

		<div class="category-search">
			<form method="get" action="<?php echo site_url() ?>/search-results/">
				<div class="category-search-title">
					<p>どこの国の写真をみたい？</p>
				</div>
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
				<input type="submit" value="検索">
			</form>

		</div>
		<?php
		return ob_get_clean();

	}




}

}

 add_shortcode( 'ranking_country', array( 'MyShortcode', 'ranking_country_func' ) );
 add_shortcode( 'ranking_article', array( 'MyShortcode', 'ranking_article_func' ) );
 add_shortcode( 'dropdown_country', array( 'MyShortcode', 'dropdown_country_func' ) );
 add_shortcode( 'dropdown_category', array( 'MyShortcode', 'dropdown_category_func' ) );
 add_shortcode( 'footer_category', array( 'MyShortcode', 'footer_category_func' ) );
 add_shortcode( 'footer_country', array( 'MyShortcode', 'footer_country_func' ) );


 add_shortcode( 'do_registration', array('MyShortcode', 'registration_func') );
 add_shortcode( 'do_login', array('MyShortcode', 'login_func') );


 add_shortcode( 'custom_search_form', array( 'MyShortcode', 'do_custom_search_form' ) );

