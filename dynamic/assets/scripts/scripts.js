$('#product-carousel').owlCarousel({
			 loop: true,
	margin:30,
			dots:false,
			smartSpeed: 450,
			 nav: false,
			 dots:false,
			// center: true,
			navText: [
				'<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
				
			],
			autoplay: true,
			autoplayHoverPause: false,
			responsive: {
				0: {
					items: 1,
					nav: false,
					loop: true,
				
				},
				600: {
					items: 2,
					nav: false,
					loop: true,
			
				},
				1000: {
					items:4,
				
				}
			}
		});

	
$('#openNav').on('click', function() {
  $('#myNav').css("width", "100%");
});
$('#closeNav').on('click', function() {
  $('#myNav').css("width", "0%");
});

$('#closeNav').on('click', function() {
  $('#openNav').show(1000);
  $('#closeNav').hide(1000);
});

$('#openNav').on('click', function() {
   $('#openNav').hide(1000);
   $('#closeNav').show(1000);
});


$(document).ready(function() {

  var toggleAffix = function(affixElement, scrollElement, wrapper) {
  
    var height = affixElement.outerHeight(),
        top = wrapper.offset().top;
    
    if (scrollElement.scrollTop() >= top){
        wrapper.height(height);
        affixElement.addClass("affix");
    }
    else {
        affixElement.removeClass("affix");
        wrapper.height('auto');
    }
      
  };
  

  $('[data-toggle="affix"]').each(function() {
    var ele = $(this),
        wrapper = $('<div></div>');
    
    ele.before(wrapper);
    $(window).on('scroll resize', function() {
        toggleAffix(ele, $(this), wrapper);
    });
    
    // init
    toggleAffix(ele, $(window), wrapper);
  });
  
});


/* Smooth Scroll Begins */

/* Smooth Scroll Ends */

$(document).ready(function(){       
            var scroll_pos = 0;
            $(document).scroll(function() { 
                scroll_pos = $(this).scrollTop();
                if(scroll_pos >10) {
                    $(".classic-menu").css('background-color', '#000');
                } else {
                    $(".classic-menu").css('background-color', 'transparent');
                }
            });
        });
		
		
		
		
