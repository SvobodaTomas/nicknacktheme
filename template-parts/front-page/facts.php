<?php
	$img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

	// $section_bg = get_field('section_bg_color');
	// $title_color = get_field('section_title_color');
	get_template_part( 'template-parts/section', 'color-scheme' );
?>
<section class="homeSlide homeSlide--facts">
	<div class="bcg" style="background-image: url('<?=$img[0]?>');">
		<div class="hsContainer">

			<div class="hsContent">

				<h2 class="hsHeading"><?php the_title(); ?></h2>

				<div class="row">

					<?php

						$fakta_text1 = get_field('fakta_text1');

						if(!empty($fakta_text1)) {

					?>

					<div class="fakta row">
						<div class="large-3 medium-6 small-12 columns">
							<?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo1').'</span>', get_field('fakta_text1')) ?>
						</div>
						<div class="large-3 medium-6 small-12 columns">
							<?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo2').'</span>', get_field('fakta_text2')) ?>
						</div>
						<div class="large-3 medium-6 small-12 columns"> 
							<?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo3').'</span>', get_field('fakta_text3')) ?>
						</div>
						<div class="large-3 medium-6 small-12 columns">
							<?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo4').'</span>', get_field('fakta_text4')) ?>
						</div>
					</div>

					<?php

						}

						echo apply_filters( 'the_content', get_post_field('post_content', get_the_ID()) );

						get_template_part( 'template-parts/section', 'button' );

					?>

				</div>
			</div>

		</div>
	</div>
</section>