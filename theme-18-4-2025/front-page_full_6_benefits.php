<?php get_header(); ?>                     
                       
  <!-- begin parallax -->                       
  <div class="parallax" id="skrollr-body">
  
    <div class="header-socials">
      <div class="social-caption">
        <?php _e('Follow us on', 'nicknack') ?> &nbsp;&nbsp; 
      </div>
      <div class="social-fb">
          <?php if ( ICL_LANGUAGE_CODE == 'pl' ) : ?>
            <a href="<?=get_field('settings-facebook', 1413, false, 'cs')?>" target="_blank">
              <span>Facebook</span>
            </a>
          <?php else : ?>
            <a href="<?=get_field('settings-facebook', 554, false, 'cs')?>" target="_blank">
              <span>Facebook</span>
            </a>
          <?php endif; ?>
      </div> 
    </div>
               
    <?php
    
    $i = 0;  
    $slidelist = get_posts(
      array(
        'showposts' => -1, 
        'post_type' => 'homepage',
        'suppress_filters' => false,
        'orderby' => 'menu_order', 
        'order' => 'asc'
  
      )
    );
                
    foreach ($slidelist as $slide) { $i++;               
    
      $slide_id = icl_object_id($slide->ID, 'homepage', false, 'cs');
    
    
      //slide with slider
      if($slide_id == 172) {
      
        
        $slide_img[1] = get_field("slide1", 172);
        $slide_img[2] = get_field("slide2", 172);
        $slide_img[3] = get_field("slide3", 172);
        $slide_img[4] = get_field("slide4", 172);
        $slide_img[5] = get_field("slide5", 172);
        
        //img to string                
        $j = 0;
        $images = '';        
        foreach($slide_img as $img) {                  
          if(empty($img)) continue;  
          $j++;                
          $images .= ($j != 1) ? ', ' : '';          
          $images .= '"'.$img['url'].'"';
        }
                                               
    ?>

    


    <section id="slide-<?=$i?>" class="slide-<?=$slide_id?> homeSlide">
                    
    	<div id="slider" data-zs-src='[<?=$images?>]' data-zs-overlay="dots">
      
        <?php //preload ?>  
        <div class="preload" style="display: none"> 
          <img src="<?=$slide_img[1]['url']?>" />                               
        </div> 
      
                       
    		<div class="demo-inner-content">
    			<?= apply_filters( 'the_content', get_post_field('post_content', $slide->ID) ) ?>
    		</div>
    	</div>
       
    </section>
    
          
  
    <?php    
      
      //slide with cup animation
      } elseif($slide_id == 200) {
      
    ?>
     
      <section id="slide-<?=$i?>" class="slide-<?=$slide_id?>">           
        <div class="bcg">
           <div class="hsContainer">  
              <?php //PC ?>                  
              <div class="hsContent show-for-large-up">
                                                 
                <div class="hsFixedHeading" data-0="position: absolute; top:80px;" data-840="position: fixed; top:80px;" data-1300="display:block;" data-1400="top:-10%;display:none;">               
                  <h2 class="hsHeading"><?= $slide->post_title ?></h2> 
                  <?= apply_filters( 'the_content', get_post_field('post_content', $slide->ID) ); ?>                    
                </div>
                       
                <div class="row" style="text-align: center;">
                                        
                  <div class="cup1" data-200="display: block; left:150%;" data-900="left:50%;margin-top: 320px; display: block;" data-1300="position: fixed; top: 0%" data-1301="position: absolute; top: 410px;">
                		  <img src="<?=get_template_directory_uri()?>/images/cup1.png" alt="" />
                	</div>
                  
                  <div class="cup2" data-200="display: block; right:150%;" data-900="right:50%;margin-top: 437px; display: block;" data-1300="position: fixed; top: 0%" data-1301="position: absolute; top: 410px;">
                		  <img src="<?=get_template_directory_uri()?>/images/cup2.png" alt="" />
                	</div>
                  
<!--
                  <div class="puntik" data-200="display: none; width: 1px;" data-900="margin-top: 295px; display: block;" data-1100="width: 111px;" data-1300="position: fixed; top: 0%;" data-1301="position: absolute; top: 410px;">
                		  <img src="<?=get_template_directory_uri()?>/images/puntikk<?php if (ICL_LANGUAGE_CODE == 'en') { echo '_en';} elseif (ICL_LANGUAGE_CODE == 'pl') {echo '_pl';} else { echo '';} ?>.png" alt="" />
                	</div>                  
-->
                  
                  <div class="product-labels" data-0="display: none;" data-900="display: block; opacity: 1" data-1300="position: fixed; top: 0%" data-1301="position: absolute; top: 410px;">
                    <div class="product-label-1"><h3 data-900="opacity:0;font-size:1px;" data-1200="opacity:1;font-size:16px;"><?php _e('Light, firm and durable material', 'nicknack') ?></h3></div>
                    <div class="product-label-2"><h3 data-910="opacity:0;font-size:1px;" data-1210="opacity:1;font-size:16px;"><?php _e('Either with a print or plain', 'nicknack') ?></h3></div>
                    <div class="product-label-3"><h3 data-920="opacity:0;font-size:1px;" data-1220="opacity:1;font-size:16px;"><?php _e('Production of it is eco-friendly', 'nicknack') ?></h3></div>
                    <div class="product-label-4"><h3 data-930="opacity:0;font-size:1px;" data-1230="opacity:1;font-size:16px;"><?php _e('Practical hang clip', 'nicknack') ?></h3></div>
                    <div class="product-label-5"><h3 data-940="opacity:0;font-size:1px;" data-1240="opacity:1;font-size:16px;"><?php _e('Transparent or coloured cups', 'nicknack') ?></h3></div>
                    <div class="product-label-6"><h3 data-950="opacity:0;font-size:1px;" data-1250="opacity:1;font-size:16px;"><?php _e('100% homemade', 'nicknack') ?></h3></div>
                  </div>  
                  <?php                                                                          
                    $odkaz = get_field('odkaz', $slide->ID);
                    
                    if(!empty($odkaz)) {
                      echo '<div class="clear"><a href="'.$odkaz.'" class="button">'.get_field('text_odkazu', $slide->ID).'</a></div>';
                    }                        
                  ?>  
                                                                                                                             
                </div>                    
             </div>  
             
             
             <?php //tablets ?>
                                          
             <div class="hsContent show-for-medium-only">
               <h2 class="hsHeading"><?= $slide->post_title ?></h2>                                                                                                           
               <div class="row">
               
                 <?= apply_filters( 'the_content', get_post_field('post_content', $slide->ID) ); ?>
                 <img src="<?=get_template_directory_uri()?>/images/kelimkky.jpg" alt="Kelímky" />
                 <?php                                                                          
                   $odkaz = get_field('odkaz', $slide->ID);
                   
                   if(!empty($odkaz)) {
                     echo '<div class="clear"><a href="'.$odkaz.'" class="button">'.get_field('text_odkazu', $slide->ID).'</a></div>';
                   }                        
                 ?>                    
               </div>
             </div>
           
             <?php //mobiles ?>
                                          
             <div class="hsContent show-for-small-only">
               <h2 class="hsHeading"><?= $slide->post_title ?></h2>                                                                                                           
               <div class="row">
               
                 <?= apply_filters( 'the_content', get_post_field('post_content', $slide->ID) ); ?>
                 <img src="<?=get_template_directory_uri()?>/images/kelimkky_small.jpg" alt="Kelímky" />
                 <h3><?php _e('Light, firm and durable material', 'nicknack') ?></h3>
                 <h3><?php _e('Either with a print or plain', 'nicknack') ?></h3>
                 <h3><?php _e('Production of it is eco-friendly', 'nicknack') ?></h3>
                 <h3><?php _e('Practical hang clip', 'nicknack') ?></h3>
                 <h3><?php _e('Transparent or coloured cups', 'nicknack') ?></h3>
                 <h3><?php _e('100% homemade', 'nicknack') ?></h3>   
                              
                 <?php                                                                          
                   $odkaz = get_field('odkaz', $slide->ID);
                   
                   if(!empty($odkaz)) {
                     echo '<div class="clear"><a href="'.$odkaz.'" class="button">'.get_field('text_odkazu', $slide->ID).'</a></div>';
                   }                        
                 ?>                    
               </div>
             </div>                      
                      
                                   
                            
          </div>
       </div>
    </section>
      
 
    <?php 
    
      //reuse slide
      } elseif($slide_id == 197) {
      
          $img = wp_get_attachment_image_src( get_post_thumbnail_id($slide->ID), 'full' );
      
    ?>
    
    
    <section id="slide-<?=$i?>" class="slide-<?=$slide_id?> homeSlide"> 
       
      <div class="bcg"            
        data-center="background-position: 50% 0px;"
        data-top-bottom="background-position: 50% -100px;"
        data-anchor-target="#slide-<?=$i?>"
        style="background-image: url('<?=$img[0]?>')">
        
        <div class="hsContainer">                                  
          <div class="hsContent">
                                            
            <h2 class="hsHeading"  
              data-150-top="opacity: 1"
              data-80-top="opacity: 1"
              data-anchor-target="#slide-<?=$i?> h2">
              <?= $slide->post_title ?>
            </h2>
                                  
            <div class="row"                     
              data-100-top="opacity: 1"
              data--50-top="opacity: 1"
              data-anchor-target="#slide-<?=$i?> .row">
              
              <?= apply_filters( 'the_content', get_post_field('post_content', $slide->ID) ); ?>
         
              <div class="reuse-system">                      
                <div class="large-4 medium-4 small-12 columns">
                  <img src="<?= get_field('reuse_img1', $slide->ID) ?>" alt="" />
                  <div class="reuse-popis"><?= get_field('reuse_popis1', $slide->ID) ?></div>                        
                </div>
                <div class="large-4 medium-4 small-12 columns">
                  <img src="<?= get_field('reuse_img2', $slide->ID) ?>" alt="" />
                  <div class="reuse-popis"><?= get_field('reuse_popis2', $slide->ID) ?></div>                        
                </div>
                <div class="large-4 medium-4 small-12 columns">
                  <img src="<?= get_field('reuse_img3', $slide->ID) ?>" alt="" />
                  <div class="reuse-popis"><?= get_field('reuse_popis3', $slide->ID) ?></div>
                </div>
              </div>
              
              <?php                                                                          
                $odkaz = get_field('odkaz', $slide->ID);
                
                if(!empty($odkaz)) {
                  echo '<div class="clear"><a href="'.$odkaz.'" class="button">'.get_field('text_odkazu', $slide->ID).'</a></div>';
                }                        
              ?>  
                                                                        
            </div>                    
          </div>                             
        </div>
      </div>
    </section>    
    
    
    <?php            
      
      //custom slide
      } else {   
          
        $img = wp_get_attachment_image_src( get_post_thumbnail_id($slide->ID), 'full' );            
    ?> 

    <?php if($i == 3) {

      $uploads = wp_upload_dir();
      $uploads_dir = $uploads['baseurl'];

      if (ICL_LANGUAGE_CODE == 'pl') {
        $poster_url = get_template_directory_uri() . '/video/video_caption_pl.jpg';
        $video_urls = array(
          $uploads_dir . '/video/nicknack_pl.m4v',
          $uploads_dir . '/video/nicknack_pl.webm'
        );
      } else {
        $poster_url = get_template_directory_uri() . '/video/video_caption.jpg';
        $video_urls = array(
          $uploads_dir . '/video/Nicknack_video.mp4',
          $uploads_dir . '/video/Nicknack.webm'
        );
      } ?>
     <section class="cont-vid" >
        <video id="promo" preload="auto"  width="auto" poster="<?php echo $poster_url; ?>">      
          <source src="<?php echo $video_urls[0]; ?>" type="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2&quot;">
          <source src="<?php echo $video_urls[1]; ?>" type="video/webm; codecs=&quot;vp8, vorbis&quot;">

          <?php _e('Video not supported.', 'nicknack'); ?>
            

          <script>
          (function($) {

          $('#promo').click(function() {
            if (this.paused) {

            } else {
              if ( $(window).width() > 1025 ) {
                  $('html, body').delay(500).animate({
                      scrollTop: $("#promo").offset().top - 50
                  }, 500);
              }
            }
          });


              /* ------ Video controls ---- */
              

              $('.cont-vid').hover(
                function () {
                  jQuery('video#promo').attr("controls", "controls");    
                },
                function () {
                  jQuery('video#promo').removeAttr("controls");
                }
              );

              $(document).ready(function(){
                $('video#promo').on('ended',function(){
                  $('video#promo').load();
                  $('video#promo').removeClass('bg_vid');
                  $('#play').show();
                  $('.cont-vid').removeClass('widened');
                  
                });

                $('#promo').on('playing', function() {
                  $('video#promo').addClass('bg_vid');
                  $('#play').hide();
                  $('.cont-vid').addClass('widened');


                if ( $(window).width() > 1025 ) {
                  $('html, body').delay(500).animate({
                      scrollTop: $("#promo").offset().top - 50
                  }, 500);
                }

                });
              });    
            })(jQuery);   
          </script>
            
        </video>
        <div id="buttonbar">        
              <button id="play" onclick="vidplay();">
                <svg version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px"
                  viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
                <path d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M45.563,30.826l-22,15
                  C23.394,45.941,23.197,46,23,46c-0.16,0-0.321-0.038-0.467-0.116C22.205,45.711,22,45.371,22,45V15c0-0.371,0.205-0.711,0.533-0.884
                  c0.328-0.174,0.724-0.15,1.031,0.058l22,15C45.836,29.36,46,29.669,46,30S45.836,30.64,45.563,30.826z"/>
                </svg>

              </button>       
          </div>  
        </section> 
      </div> 
      <script>
    /**
    * Video fns definitions
    */

    function vidplay() {
              
        var video = document.getElementById("promo");
        var button = document.getElementById("play");            
        video.volume = 0.35;
                      
        video.play(); 
        jQuery('#buttonbar').addClass('hidden');
        
    }


    function restart() {
        var video = document.getElementById("promo");
        video.currentTime = 0;
    }

    function skip(value) {
        var video = document.getElementById("promo");
        video.currentTime += value;
    }   

    </script>
    <?php } ?>
 
    <section id="slide-<?=$i?>" class="slide-<?=$slide_id?> homeSlide"> 
       
        <div class="bcg"            
            data-center="background-position: 50% 0px;"
            data-top-bottom="background-position: 50% -100px;"
            data-anchor-target="#slide-<?=$i?>"
            style="background-image: url('<?=$img[0]?>')">
            <div class="hsContainer">
                
                <?php if($slide_id == 412) { ?>
                
  
                  <!-- reveal modal video -->
                  <div id="videoModal" class="reveal-modal large" data-reveal aria-labelledby="videoModalTitle" aria-hidden="true" role="dialog">    
                    <div class="flex-video widescreen vimeo">
                      <?= get_field('video', 412) ?>
                    </div> 
                    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                  </div>
                  
                                  
                <a href="#" data-reveal-id="videoModal">                                
                <?php } ?>
                                    
                <div class="hsContent">
                                
                    <?php if($i != 1) { ?>
                    <h2 class="hsHeading"  
                      data-150-top="opacity: 1"
                      data-80-top="opacity: 1"
                      data-anchor-target="#slide-<?=$i?> h2">
                      <?= $slide->post_title ?>
                    </h2>
                    <?php } ?>
                    
                    <div class="row"                     
                      data-100-top="opacity: 1"
                      data--50-top="opacity: 1"
                      data-anchor-target="#slide-<?=$i?> .row">
                      
                      <?php                      
                        $fakta_text1 = get_field('fakta_text1', $slide->ID);
                        if(!empty($fakta_text1)) {                        
                      ?>
                      
                        <div class="fakta">                      
                          <div class="large-3 medium-6 small-12 columns">
                            <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo1', $slide->ID).'</span>', get_field('fakta_text1', $slide->ID)) ?>
                          </div>
                          <div class="large-3 medium-6 small-12 columns">
                            <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo2', $slide->ID).'</span>', get_field('fakta_text2', $slide->ID)) ?>                       
                          </div>
                          <div class="large-3 medium-6 small-12 columns"> 
                            <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo3', $slide->ID).'</span>', get_field('fakta_text3', $slide->ID)) ?>                    
                          </div>
                          <div class="large-3 medium-6 small-12 columns">
                            <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo4', $slide->ID).'</span>', get_field('fakta_text4', $slide->ID)) ?>                    
                          </div>
                        </div>
                      
                      <?php                          
                        }                        
                                           
                        echo apply_filters( 'the_content', get_post_field('post_content', $slide->ID) );
                        
                        if($slide_id == 197) {                        
                      ?>
                      
                        <div class="reuse-system">                      
                          <div class="large-4 medium-4 small-12 columns">
                            <img src="<?= get_field('reuse_img1', $slide->ID) ?>" alt="" />
                            <div class="reuse-popis"><?= get_field('reuse_popis1', $slide->ID) ?></div>                        
                          </div>
                          <div class="large-4 medium-4 small-12 columns">
                            <img src="<?= get_field('reuse_img2', $slide->ID) ?>" alt="" />
                            <div class="reuse-popis"><?= get_field('reuse_popis2', $slide->ID) ?></div>                        
                          </div>
                          <div class="large-4 medium-4 small-12 columns">
                            <img src="<?= get_field('reuse_img3', $slide->ID) ?>" alt="" />
                            <div class="reuse-popis"><?= get_field('reuse_popis3', $slide->ID) ?></div>
                          </div>
                        </div>
                      
                      <?php                          
                        }  
                        
                        
                        
                                                
                        $odkaz = get_field('odkaz', $slide->ID);
                        
                        if(!empty($odkaz)) {
                          echo '<div class="clear"><a href="'.$odkaz.'" class="button">'.get_field('text_odkazu', $slide->ID).'</a></div>';
                        }                        
                      ?>  
                                                                            
                    </div>                    
                </div>
                                
                <?php if($slide_id == 412) { ?>
                </a>
                <?php } ?>
                                
            </div>
        </div>
    </section>
    
    
    <?php }
      } 
    ?>
           
  </div>
   
  <!--
  <div class="row">
  	<div id="content" class="large-12 columns" role="main">        	
  
  			<?php while ( have_posts() ) : the_post(); ?>
  				<?php //get_template_part( 'content', 'page' ); ?>
  				<?php //comments_template( '', true ); ?>
  			<?php endwhile; // end of the loop. ?>
            
  	</div>
    
  </div>
  -->
    
  <script src="<?= get_template_directory_uri() ?>/js/imagesloaded.js"></script>
  <script src="<?= get_template_directory_uri() ?>/js/enquire.min.js"></script>
  <script src="<?= get_template_directory_uri() ?>/js/skrollr/src/skrollr.js"></script>
  <script src="<?= get_template_directory_uri() ?>/js/js.js?v=11"></script>
  
  <script src="<?= get_template_directory_uri() ?>/js/jquery.countTo.js"></script>
  <script src="<?= get_template_directory_uri() ?>/js/jquery.appear.min.js"></script>
  <script>
  jQuery(document).ready(function($) {
    $('.fakta .large-3').appear(function() {
        var count_element = $('.animate-me', this).html();
        $(".animate-me", this).countTo({
            from: 0,
            to: count_element,
            speed: 2500,
            refreshInterval: 50,
        });
    });

    $('.slide-197 .button').appear(function() {
      setTimeout(function() {
        $('.reuse-system').css('margin-left', 0);
      }, 200);
    });
  });
  </script>

<?php get_footer(); ?>