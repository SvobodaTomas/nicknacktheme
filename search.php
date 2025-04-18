<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage WP_Forge
 * @since WP-Forge 5.5.0.1
 */

get_header(); ?>

<div class="row">
	<div id="content" class="large-12 columns" role="main">        	

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h3><?php printf( __( 'Search Results for: %s', 'wpforge' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
			</header>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'loop' ); ?>
			<?php endwhile; ?>

			<?php wpforge_content_nav( 'nav-below' ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- #content -->
</div>

<?php get_footer(); ?>