<?php
/**
 * The template for displaying Archive of pracovní pozice.
 */

get_header(); ?>

<div class="row">
	<div class="large-12 columns" role="main">
    
    	<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">','</p>'); } ?>

		<?php if ( have_posts() ) : ?>
			<header class="archive-header job-archive-header">
				<h1 class="job-archive-title"><?= __('Pracovní pozice'); ?></h1>
			</header><!-- .archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				//get_template_part( 'content', get_post_format() ); ?>
        
                <div class="job-archive-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>"><?= __('Read more'); ?></a>
                </div>

                <?php
			endwhile;

			wpforge_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
</div>

<?php get_footer(); ?>