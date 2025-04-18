<?php
/**
 * The template for displaying Archive of FAQ.
 */

get_header(); ?>
<div class="">

	<div class="row">
		<div class="large-12 columns">
		
			<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">','</p>'); } ?>

		</div>
	</div>

	<?php if ( have_posts() ) : ?>

		<div class="row">
			<div class="large-12 columns" role="main">
				<header class="faq-archive-header row">
					<h1 class="archive-header-title element--lined small-12 text-center"><span class="element--lined__inner"><?= __('Často kladené otázky'); ?></span></h1>
				</header><!-- .archive-header -->
			</div>
		</div>

		<div class="background--gray">
			<div class="row" role="main">
				<ul class="large-12 columns faq-archive-content accordion" data-accordion data-allow-all-closed="true">

				<?php
				/* Start the Loop */
				$i = 0;
				while ( have_posts() ) : the_post(); $i++;

					/* Include the post format-specific template for the content. If you want to
						* this in a child theme then include a file called content-___.php
						* (where ___ is the post format) and that will be used instead.
						*/
					//get_template_part( 'content', get_post_format() ); ?>
					<li class="accordion-navigation">
						<a href="#faq-<?= $i; ?>" data-content="panel3a"><?php the_title(); ?></a>
						<div id="faq-<?= $i; ?>" class="content"><?php the_content(); ?></div>
					</li>

					<?php
				endwhile; ?>

				</ul>
			</div>
		</div>

		<?php wpforge_content_nav( 'nav-below' ); ?>

	<?php else : ?>
		<?php get_template_part( 'content', 'none' ); ?>
	<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>