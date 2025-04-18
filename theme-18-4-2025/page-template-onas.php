<?php
/*
Template Name: O nás
*/
get_header();

?>

<?php while ( have_posts() ) : the_post(); ?>

<section class="onas-header">
  <div class="row">
    <div class="large-12 columns">
      <h1 class="entry-title"><?php the_title(); ?></h1>      
      <?php the_content(); ?>
      <a href="<?=get_permalink(icl_object_id(1913, 'page'))?>" class="button"><?php _e('Get in touch with us') ?></a>
    </div>    
  </div> 
</section>

<section class="onas-section">  
  <h2><?php _e('Who is the brain behind Nicknack?') ?></h2>
  <?php the_post_thumbnail('full')?>
  
  <h2><?php _e('NICKNACK History') ?></h2>
  <div class="timeline">
    <div id="cd-timeline" class="cd-container history">
  
    <?php              
      $hlist = get_posts(
        array(
          'showposts' => -1, 
          'post_type' => 'history',
          'suppress_filters' => false,
          'orderby' => 'menu_order', 
          'order' => 'asc'                
        )
      );                          
      $i = 0;  
                
      foreach ($hlist as $h) {  $i++;
      
        echo '<div class="cd-timeline-block">                    
                <div class="cd-timeline-img-cover">
            	 	  <div class="cd-timeline-img cd-picture">              
            		    <span class="cd-date">'.$h->post_title.'</span>
            		  </div> <!-- cd-timeline-img -->
                </div>
              
          		  <div class="cd-timeline-content">
          		  	<p>'.$h->post_content.'</p>    		          			  
          		  </div>
          	 </div>';                 
        }

    ?>
      
    </div>
  </div>      
  
  <?php if ( ICL_LANGUAGE_CODE != 'pl') { ?>
    <h2 class="headline"><?php _e('NICKNACK in the media', 'nicknack') ?></h2>
    <div class="row clanky"> 
    <?php   
    $i = 0;     
    $clanky = get_posts(
      array(
        'numberposts' => -1, 
        'post_type' => 'clanky',
        'suppress_filters' => false,
        'orderby' => 'menu_order', 
        'order' => 'asc'                
      )
    );   
    foreach($clanky as $clanek) { $i++;
      echo ((($i-1)%2) == 0) ? '<div class="row onas-row">' : '';
      echo '<div class="large-6 medium-6 small-12 left columns">             
               <h3><a href="'.get_field('zdroj', $clanek->ID).'" target="_blank">'.$clanek->post_title.'</a> <small>('.get_field('nazev_zdroje', $clanek->ID).' / '.get_the_time('j.n.Y', $clanek->ID).')</small></h3>             
            </div>';
      echo (($i%2) == 0 || $i == count($clanky)) ? '</div>' : '';
    }
    ?>  
    </div>   
  <?php } ?>
           
      
      
</section>

<?php endwhile; // end of the loop. ?>



<script>
jQuery(document).ready(function($){
	var $timeline_block = $('.cd-timeline-block');

	//hide timeline blocks which are outside the viewport
	$timeline_block.each(function(){
		if($(this).offset().top > $(window).scrollTop()+$(window).height()*0.75) {
			$(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
		}
	});

	//on scolling, show/animate timeline blocks when enter the viewport
	$(window).on('scroll', function(){
		$timeline_block.each(function(){
			if( $(this).offset().top <= $(window).scrollTop()+$(window).height()*0.75 && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) {
				$(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
			}
		});
	});
});
</script>



<?php get_footer(); ?>