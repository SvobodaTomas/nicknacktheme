<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage WP_Forge
 * @since WP-Forge 5.5.0.1
 */

get_header(); ?>

<div class="row">
	<div id="content" class="large-12 columns" role="main">
      
        <?php while ( have_posts() ) : the_post(); ?>

            <div class="large-12 columns text-center">
                <h1>Pracovní pozice</h1>  
            </div>

            <nav class="nav-single">

                <div class="large-6 medium-6 columns">
                    <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&laquo;', 'Previous post link', 'wpforge' ) . '</span> %title' ); ?></span>  
                </div>            
                <div class="large-6 medium-6 columns">
                    <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&raquo;', 'Next post link', 'wpforge' ) . '</span>' ); ?></span>  
                </div> 

            </nav><!-- .nav-single -->

            <?php //get_template_part( 'content', get_post_format() ); ?>
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>

            <nav class="nav-single"> 
                <div class="large-6 medium-6 columns">
                    <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&laquo;', 'Previous post link', 'wpforge' ) . '</span> %title' ); ?></span>  
                </div>            
                <div class="large-6 medium-6 columns">
                    <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&raquo;', 'Next post link', 'wpforge' ) . '</span>' ); ?></span>  
                </div>				
            </nav><!-- .nav-single -->

        <?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div>

<?php get_footer(); ?>