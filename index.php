<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage WP_Forge
 * @since WP-Forge 5.5.0.1
 */

get_header(); ?>

<section class="news-header">
  <div class="row">
    <div class="large-12 columns">
      <h1><?= get_the_title(icl_object_id(11, 'page')) ?></h1>  
    </div>
  </div>
</section>

<section class="timeline news">
  <div id="cd-timeline" class="cd-container">
    <?php if ( have_posts() ) : ?>
    	<?php while ( have_posts() ) : the_post(); ?>

    	<div class="cd-timeline-block">

        <div class="cd-timeline-img-cover">
      		<div class="cd-timeline-img cd-picture">
      			<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('thumbnail') ?></a>
      		</div> <!-- cd-timeline-img -->
        </div>

    		<div class="cd-timeline-content">
          <div class="cd-date">
            <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
            <?php the_date() ?>
          	</div>
    			<?php the_excerpt() ?> <a href="<?php the_permalink() ?>"><?php _e('Read more') ?></a>
    		</div> <!-- cd-timeline-content -->
    	</div> <!-- cd-timeline-block -->

    	<?php endwhile; ?>
    <?php else : ?>
    	<?php get_template_part( 'content', 'none' ); ?>
    <?php endif; // end have_posts() check ?>
  </div>
</section> <!-- cd-timeline -->


<section class="news-footer">
  <div class="row">
    <div class="large-12 columns">
      <a href="<?=get_permalink(icl_object_id(1913, 'page'))?>" class="button"><?php _e('Get in touch with us!') ?></a>  
    </div>
  </div>
</section>

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
				console.log("scrolling ...");
			$timeline_block.each(function(){
				if( $(this).offset().top <= $(window).scrollTop()+$(window).height()*0.75 && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) {
					$(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
				}
			});
		});

	});
</script>


<?php get_footer(); ?>