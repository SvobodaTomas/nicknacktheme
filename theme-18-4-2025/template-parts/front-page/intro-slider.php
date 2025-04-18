<section class="homeSlide homeSlide--intro-slider">
	<?php
		// Slides
		if( have_rows( 'slides' ) ) {
			while ( have_rows('slides') ) { the_row(); $j++;
				if ( $image_object = get_sub_field('slide') ) {
					if($j==1) $first_slide = $image_object['url'];
					$images_array[] = '"'.$image_object['url'].'"';
				}
			}
		}

		// Prepare string of slides url
		if ( !empty($images_array) ) {
			$images = implode(", ",$images_array);
		}
	?>

	<div id="slider" data-zs-src='[<?= $images; ?>]' data-zs-overlay="dots">
		<?php // Preload ?>
		<div class="preload" style="display: none">
			<img src="<?= $first_slide; ?>" />
		</div>

		<div class="demo-inner-content">
			<?= ''//apply_filters( 'the_content', get_post_field('post_content') ); ?>
			<?php the_content(); ?>
		</div>
	</div>
</section>