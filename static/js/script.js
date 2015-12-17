var is_mobile = navigator.userAgent.match(/Android|webOS|iPhone|iPad|iPod|BlackBerry|Windows Phone/i),
    clickOrTouch = is_mobile? 'touchend' : 'click';

			
$(document).ready(function() {
		$('.menu-sp').click(function(){
			 $( ".menu" ).fadeToggle('fast');
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
		if($(this).scrollTop()!=0){
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
            }

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


$(window).load(function() {
		  $(function() {
			$( "#tabs" ).tabs();
		  });
});