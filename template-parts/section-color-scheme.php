<?php
$section_bg = get_field('section_bg_color');
$title_color = get_field('section_title_color');

if ( $title_color || $section_bg ) : ?>
	<style>
		<?php if ( $section_bg ) : ?>
			#section-<?php the_ID(); ?> .bcg,
			#section-<?php the_ID(); ?> .hsHeading {
				background-color:<?= $section_bg; ?>;
			}
		<?php endif; ?>
		<?php if ( $title_color ) : ?>
			#section-<?php the_ID(); ?> .hsHeading {
				color:<?= $title_color; ?>;
			}
			#section-<?php the_ID(); ?> .hsHeading::before,
			#section-<?php the_ID(); ?> .hsHeading::after {
				border-color:<?= $title_color; ?>;
			}
		<?php endif; ?>
	</style>
<?php endif; ?>