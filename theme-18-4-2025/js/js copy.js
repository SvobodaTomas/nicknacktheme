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
  $('#slider').imagesLoaded( function() {
    setTimeout(function() {
      // Resize sections
      adjustWindow();
      // Fade in sections
      $body.removeClass('loading').addClass('loaded');
    }, 100);

    setTimeout(function() {
      jQuery('#slider .demo-inner-content').css({"margin-top":"0px"}, "slow");
    }, 500);

    setTimeout(function() {
      jQuery('#slider .demo-inner-content h2').css({"margin-right":"0px","opacity":"1"}, "fast");
    }, 1000);

    setTimeout(function() {
      jQuery('#slider .demo-inner-content h1').css({"margin-left":"0px","opacity":"1"}, "fast");
    }, 1000);

    setTimeout(function() {
      jQuery('#slider .demo-inner-content p.animation').css({"margin-right":"0px","opacity":"1"}, "slow");
    }, 500);
  });

  function adjustWindow(){
    
      
    // Get window size
    winH = $window.height();
    winW = $window.width();
      
    // Keep minimum height 550
    if(winH <= 550) {
        winH = 550;
    }
      
    // Init Skrollr for 768 and up
    if( winW >= 768) {

        // Init Skrollr
        var s = skrollr.init({
            // forceHeight: false
        });

        // Resize our slides
        /*
        $slide.height(winH);
        $slider.height(winH);
        $sliderLi.height(winH);
        */
        //s.refresh($('.homeSlide'));
        

    } else {

        // Init Skrollr
        var s = skrollr.init();
        s.destroy();
    }

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

  //enquire.register("screen and (min-width : 768px)", initAdjustWindow(), false);  
  
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


