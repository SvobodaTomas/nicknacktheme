<section id="section-<?php the_ID(); ?>" class="homeSlide homeSlide--services">
	<?php
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

		get_template_part( 'template-parts/section', 'color-scheme' );
	?>

	<div class="bcg" style="background-image: url('<?=$img[0]?>');">
		<div class="hsContainer">
			<div class="hsContent">

				<h2 class="hsHeading"><?php the_title(); ?></h2>

				<div class="row">
					<?php
						echo do_shortcode('[sluzby]');

						get_template_part( 'template-parts/section', 'button' );
					?>
				</div>
			</div>
		</div>
	</div>
</section>