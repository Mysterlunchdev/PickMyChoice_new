
var speed = 300;
        $('#close-bar').on('click', function(){

           
		   var $$ = $(this),
                panelWidth = $('#hiddenPanel').outerWidth();

            if( $$.is('.myButton') ){
                $('#hiddenPanel').animate({right:0}, speed);
                $$.removeClass('myButton')
            } else {
                $('#hiddenPanel').animate({right:-panelWidth}, speed);
                $$.addClass('myButton')
            }
			
				
				
				var ele = $('.icon-to-change');
  if(ele.hasClass('fa-download')){
  	ele.removeClass('fa-download')
       .addClass('fa-times')
  }
  else{
  	ele.addClass('fa-download')
       .removeClass('fa-times')
  }
				
				
				
			
				


        });