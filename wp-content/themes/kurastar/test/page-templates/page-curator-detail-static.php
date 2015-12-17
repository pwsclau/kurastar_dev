<?php  
/* Template Name: Curator Detail Page
*/

get_header();
?>
<div class="defaultWidth center clear-auto bodycontent bodycontent-index ">
	<div class="contentbox">
        <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
            <?php if(function_exists('bcn_display'))
            {
                bcn_display();
            }?>
        </div>

    	<div class="row">
	    	<?php $result =  ''; ?>	
    		<?php if(!empty( $_POST['action'] )): ?>
    		<?php 

    			//this will save the data in the 'acme_article' custom post type.
				$result =  post_acme_article($_POST);
    		 ?>

			<?php endif; ?>
		  	  <?php if($result): ?>
	    		  <span class="search-results">
	    		  	<?php echo $result['msg']; ?>	
	    		  </span>
    		  <?php endif; ?>
		</div>

    	<div class="curator-detail-wrap">
			<div class="pointer2-curactor"></div>
			<img src="http://kurastar.dev/wp-content/uploads/2015/09/profile1.jpg"/>
			<div class="labels labels2">
				<a href="#" class="countrylabel"><b>8</b>Articles</a>
				<a href="#" class="catlabel"><b>3</b> Favorites</a>
			</div>
			<div class="curator-info info-custom">
				<h4>Misaki Kimura</h4>
				<p>初めまして♡最近始めたばかりのルーキーですが、みなさんの生活…平均 80,907P（合計 11,731,462P）初めまして♡最近始めたばかりのルーキーですが、みなさんの生活…平均 80,907P（合計 11,731,462P）初めまして♡最近始めたばかりのルーキーですが、みなさんの生活…平均 80,907P（合計 11,731,462P）初めまして♡最近始めたばかりのルーキーですが、みなさんの生活…平均 80,907P（合計 11,731,462P）</p>
				<div class="clear"></div>
			</div>
			<div class="points-detail">
				11,600<span>points</span>
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
			</ul>

			<!-- Tab panes -->
			<div class="tab-content curator-tab-content">
				<div role="tabpanel" class="tab-pane active" id="1">
					<ul class="post-list-thumb">
						<li>
							<a href class="post-list-thumb-wrap">
								<div class="postimg" style="background-image:url('http://kurastar.dev/wp-content/uploads/2015/07/img1.jpg');"></div>
								<div class="labels">
									<a href="#" class="countrylabel"><i class="fa fa-map-marker"></i> Philippines</a>
									<a href="#" class="catlabel"><i class="fa fa-hotel"></i> Hotel</a>
								</div>
								<div class="desc">
									<h2>Amora Hotel Jamison and Restaurant</h2>
									<p>
									Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour. Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour...
									</p>
								</div>
								<div class="infobelow">
									<span class="smallpoints smallpoints-left">14,091 pts</span>
									<div class="profile-thumb-wrap">
										<img src="http://kurastar.dev/wp-content/uploads/2015/07/profile1.jpg" />
										<div class="curator">
											<span>CURATOR</span><br />
											<h3>Mitsutaka Suzuki</h3>
										</div>
									</div>
								</div>
							</a>
						</li>
						<li>
							<a href class="post-list-thumb-wrap">
								<div class="postimg" style="background-image:url('http://kurastar.dev/wp-content/uploads/2015/07/img21.jpg');"></div>
								<div class="labels">
									<span class="countrylabel"><i class="fa fa-map-marker"></i> Philippines</span>
									<span class="catlabel"><i class="fa fa-hotel"></i> Hotel</span>
								</div>
								<div class="desc">
									<h2>Amora Hotel Jamison and Restaurant</h2>
									<p>
									Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour. Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour...
									</p>
								</div>
								<div class="infobelow">
									<span class="smallpoints smallpoints-left">14,091 pts</span>
									<div class="profile-thumb-wrap">
										<img src="http://kurastar.dev/wp-content/uploads/2015/07/profile1.jpg" />
										<div class="curator">
											<span>CURATOR</span><br />
											<h3>Mitsutaka Suzuki</h3>
										</div>
									</div>
								</div>
							</a>
						</li>
						<li>
							<a href class="post-list-thumb-wrap">
								<div class="postimg" style="background-image:url('http://kurastar.dev/wp-content/uploads/2015/07/img1.jpg');"></div>
								<div class="labels">
									<span class="countrylabel"><i class="fa fa-map-marker"></i> Philippines</span>
									<span class="catlabel"><i class="fa fa-hotel"></i> Hotel</span>
								</div>
								<div class="desc">
									<h2>Amora Hotel Jamison and Restaurant</h2>
									<p>
									Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour. Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour...
									</p>
								</div>
								<div class="infobelow">
									<span class="smallpoints smallpoints-left">14,091 pts</span>
									<div class="profile-thumb-wrap">
										<img src="http://kurastar.dev/wp-content/uploads/2015/07/profile1.jpg" />
										<div class="curator">
											<span>CURATOR</span><br />
											<h3>Mitsutaka Suzuki</h3>
										</div>
									</div>
								</div>
							</a>
						</li>
						<li>
							<a href class="post-list-thumb-wrap">
								<div class="postimg" style="background-image:url('http://kurastar.dev/wp-content/uploads/2015/07/img21.jpg');"></div>
								<div class="labels">
									<span class="countrylabel"><i class="fa fa-map-marker"></i> Philippines</span>
									<span class="catlabel"><i class="fa fa-hotel"></i> Hotel</span>
								</div>
								<div class="desc">
									<h2>Amora Hotel Jamison and Restaurant</h2>
									<p>
									Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour. Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour...
									</p>
								</div>
								<div class="infobelow">
									<span class="smallpoints smallpoints-left">14,091 pts</span>
									<div class="profile-thumb-wrap">
										<img src="http://kurastar.dev/wp-content/uploads/2015/07/profile1.jpg" />
										<div class="curator">
											<span>CURATOR</span><br />
											<h3>Mitsutaka Suzuki</h3>
										</div>
									</div>
								</div>
							</a>
						</li>
						<li>
							<a href class="post-list-thumb-wrap">
								<div class="postimg" style="background-image:url('http://kurastar.dev/wp-content/uploads/2015/07/img1.jpg');"></div>
								<div class="labels">
									<span class="countrylabel"><i class="fa fa-map-marker"></i> Philippines</span>
									<span class="catlabel"><i class="fa fa-hotel"></i> Hotel</span>
								</div>
								<div class="desc">
									<h2>Amora Hotel Jamison and Restaurant</h2>
									<p>
									Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour. Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour...
									</p>
								</div>
								<div class="infobelow">
									<span class="smallpoints smallpoints-left">14,091 pts</span>
									<div class="profile-thumb-wrap">
										<img src="http://kurastar.dev/wp-content/uploads/2015/07/profile1.jpg" />
										<div class="curator">
											<span>CURATOR</span><br />
											<h3>Mitsutaka Suzuki</h3>
										</div>
									</div>
								</div>
							</a>
						</li>
						<li>
							<a href class="post-list-thumb-wrap">
								<div class="postimg" style="background-image:url('http://kurastar.dev/wp-content/uploads/2015/07/img21.jpg');"></div>
								<div class="labels">
									<span class="countrylabel"><i class="fa fa-map-marker"></i> Philippines</span>
									<span class="catlabel"><i class="fa fa-hotel"></i> Hotel</span>
								</div>
								<div class="desc">
									<h2>Amora Hotel Jamison and Restaurant</h2>
									<p>
									Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour. Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour...
									</p>
								</div>
								<div class="infobelow">
									<span class="smallpoints smallpoints-left">14,091 pts</span>
									<div class="profile-thumb-wrap">
										<img src="http://kurastar.dev/wp-content/uploads/2015/07/profile1.jpg" />
										<div class="curator">
											<span>CURATOR</span><br />
											<h3>Mitsutaka Suzuki</h3>
										</div>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
				<div role="tabpanel" class="tab-pane" id="2">
					<ul class="post-list-thumb">
						<li>
							<a href class="post-list-thumb-wrap">
								<div class="postimg" style="background-image:url('http://kurastar.dev/wp-content/uploads/2015/07/img21.jpg');"></div>
								<div class="labels">
									<span class="countrylabel"><i class="fa fa-map-marker"></i> Philippines</span>
									<span class="catlabel"><i class="fa fa-hotel"></i> Hotel</span>
								</div>
								<div class="desc">
									<h2>Amora Hotel Jamison and Restaurant</h2>
									<p>
									Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour. Located 3 minutes’ walk from Harbourside Shopping Centre, Novotel Sydney Darling Harbour...
									</p>
								</div>
								<div class="infobelow">
									<span class="smallpoints smallpoints-left">14,091 pts</span>
									<div class="profile-thumb-wrap">
										<img src="http://kurastar.dev/wp-content/uploads/2015/07/profile1.jpg" />
										<div class="curator">
											<span>CURATOR</span><br />
											<h3>Mitsutaka Suzuki</h3>
										</div>
									</div>
								</div>
							</a>
						</li>
						<li>
							<a href="" class="post-list-thumb-wrap">
								<div class="postimg" style="background-image:url('http://kurastar.dev/wp-content/uploads/2015/07/img1.jpg');"></div>
								<div class="labels">
									<span class="countrylabel">
										<i class="fa fa-map-marker">Philippines</i>
									</span>
									<span class="catlabel">
										<i class="fa fa-hotel">Hotel</i>
									</span>
								</div>
								<div class="desc">
									<h2>Amora Hotel Jamison and Restaurant</h2>
									<p>
										Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae repellendus harum, atque. Perspiciatis dicta obcaecati dolorem, eius, pariatur maxime accusamus a doloribus voluptatum, voluptate praesentium! Quos nemo adipisci similique et!
									</p>
								</div>
								<div class="infobelow">
									<span class="smallpoints smallpoints-left">
										14,091 pts
									</span>
									<div class="profile-thumb-wrap">
										<img src="http://kurastar.dev/wp-content/uploads/2015/07/profile1.jpg" alt="">
										<div class="curator">
											<span>CURATOR</span><br/>
											<h3>Mitsutaka Suzuki</h3>
										</div>
									</div>
								</div>
							</a>
						</li>
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

<?php get_footer(); ?>