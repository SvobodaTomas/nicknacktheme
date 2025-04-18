<?php get_header(); ?>

<div class="row">

	<div id="content" class="large-12 columns" role="main">
      
      <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">','</p>'); } ?>

		<article id="post-0" class="post error404 no-results not-found">
			<div class="entry-content">
				<h1><?php _e( '404: Not found', 'wpforge' ); ?></h1>
				<h2><?php _e( 'This is somewhat embaressing, isn\'t it?' ); ?></h2>        
				<p><?php _e( 'The post, page or whatever it was you were looking for might not be here. It could have been moved, deleted or maybe the URL you typed or the link you clicked was incorrect in some way.', 'wpforge' ); ?></p>
			</div><!-- .entry-content -->
		</article><!-- #post-0 -->

	</div><!-- #content -->
    
</div>

<?php get_footer(); ?>
