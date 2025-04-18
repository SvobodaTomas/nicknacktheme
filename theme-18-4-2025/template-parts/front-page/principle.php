<?php
$img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

$section_bg = get_field('section_bg_color');
$title_color = get_field('section_title_color');
?>

<section class="homeSlide homeSlide--principle">

	<div class="bcg"
		data-center="background-position: 50% 0px;"
		data-top-bottom="background-position: 50% -100px;"
		data-anchor-target=""
		style="background-image: url('<?=$img[0]?>')">

		<div class="hsContainer hsContainerOverlay">
			<div class="hsContent">

				<h2 class="hsHeading"
					data-150-top="opacity: 1"
					data-80-top="opacity: 1"
					data-anchor-target="">
					<?php the_title(); ?>
				</h2>

				<div class="row wide"
					data-100-top="opacity: 1"
					data--50-top="opacity: 1"
					data-anchor-target="">

					<?php

						echo apply_filters( 'the_content', get_post_field('post_content', get_the_ID()) );

					?>

					<div class="reuse-system">
						<div class="large-4 medium-4 small-12 columns">
							<img src="<?= get_field('reuse_img1'); ?>" alt="" />
							<div class="reuse-popis">
								<span class="reuse-order-number"><span class="number">1</span></span>
								<?= get_field('reuse_popis1'); ?>
							</div>
						</div>
						<div class="large-4 medium-4 small-12 columns">
							<img src="<?= get_field('reuse_img2'); ?>" alt="" />
							<div class="reuse-popis">
								<span class="reuse-order-number"><span class="number">2</span></span>
								<?= get_field('reuse_popis2', $slide->ID) ?>
							</div>
						</div>
						<div class="large-4 medium-4 small-12 columns">
							<img src="<?= get_field('reuse_img3'); ?>" alt="" />
							<div class="reuse-popis">
								<span class="reuse-order-number"><span class="number">3</span></span>
								<?= get_field('reuse_popis3', $slide->ID) ?>
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<?php

						get_template_part( 'template-parts/section', 'button' );

					?>

				</div>

			</div>
		</div>

	</div>
	<script>
		jQuery(document).ready(function($) {
			$('.homeSlide--principle .button').appear(function() {
				setTimeout(function() {  
					$('.reuse-system').css('margin-left', 0);
				}, 200);
			});
			$('.homeSlide--principle .clear').appear(function() {
				setTimeout(function() {
					$('.reuse-system').css('margin-left', 0);
				}, 200);
			});
		});
	</script>
</section>