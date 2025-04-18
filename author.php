<?php
/**
 * The template for displaying Author Archive pages.
 *
 * Used to display archive-type pages for posts by an author.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage WP_Forge
 * @since WP-Forge 5.5.0.1
 */

get_header(); ?>

<div class="row">
	<div id="content" class="large-12 columns" role="main">
    
    	<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">','</p>'); } ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/* Queue the first post, that way we know what author we're dealing with (if that is the case).
				 * We reset this later so we can run the loop properly with a call to rewind_posts().
				 */
				the_post();
			?>

			<header class="archive-header">
				<h3 class="archive-title"><?php printf( __( 'Author: %s', 'wpforge' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h3>
			</header><!-- .archive-header -->

			<?php
				/* Since we called the_post() above, we need to rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
			?>

			<?php
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>
				<div class="author-info small-12 medium-12 large-12 columns">
					<div class="author-avatar small-12 medium-12 large-12 columns">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'wpforge_author_bio_avatar_size', 200 ) ); ?>
					</div><!-- .author-avatar -->
					<div class="author-description small-12 medium-12 large-12 columns">
						<h3><?php printf( __( 'About %s', 'wpforge' ), get_the_author() ); ?></h3>
						<p><?php the_author_meta( 'description' ); ?></p>
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php wpforge_content_nav( 'nav-below' ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- #content -->
</div>

<?php get_footer(); ?>