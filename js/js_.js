( function( $ ) {
	
	// Setup variables
	$window = $(window);
	$slide = $('.homeSlide');
  $slider = $('.orbit-slider');
  $sliderLi = $('.orbit-slider li');
	$slideTall = $('.homeSlideTall');
	$slideTall2 = $('.homeSlideTall2');
	$body = $('body');
	
    //FadeIn all sections   
	$body.imagesLoaded( function() {
		setTimeout(function() {
		      
		      // Resize sections
		      adjustWindow();
		      
		      // Fade in sections
			  $body.removeClass('loading').addClass('loaded');
			  
		}, 100);
	});
      	
	function adjustWindow(){
		
         var s = skrollr.init({
            //forceHeight: false
        });
        
 
    // Check for touch
    if(Modernizr.touch) {
 
        // Init Skrollr
        var s = skrollr.init();
        s.destroy();
    }
	    
	}
  
  function initAdjustWindow() {
      return {
          match : function() {
              adjustWindow();
          },
          unmatch : function() {
              adjustWindow();
          }
      };
  }
   
  enquire.register("screen and (min-width : 768px)", initAdjustWindow(), false);  
  
  /*
  function EasyPeasyParallax() {
    scrollPos = $(this).scrollTop();
    $('.header_container').css({
      'margin-top': (scrollPos/4)+"px",
      'opacity': 1-(scrollPos/250)
    });
  }
  $(document).ready(function(){
    $(window).scroll(function() {
      EasyPeasyParallax();
    });
  });
  */   
   		
} )( jQuery );      



/* smooth scrolling for IE
//if(navigator.appVersion.indexOf("MSIE")!=-1) {

    if (window.addEventListener) window.addEventListener('DOMMouseScroll', wheel, false);
      window.onmousewheel = document.onmousewheel = wheel;
      
      var time = 1000;
      var distance = 500;
      
      function wheel(event) {
          if (event.wheelDelta) delta = event.wheelDelta / 120;
          else if (event.detail) delta = -event.detail / 3;
      
          handle();
          if (event.preventDefault) event.preventDefault();
          event.returnValue = false;
      }
      
      function handle() {
      
          jQuery('html, body').stop().animate({
              scrollTop: jQuery(window).scrollTop() - (distance * delta)
          }, time);
      }
      
      
      jQuery(document).keydown(function (e) {
      
          switch (e.which) {
              //up
              case 38:
                  e.preventDefault();
                  jQuery('html, body').stop().animate({
                      scrollTop: jQuery(window).scrollTop() - distance
                  }, time);
                  break;
      
                  //down
              case 40:
                  e.preventDefault();
                  jQuery('html, body').stop().animate({
                      scrollTop: jQuery(window).scrollTop() + distance
                  }, time);
                  break;
          }
    });
//}        
  */