<?php 
/*Template Name: Create Article Template
*/
get_header(); ?>
<?php 
global $wp_query;

if (!is_user_logged_in()):
	wp_redirect( '/user-registration' ); exit();
endif;
?>
<div class="defaultWidth center clear-auto bodycontent bodycontent-index ">
	<div class="contentbox">
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
    	</div>
    </div>
</div>

<div class="container">
	<div class="form-content">
    	<p class="text-center title">fill up  custom post below</p>
    	<div class="gap-30"></div>
    	<div class="col-md-4">
    		<p>image preview</p>
    		<div class="img-holder">
    			<img src="http://kurastar.dev/wp-content/uploads/2015/07/img2.jpg" alt="">
    		</div>
    		<div class="fileUpload">
			    <input type="file" class="upload" />
			</div>
			<p>or paste image link below</p>
			<div class="fileUpload">
			    <input type="text" class="link"/>
			</div>
    	</div>
    	<div class="col-md-8">
    		<div class="form-grp">
    			<div class="select-form">
    			<p>select country</p>
				<select id="cty">
					<option disabled>-----ASIA-----</option>
						<option value="Philippines">Philippines</option>
						<option value="Singapore">Singapore</option>
						<option value="Malaysia">Malaysia</option>
						<option value="South Korea">South Korea</option>
						<option value="Indonesia">Indonesia</option>
						<option value="China">China</option>
						<option value="Taiwan">Taiwan</option>
						<option value="Hongkong/Macau">Hongkong/Macau</option>
						<option value="Thailand">Thailand</option>
						<option value="Vietnam">Vietnam</option>
						<option value="India">India</option>
						<option value="Cambodia">Cambodia</option>
					<option disabled>-----EUROPE-----</option>
						<option value="United Kingdom">United Kingdom</option>
						<option value="Germany">Germany</option>
						<option value="France">France</option>
						<option value="Italy">Italy</option>
						<option value="Switzerland">Switzerland</option>
						<option value="Spain">Spain</option>
						<option value="Austria">Austria</option>
						<option value="Croatia">Croatia</option>
						<option value="Czech Republic">Czech Republic</option>
						<option value="Greece">Greece</option>
					<option disabled>-----AMERICAS-----</option>
						<option value="America">America</option>
						<option value="Canada">Canada</option>
						<option value="Brazil">Brazil</option>
						<option value="Argentina">Argentina</option>
						<option value="Bolivia">Bolivia</option>
						<option value="Mexico">Mexico</option>
					<option disabled>-----OCEANIA-----</option>
						<option value="Australia">Australia</option>
						<option value="New Zealand">New Zealand</option>
						<option value="Hawaii">Hawaii</option>
						<option value="Guam">Guam</option>
						<option value="Saipan">Saipan</option>
					<option disabled>-----AFRICA-----</option>
						<option value="Egypt">Egypt</option>
					<option disabled>-----MIDDLE EAST-----</option>
						<option value="Turkey">Turkey</option>
						<option value="Dubai">Dubai</option>
				</select>
				</div>
				<div class="select-form">
					<p>select category</p>
					<label>select category</label>
					<select id="cat">
						<option value="Gourmet">Gourmet</option>
						<option value="Leisure">Leisure</option>
						<option value="Fashion">Fashion</option>
						<option value="Study">Study</option>
						<option value="Business">Business</option>
						<option value="Hotel">Hotel</option>
						<option value="Buzz">Buzz</option>
					</select>
				</div>
    		</div>
    		<div class="form-grp">
				<p>details</p>
				<input type="text" placeholder="Title">
			</div>
			<div class="form-grp">
				<p>limit to 150 characters only</p>
				<textarea name="description" class="text-height" placeholder="Description"></textarea>
			</div>
    	</div>
    </div>
    <div class="form-content">
    	<p class="text-center title">or fill up reference post below</p>
    	<div class="tab-form-panel">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#text" aria-controls="home" role="tab" data-toggle="tab">Text</a>
				</li>
				<li role="presentation">
					<a href="#picture" aria-controls="picture" role="tab" data-toggle="tab">Picture</a>
				</li>
				<li role="presentation">
					<a href="#reference" aria-controls="reference" role="tab" data-toggle="tab">Reference</a>
				</li>
				<li role="presentation">
					<a href="#link" aria-controls="link" role="tab" data-toggle="tab">Link</a>
				</li>
				<li role="presentation">
					<a href="#twitter" aria-controls="twitter" role="tab" data-toggle="tab">Twitter</a>
				</li>
				<li role="presentation">
					<a href="#youtube" aria-controls="youtube" role="tab" data-toggle="tab">Youtube</a>
				</li>
				<li role="presentation">
					<a href="#h2-tag" aria-controls="h2-tag" role="tab" data-toggle="tab">H2 Tag</a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="text">
					<form>
						<textarea placeholder="Put your text here" class="form-control texts text-height"></textarea>
						<input type="button" value="Add" class="btn btn-default add" onclick="addItem('0', 'text', 'new')">
						<input type="button" class="btn btn-default cancel" value="Cancel" onclick="cancel_add('0', 'text', 'new')">
						<input type="hidden" class="type" value="0">
					</form>
				</div>
				<div role="tabpanel" class="tab-pane" id="picture">
					<p>content</p>
				</div>
				<div role="tabpanel" class="tab-pane" id="reference">
					<form>
						<textarea class="form-control ref-desc text-height" name="ref-desc" placeholder="Add a description"></textarea>
						<input type="text" placeholder="Please put the URL of the reference" class="form-control ref-url">
						<input type="button" class="btn btn-default" value="Add" onclick="addItem('0', 'reference', 'new')">
						<input type="button" class="btn btn-default" value="Cancel" onclick="cancel_add('0', 'reference', 'new')">
					</form>
				</div>
				<div role="tabpanel" class="tab-pane" id="link">
					<form>
						<div class="link-wrap">
							<input type="text" class="form-control ref-url" placeholder="URL of the Link">
							<input type="button" class="btn btn-default check-link" value="Check" onclick="link_check('0', 'link', 'new')">
							<input type="button" class="btn btn-default cancel-link" onclick="cancel_add('0', 'link', 'new')" value="Cancel">
						</div>
					</form>
				</div>
				<div role="tabpanel" class="tab-pane" id="twitter">
					<form>
						<input type="text" class="form-control ref-url" placeholder="Put the URL of a tweet here">
						<a href="javascript:void(0)" class="search-twitter" onclick="addclass_modal('new-tweet', 0)" data-toggle="modal" data-target="#twitterSearch">
							<span class="glyphicon glyphicon-search"></span>Search for tweets.
						</a><br><br>
						<input type="button" class="btn btn-default check-tweet" onclick="addItem('0', 'twitter', 'new')" value="Add">
						<input type="button" class="btn btn-default" onclick="cancel_add('0', 'twitter', 'new')" value="Cancel">
					</form>
				</div>
				<div role="tabpanel" class="tab-pane" id="youtube">
					<form>						
						<div class="vid-url-container">
							<input type="text" class="ref-url form-control" placeholder="Video URL">
							<input type="button" value="Check" class="btn btn-default add" onclick="extract_video('0', 'video', 'new')">
							<input type="button" value="Cancel" class="btn btn-default" onclick="cancel_add('0', 'video', 'new')">
						</div>
					</form>
				</div>
				<div role="tabpanel" class="tab-pane" id="h2-tag">
					<form>
						<select class="form-control tag-heading ref-url" onchange="select_htype('0', 'tag', 'new')">
							<option value="normal">Normal Heading</option>
							<option value="sub">Subheading</option>
						</select>
						<span class="tag-bullet" style="color: rgba(237, 113, 0, 1);">■</span>
						<input type="text" class="form-control ref-url" placeholder="Tag Title">
						<hr class="tag-hr" style="border-color: rgba(237, 113, 0, 1)">
						<input type="button" value="Add" class="btn btn-default add" onclick="addItem('0', 'tag', 'new')">
						<input type="button" class="btn btn-default cancel" onclick="cancel_add('0', 'tag', 'new')" value="Cancel">
					</form>
				</div>
			</div>
		</div>
    </div>
</div>
<?php get_footer(); ?>