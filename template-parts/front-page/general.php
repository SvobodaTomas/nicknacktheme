<?php
$img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

// $section_bg = get_field('section_bg_color');
// $title_color = get_field('section_title_color');
get_template_part( 'template-parts/section', 'color-scheme' );
?>
<section id="section-<?php the_ID(); ?>" class="homeSlide homeSlide--general">
	<div class="bcg">
		<div class="hsContainer">

			<div class="hsContent">

				<h2 class="hsHeading"><?php the_title(); ?></h2>

				<div class="row">
					<?php

						global $post;
						$backup = $post;

						echo apply_filters( 'the_content', get_post_field('post_content', get_the_ID()) );

						// For proper post ID (the content could contain some custom WP_Query)
						$post = $backup;
						get_template_part( 'template-parts/section', 'button' );

					?>
				</div>
			</div>

		</div>
	</div>
</section>