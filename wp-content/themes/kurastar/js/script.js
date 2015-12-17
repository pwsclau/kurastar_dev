$(document).ready(function() {
		$('.menu-sp').click(function(){
			 $( "#menu-header-menu" ).fadeToggle('fast');
		});
});
/*
$(document).ready(function() {
		$('div.btn20').click(function(){
			 $(this).next().toggle();
			 $(this).find('img').toggle();
		});
});
*/
$(function(){
	$(window).scroll(function(){
		if($(this).scrollTop()!==0){
			$('#bttop').fadeIn();
		} else {
			$('#bttop').fadeOut();
		}
	});

	$('#bttop').click(function(){
		$('body,html').animate({
			scrollTop:0
		},'fast');
	});
});


$(function(){
	$('#cty').click(function(){
		$('.dropcountry').fadeToggle('fast');
	});
});

$(function(){

	$('.droplistcountry li').each(function() {
		var text = $(this).find("a").text();
		$( this ).click(function(){
			$('#cty').val(text);
			$('.dropcountry').fadeOut('fast');
		});
	});
});

$(function(){
	$('#cat').click(function(){
		$('.dropcategory').fadeToggle('fast');
	});
});

$(function(){

	$('.droplistcategory li').each(function() {
		var text = $(this).find("a").text();
		$( this ).click(function(){
			$('#cat').val(text);
			$('.dropcategory').fadeOut('fast');
		});
	});
});


$(window).load(function() {
	if($("div.flexslider").length > 0){
        $('.flexslider').flexslider({
    		animation: "fade",
    		slideshow: true,
    		slideshowSpeed: 3000,
    		animationSpeed: 1000,
    		pauseOnHover: true,
    		controlNav: false
    	});
    }

	
});

$(document).mouseup(function (e)
{
    var container = $(".dropcountry, .dropcategory");
	var container2 = $(".transwrap, .transwrap input ");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && !container2.is(e.target) && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.fadeOut('fast');
    }
});


$(window).load(function() {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.imgplaceholder').css('background-image', 'url('+e.target.result+')');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputFile").change(function () {
        readURL(this);
    });
});


$(window).load(function() {

    $("#inputFile2").keyup(function () {
		var bla = $('#inputFile2').val();
         $('.imgplaceholder').css('background-image', 'url('+bla+')');
    });
});
$('#myTabs a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});


/*Single Article Page & Curator Detail Page*/
$(document).on('click', ".edit-custom-form", function(e) {
	e.preventDefault();

	$('.display_details').hide();
	$('.display_section').show();

});

$(document).on('click', ".update_process", function() {

	if (confirm("Are you sure you want to save the changes?") == true) {

		$('#edit-custom-form').submit();

	} else {

		cancellation();

	}

});

$(document).on('click', ".draft_process", function() {


    if (confirm("Are you sure you want to save as draft?") == true) {
        
        $('#post-status').val('draft');

        $('#edit-custom-form').submit();

    } else {

        cancellation();

    }

});

$(document).on('click', ".publish_process", function() {


    if (confirm("Are you sure you want to save publish this article?") == true) {
        
        $('#post-status').val('publish');

        $('#edit-custom-form').submit();

    } else {

        cancellation();

    }

});



$(document).on('click', ".cancel_process", function(e) {
	e.preventDefault();

	cancellation();
});


function cancellation() {

	$('.userinfo_section').hide();
	$('.user_details').show();

	$('.display_details').show();
	$('.display_section').hide();

}


$(document).on('click', "#change-image", function(e) {
	$('#post_image').trigger('click');
});


$(document).on('click',"#change-image-2", function(e) {
	$('#post_image').trigger('click');
});

function readURL(input) {

  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#uploaded_image').attr('src', e.target.result);
          
          if (document.getElementById('change-image-2') != 0) {
          	document.getElementById("change-image-2").style.backgroundImage = "url('" + e.target.result + "')";
      	  }

      }

      reader.readAsDataURL(input.files[0]);
  }
}

$(document).on('change', "#post_image", function(e) {
  readURL(this);
});

jQuery(document).ready(function($) {

   /*load more for publish & draft tab*/
 $('.custom').click(function() {

   var pp = parseInt($('.custom-'+$(this).data('status')+'-pp').val()) + 1;
   $('.custom-'+$(this).data('status')+'-pp').val(pp);
 
    $(this).text('Loading posts...');
    // This does the ajax request
    $.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        data: {
            'action':'tab_ajax_request',
            'post_type' : $(this).data('post-type'),
            'posts_per_page' : parseInt($(this).data('post-per-page')),
            'paged' :  parseInt(pp),
            'author' : $(this).data('author'),
            'status' : $(this).data('status'),
            'orderby' : $(this).data('orderby'),
            'order' : $(this).data('order')
        },
        success:function(response) {
            // This outputs the result of the ajax request
        
            $('.custom-'+response.post_status).text('Load More');
            $('.post-'+response.post_status+'-wrapper').append(response.result);

            if(response.max == response.paged) {

              // $('.custom-'+response.post_status).hide();
              $('.load-'+response.post_status).hide();
            }
           
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });  
         return false;     
    });

 /*load more for favorites tab*/ 
 $('.custom-favpagi').click(function() {

    var pp = parseInt($('.custom-'+$(this).data('status')+'-pp').val()) + 1;
    $('.custom-'+$(this).data('status')+-'pp').val(pp);

    $(this).text('Loading posts...');

    // This does the ajax request
    $.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        data: {
            'action':'favorite_tab_ajax_request',
            'paged' :  parseInt(pp),
            'author' : $(this).data('author'),
            'status' : $(this).data('status')
        },
        success:function(response) {
            // This outputs the result of the ajax request
           
            $('.custom-'+response.post_status).text('Load More');
            $('.post-'+response.post_status+'-wrapper').append(response.result);

            if(response.max == response.paged) {

              $('.load-'+response.post_status).hide();
            }
           
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });  
         return false;     
    });
	

 /*load more for home page*/
$('.custom-defaultpagi').click(function() {


    var limit = parseInt(custom_post_per_page);
    var paged = parseInt($('.custom-paged').val()) + limit;

    $('.custom-paged').val(paged);

    $(this).text('Loading posts...');

    // This does the ajax request
    $.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        data: {
            'action':'default_ajax_request',
            'paged' : parseInt(paged),
        },
        success:function(response) {
            // This outputs the result of the ajax request

            console.log(response);

            $('.custom-'+response.post_status).text('Load More');
            $('.post-'+response.post_status+'-wrapper').append(response.result);

            if(response.max == response.count) {

               $('.load-div').hide();
            }
           
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });  
         return false;     
    });

 /*load more for custom search page*/
 $('.custom-search').click(function() {

      var limit = parseInt(custom_post_per_page);
      var paged = parseInt($('.custom-paged').val()) + limit;

      $('.custom-paged').val(paged);

      console.log($('.custom-paged').val());
  
    $(this).text('Loading posts...');

    // This does the ajax request
    $.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        data: {
            'action':'custom_search_ajax_request',
            'paged' : parseInt(paged),
        },
        success:function(response) {
            // This outputs the result of the ajax request

            console.log(response);

            $('.custom-'+response.post_status).text('Load More');
            $('.post-'+response.post_status+'-wrapper').append(response.result);

            if(response.max == response.count) {

               $('.load-div').hide();
            }
           
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });  
         return false;     
    });

});

/*Custom like script*/
$('.like_request').click(function() {
    $('.form-send-like').submit();

});