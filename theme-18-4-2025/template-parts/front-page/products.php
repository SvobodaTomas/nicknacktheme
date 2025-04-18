<section class="homeSlide homeSlide--products">
	<div class="bcg">
		<div class="hsContainer">
			<div class="hsContent">
				<h2 class="hsHeading"><?php the_title(); ?></h2>
			</div>
		</div>
		<?= ''//apply_filters( 'the_content', get_post_field('post_content', $slide->ID) ); ?>
		<div class="content-wrapper"><?php the_content(); ?></div>
		<div class="properties">
			<?php for ( $i=1; $i<=5; $i++ ) : ?>
				<a class="item" data-options="ignore_repositioning:true; align:top; is_hover:true;" data-dropdown="drop_<?= $i; ?>"><span class="item__title"><span class="item__text"><?= get_field('property_'.$i.'_title'); ?></span></span></a>
				<div id="drop_<?= $i; ?>" class="property-content" data-dropdown-content>
					<?= get_field('property_'.$i.'_description'); ?>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</section>