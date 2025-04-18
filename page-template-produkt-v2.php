<?php

/**
 * Template Name: Produkt v2
 */
get_header(); ?>

<!-- Main content section -->
<?php while (have_posts()) : the_post(); ?>

	<section class="produkt-section whitea">
		<div class="row heading-row">
			<div class="large-12 columns">
				<?php the_content(); ?>
				<h1 class="pinkish"><?php the_field("product2_title"); ?></h1>
			</div>
		</div>
	</section>

<?php endwhile; ?>

<?php // Get proper form id depending on current language

// CS
$form_id__iml = '7';
$form_id__sito = '9';
$form_id__color = '10';
$form_id__party = '11';

// PL
if (ICL_LANGUAGE_CODE == 'pl') {
	$form_id__iml = '15';
	$form_id__sito = '14';
	$form_id__color = '12';
	$form_id__party = '13';

	// EN
} elseif (ICL_LANGUAGE_CODE == 'en') {
	$form_id__iml = '21';
	$form_id__sito = '20';
	$form_id__color = '18';
	$form_id__party = '19';
}

$index = 0;
?>

<!-- IML -->
<?php
$index++;
$gif = wp_get_attachment_image_src(get_field("iml_gif"), "large");
$gifStatic = wp_get_attachment_image_src(get_field("iml_gif_static"), "large");
$badge = wp_get_attachment_image_src(get_field("iml_badge"), "medium");
?>
<section id="iml" class="iml cup-section section" idiml="<?= $form_id__iml; ?>" idsito="<?= $form_id__sito; ?>" idcolor="<?= $form_id__color; ?>" idparty="<?= $form_id__party; ?>">
	<div class="row medium">
		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number"><?= $index; ?></span><?php the_field("iml_name"); ?></h2>
			<p class="short-description">
				<?php the_field("img_short_desc"); ?>
			</p>
			<a href="#" class="toggle-btn">
				<span class="plus-btn">

				</span>
				<?php the_field("iml_btn_more_info_text"); ?>
			</a>
			<div class="long-desc-cont">
				<?php the_field("img_long_desc"); ?>
			</div>
			<ul class="attr-list">

				<?php while (have_rows("iml_attrs")) : the_row(); ?>

					<li><strong><?php the_sub_field("left"); ?></strong> <?php the_sub_field("right"); ?></li>

				<?php endwhile; ?>

			</ul>
			<div class="btn-cont">
				<a href="#" class="button toggle-form" id="toggleIML" data-reveal-id="<?= ICL_LANGUAGE_CODE == 'cs' ? 'inquiryForm' : 'formIML'; ?>"><?php the_field("iml_btn_order_text"); ?></a>
				<div id="formIML" class="product-form-modal reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
					<div class="row medium header">
						<div class="title-cont small-12 columns">
							<h2 class="form-header"><?php _e("OBJEDNEJTE SI NICKNACK", "nicknack"); ?></h2>
						</div>
					</div>
					<div class="row medium">
						<div class="small-12 columns">

							<?php echo (do_shortcode("[gravityform id=" . $form_id__iml . " title=false description=false ajax=false]")); ?>

						</div>
					</div>

					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
			</div>
		</div>
		<div class="image small-12 medium-5 large-5 columns">
			<div class="badge-cont">
				<img src="<?php echo ($badge[0]); ?>" alt="<?php _e("Foto realistický potisk", "nicknack"); ?>" />
			</div>
			<div class="img-cont">
				<img class="rotating" src="<?php echo ($gif[0]); ?>" alt="<?php _e("Kelímek s potiskem IML", "nicknack"); ?>" />
				<img class="static" src="<?php echo ($gifStatic[0]); ?>" alt="<?php _e("Kelímek s potiskem IML", "nicknack"); ?>" />
				<span class="rorate-icon">
					<img src="<?php echo (get_template_directory_uri()); ?>/images/icon_rotate.png" alt="<?php _e("Ikona rotace", "nicknack"); ?>" />
				</span>
			</div>
		</div>
	</div>
	<div class="row medium cup-slider-row">
		<h2><?php the_field("iml_slider_title"); ?></h2>
		<ul class="small-12 columns cup-slider">

			<?php $images = get_field('iml_gallery');

			foreach ($images as $image) : ?>

				<li>
					<a class="fancybox" rel="iml" href="<?php echo $image['url']; ?>">
						<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
					</a>
				</li>

			<?php endforeach; ?>

		</ul>
	</div>
</section>
<script>
	var imgGifUrl = "<?php echo ($gif[0]); ?>";
	var imgGifStaticUrl = "<?php echo ($gifStatic[0]); ?>";

	jQuery(".iml .img-cont").hover(
		function() {
			// jQuery(this).children("img").attr("src", imgGifUrl);
		},
		function() {
			// jQuery(this).children("img").attr("src", imgGifStaticUrl);
		}
	);
</script>

<!-- Sitotisk -->
<?php
$index++;
$gif2 = wp_get_attachment_image_src(get_field("rs_gif"), "large");
$gifStatic2 = wp_get_attachment_image_src(get_field("rs_gif_static"), "large");
$badge = wp_get_attachment_image_src(get_field("rs_badge"), "medium");
?>
<section id="sitotisk" class="rs cup-section section">
	<div class="row medium">
		<div class="image small-12 medium-5 large-5 columns">
			<div class="badge-cont">
				<img src="<?php echo ($badge[0]); ?>" alt="<?php _e("Již od 100 kusů", "nicknack"); ?>" />
			</div>
			<div class="img-cont">
				<img class="rotating" src="<?php echo ($gif2[0]); ?>" alt="<?php _e("Kelímek s potiskem Rotačním síťotiskem", "nicknack"); ?>" />
				<img class="static" src="<?php echo ($gifStatic2[0]); ?>" alt="<?php _e("Kelímek s potiskem Rotačním síťotiskem", "nicknack"); ?>" />
				<span class="rorate-icon">
					<img src="<?php echo (get_template_directory_uri()); ?>/images/icon_rotate.png" alt="<?php _e("Ikona rotace", "nicknack"); ?>" />
				</span>
			</div>
		</div>
		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number"><?= $index; ?></span><?php the_field("rs_name"); ?></h2>
			<p class="short-description">
				<?php the_field("rs_short_desc"); ?>
			</p>
			<a href="#" class="toggle-btn">
				<span class="plus-btn">

				</span>
				<?php the_field("rs_btn_more_info_text"); ?>
			</a>
			<div class="long-desc-cont">
				<?php the_field("rs_long_desc"); ?>
			</div>
			<ul class="attr-list">

				<?php while (have_rows("rs_attrs")) : the_row(); ?>

					<li><strong><?php the_sub_field("left"); ?></strong> <?php the_sub_field("right"); ?></li>

				<?php endwhile; ?>

			</ul>
			<div class="btn-cont">
				<a href="#" class="button toggle-form" id="toggleIML" data-reveal-id="<?= ICL_LANGUAGE_CODE == 'cs' ? 'inquiryForm' : 'formST'; ?>"><?php the_field("rs_btn_order_text"); ?></a>
				<div id="formST" class="product-form-modal  reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
					<div class="row medium header">
						<div class="title-cont small-12 columns">
							<h2 class="form-header"><?php _e("OBJEDNEJTE SI NICKNACK", "nicknack"); ?></h2>
						</div>
					</div>
					<div class="row medium">
						<div class="small-12 columns">

							<?php echo (do_shortcode("[gravityform id=" . $form_id__sito . " title=false description=false ajax=false]")); ?>

						</div>
					</div>

					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row medium cup-slider-row">
		<h2><?php the_field("rs_slider_title"); ?></h2>
		<ul class="small-12 columns cup-slider">

			<?php
			$images = get_field('rs_gallery');

			foreach ($images as $image) : ?>

				<li>
					<a class="fancybox" rel="rs" href="<?php echo $image['url']; ?>">
						<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
					</a>
				</li>

			<?php endforeach; ?>

		</ul>
	</div>
</section>
<script>
	var imgGifUrl2 = "<?php echo ($gif2[0]); ?>";
	var imgGifStaticUrl2 = "<?php echo ($gifStatic2[0]); ?>";

	jQuery(".rs .img-cont").hover(
		function() {
			// jQuery(this).children("img").attr("src", imgGifUrl2);
		},
		function() {
			// jQuery(this).children("img").attr("src", imgGifStaticUrl2);
		}
	);
</script>


<!-- Family pack / HOT CUP IML -->
<?php
$index++;
$prefix = 'fp';
$gif2 = wp_get_attachment_image_src(get_field($prefix . "_gif"), "large");
$gifStatic2 = wp_get_attachment_image_src(get_field($prefix . "_gif_static"), "large");
$badge = wp_get_attachment_image_src(get_field($prefix . "_badge"), "medium");
?>
<section id="hot-cup-iml" class="<?= $prefix; ?> cup-section section">
	<div class="row medium">
		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number"><?= $index; ?></span><?php the_field($prefix . "_name"); ?></h2>
			<p class="short-description">
				<?php the_field($prefix . "_short_desc"); ?>
			</p>
			<a href="#" class="toggle-btn">
				<span class="plus-btn"></span>
				<?php the_field($prefix . "_btn_more_info_text"); ?>
			</a>
			<div class="long-desc-cont">
				<?php the_field($prefix . "_long_desc"); ?>
			</div>
			<ul class="attr-list">

				<?php while (have_rows($prefix . "_attrs")) : the_row(); ?>
					<li><strong><?php the_sub_field("left"); ?></strong> <?php the_sub_field("right"); ?></li>
				<?php endwhile; ?>

			</ul>
			<?php /* <div class="btn-cont">
				<a href="#" class="button toggle-form" id="toggleIML" data-reveal-id="<?= ICL_LANGUAGE_CODE=='cs' ? 'inquiryForm' : 'formST'; ?>"><?php the_field("rs_btn_order_text"); ?></a>
			</div> */ ?>
		</div>
		<div class="image small-12 medium-5 large-5 columns">
			<?php if ($badge) : ?>
				<div class="badge-cont">
					<img src="<?php echo ($badge[0]); ?>" alt="<?php _e("NickNack Hotcup IML Novinka", "nicknack"); ?>" />
				</div>
			<?php endif; ?>
			<div class="img-cont">
				<?php if ($gif2) : ?>
					<img class="rotating" src="<?php echo ($gif2[0]); ?>" alt="<?php _e("Hotcup IML", "nicknack"); ?>" />
				<?php endif; ?>
				<?php if ($gifStatic2) : ?>
					<img class="static" src="<?php echo ($gifStatic2[0]); ?>" alt="<?php _e("Hotcup IML", "nicknack"); ?>" />
				<?php endif; ?>
				<?php if ($gif2 && $gifStatic2) : ?>
					<span class="rorate-icon">
						<img src="<?php echo (get_template_directory_uri()); ?>/images/icon_rotate.png" alt="<?php _e("Ikona rotace", "nicknack"); ?>" />
					</span>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="row medium cup-slider-row">
		<h2><?php the_field($prefix . "_slider_title"); ?></h2>
		<ul class="small-12 columns cup-slider">

			<?php
			$images = get_field($prefix . "_gallery");

			foreach ($images as $image) : ?>

				<li>
					<a class="fancybox" rel="<?= $prefix; ?>" href="<?php echo $image['url']; ?>">
						<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
					</a>
				</li>

			<?php endforeach; ?>

		</ul>
	</div>
</section>

<!-- HotCup -->
<?php
$index++;
$gif = wp_get_attachment_image_src(get_field("hotcup_gif"), "large");
$gifStatic = wp_get_attachment_image_src(get_field("hotcup_gif_static"), "large");
$badge = wp_get_attachment_image_src(get_field("hotcup_badge"), "medium");
?>
<section id="hotcup" class="hc cup-section section" idiml="<?= $form_id__iml; ?>" idsito="<?= $form_id__sito; ?>" idcolor="<?= $form_id__color; ?>" idparty="<?= $form_id__party; ?>">
	<div class="row medium">
		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number"><?= $index; ?></span><?php the_field("hotcup_name"); ?></h2>
			<p class="short-description">
				<?php the_field("hotcup_short_desc"); ?>
			</p>
			<a href="#" class="toggle-btn">
				<span class="plus-btn"></span>
				<?php the_field("hotcup_btn_more_info_text"); ?>
			</a>
			<div class="long-desc-cont">
				<?php the_field("hotcup_long_desc"); ?>
			</div>
			<ul class="attr-list">
				<?php while (have_rows("hotcup_attrs")) : the_row(); ?>

					<li><strong><?php the_sub_field("left"); ?></strong> <?php the_sub_field("right"); ?></li>

				<?php endwhile; ?>
			</ul>
			<div class="btn-cont">
				<?php // Get button info
				$hotcup_page_link = get_field('hotcup_page_link');
				$hotcup_button = get_field('hotcup_btn_order_text');
				if ($hotcup_page_link && $hotcup_button) : ?>
					<a href="<?= $hotcup_page_link; ?>" class="button toggle-form"><?= $hotcup_button; ?></a>
				<?php endif; ?>
				<?php /* <a href="#" class="button toggle-form" data-reveal-id="inquiryForm"><?= $hotcup_button; ?></a> */ ?>
			</div>
		</div>
		<div class="image small-12 medium-5 large-5 columns">
			<div class="badge-cont">
				<?php if (isset($badge[0])) : ?>
					<img src="<?php echo ($badge[0]); ?>" alt="<?php _e("Kelímek HOT CUP novinka", "nicknack"); ?>" />
				<?php endif; ?>
			</div>
			<div class="img-cont">
				<?php if ($gif) : ?>
					<img class="rotating" src="<?php echo ($gif[0]); ?>" alt="<?php _e("Kelímek HOT CUP", "nicknack"); ?>" />
				<?php endif; ?>
				<?php if ($gifStatic) : ?>
					<img class="static" src="<?php echo ($gifStatic[0]); ?>" alt="<?php _e("Kelímek HOT CUP", "nicknack"); ?>" />
				<?php endif; ?>
				<?php if ($gif && $gifStatic) : ?>
					<span class="rorate-icon">
						<img src="<?php echo (get_template_directory_uri()); ?>/images/icon_rotate.png" alt="<?php _e("Ikona rotace", "nicknack"); ?>" />
					</span>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="row medium cup-slider-row">
		<?php if ($hotcup_title = get_field("hotcup_slider_title")) : ?>
			<h2><?= $hotcup_title; ?></h2>
		<?php endif; ?>
		<?php
		if ($images = get_field('hotcup_gallery')) :
		?>
			<ul class="small-12 columns cup-slider">
				<?php
				foreach ($images as $image) :
				?>
					<li>
						<a class="fancybox" rel="iml" href="<?php echo $image['url']; ?>">
							<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
						</a>
					</li>
				<?php
				endforeach;
				?>
			</ul>
		<?php
		endif;
		?>
	</div>
</section>
<script>
	var imgGifUrl = "<?php echo ($gif[0]); ?>";
	var imgGifStaticUrl = "<?php echo ($gifStatic[0]); ?>";

	jQuery(".iml .img-cont").hover(
		function() {
			// jQuery(this).children("img").attr("src", imgGifUrl);
		},
		function() {
			// jQuery(this).children("img").attr("src", imgGifStaticUrl);
		}
	);
</script>

<!-- HotCup Laser -->
<?php
$index++;
$gif = wp_get_attachment_image_src(get_field("hotcup_gif_sitotisk"), "large");
$gifStatic = wp_get_attachment_image_src(get_field("hotcup_gif_static_sitotisk"), "large");
$badge = wp_get_attachment_image_src(get_field("hotcup_badge_sitotisk"), "medium");
?>
<section id="hotcup-laser" class="hc cup-section section" idiml="<?= $form_id__iml; ?>" idsito="<?= $form_id__sito; ?>" idcolor="<?= $form_id__color; ?>" idparty="<?= $form_id__party; ?>">
	<div class="row medium">
		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number"><?= $index; ?></span><?php the_field("hotcup_name_sitotisk"); ?></h2>
			<p class="short-description">
				<?php the_field("hotcup_short_desc_sitotisk"); ?>
			</p>
			<a href="#" class="toggle-btn">
				<span class="plus-btn"></span>
				<?php the_field("hotcup_btn_more_info_text"); ?>
			</a>
			<div class="long-desc-cont">
				<?php the_field("hotcup_long_desc_sitotisk"); ?>
			</div>
			<ul class="attr-list">
				<?php while (have_rows("hotcup_attrs_sitotisk")) : the_row(); ?>

					<li><strong><?php the_sub_field("left"); ?></strong> <?php the_sub_field("right"); ?></li>

				<?php endwhile; ?>
			</ul>
			<div class="btn-cont">
				<?php // Get button info
				$hotcup_page_link = get_field('hotcup_page_link');
				$hotcup_button = get_field('hotcup_btn_order_text');
				if ($hotcup_page_link && $hotcup_button) : ?>
					<a href="<?= $hotcup_page_link; ?>" class="button toggle-form"><?= $hotcup_button; ?></a>
				<?php endif; ?>
				<?php /* <a href="#" class="button toggle-form" data-reveal-id="inquiryForm"><?= $hotcup_button; ?></a> */ ?>
			</div>
		</div>
		<div class="image small-12 medium-5 large-5 columns">
			<div class="badge-cont">
				<?php if (isset($badge[0])) : ?>
					<img src="<?php echo ($badge[0]); ?>" alt="<?php _e("Kelímek HOT CUP novinka", "nicknack"); ?>" />
				<?php endif; ?>
			</div>
			<div class="img-cont">
				<?php if ($gif) : ?>
					<img class="rotating" src="<?php echo ($gif[0]); ?>" alt="<?php _e("Kelímek HOT CUP", "nicknack"); ?>" />
				<?php endif; ?>
				<?php if ($gifStatic) : ?>
					<img class="static" src="<?php echo ($gifStatic[0]); ?>" alt="<?php _e("Kelímek HOT CUP", "nicknack"); ?>" />
				<?php endif; ?>
				<?php if ($gif && $gifStatic) : ?>
					<span class="rorate-icon">
						<img src="<?php echo (get_template_directory_uri()); ?>/images/icon_rotate.png" alt="<?php _e("Ikona rotace", "nicknack"); ?>" />
					</span>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<!-- Colored HOT CUP -->
<?php $index++; ?>
<section id="barevny-hotcup" class="bk cup-section section">
	<div class="row medium">
		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number"><?= $index; ?></span><?php the_field("bhc_name"); ?></h2>
			<p class="short-description">
				<?php the_field("bhc_short_desc"); ?>
			</p>
			<a href="#" class="toggle-btn">
				<span class="plus-btn">

				</span>
				<?php the_field("bhc_btn_more_info_text"); ?>
			</a>
			<div class="long-desc-cont">
				<?php the_field("bhc_long_desc"); ?>
			</div>

			<div class="above-text-cont">
				<span><?php the_field("bhc_upnote"); ?></span>
			</div>

			<ul class="color-var-list">

				<?php
				$i = 0;
				while (have_rows("bhc_variations")) : the_row(); ?>

					<li class="c-<?php echo ($i); ?> color switch-on-hover has-tip tip-top" data-tooltip tabindex="1" title="<?= get_sub_field("title_color") . ' (' . get_sub_field("hex_color") . ')'; ?>" data-id="<?php echo ($i); ?>">
						<span class="color-inner" style="background-color:<?php the_sub_field("hex_color"); ?>;">
						</span>
					</li>

				<?php ++$i;
				endwhile; ?>

			</ul><br />

			<p><em style="font-size: 90%; margin-top: 10px">O aktuálních skladových zásobách barevných kelímků se informujte u obchodního týmu NN</em></p>

			<div class="below-text-cont">
				<span><?php the_field("bhc_vari_subtext"); ?></span>
			</div>
			<ul class="attr-list">

				<?php while (have_rows("bhc_attrs")) : the_row(); ?>

					<li><strong><?php the_sub_field("left"); ?></strong> <?php the_sub_field("right"); ?></li>

				<?php endwhile; ?>

			</ul>
			<!-- <div class="btn-cont">
				<a href="#" class="button toggle-form" id="toggleBK" data-reveal-id="<?= ICL_LANGUAGE_CODE == 'cs' ? 'inquiryForm' : 'formBK'; ?>"><?php the_field("rs_btn_order_text"); ?></a>
				<div id="formBK" class="product-form-modal  reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
					<div class="row medium header">
						<div class="title-cont small-12 columns">
							<h2 class="form-header"><?php _e("OBJEDNEJTE SI NICKNACK", "nicknack"); ?></h2>
						</div>
					</div>
					<div class="row medium">
						<div class="small-12 columns">

							<?php echo (do_shortcode("[gravityform id=" . $form_id__color . " title=false description=false ajax=false]")); ?>

						</div>
					</div>

					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
			</div> -->
		</div>
		<div class="image small-12 medium-5 large-5 columns">

			<div class="img-cont">
				<ul class="img-var-list switch-clicker">

					<?php
					$i = 0;
					while (have_rows("bhc_variations")) : the_row();
						$img = wp_get_attachment_image_src(get_sub_field("pic"), "large");
						$imgL = wp_get_attachment_image_src(get_sub_field("pic"), "full"); ?>

						<li class="img-<?php echo ($i); ?> color switch-on-hover">
							<?php /*<a href="<?php echo($imgL[0]); ?>" class="" onclick="function() { return false; }"> */ ?>
							<img src="<?php echo ($img[0]); ?>" alt="<?php _e("Barevný kelímek"); ?>" class="img">
							<?php /*</a>*/ ?>
						</li>

					<?php ++$i;
					endwhile; ?>

				</ul>

				<?php /*<span class="rorate-icon">
					<img src="<?php echo(get_template_directory_uri()); ?>/images/icon_zoom.png" alt="<?php _e("Ikona zvětšení", "nicknack"); ?>" />
				</span> */ ?>
			</div>
		</div>
	</div>
</section>

<!-- Shot -->
<?php
$index++;
$prefix = 'shot';
$gif2 = wp_get_attachment_image_src(get_field($prefix . "_gif"), "large");
$gifStatic2 = wp_get_attachment_image_src(get_field($prefix . "_gif_static"), "large");
$badge = wp_get_attachment_image_src(get_field($prefix . "_badge"), "medium");
?>
<section id="shot" class="<?= $prefix; ?> cup-section section">
	<div class="row medium">
		<div class="image small-12 medium-5 large-5 columns">
			<div class="badge-cont">

				<?php if ($badge) : ?>
					<div class="badge-cont">
						<img src="<?php echo ($badge[0]); ?>" alt="<?php _e("NickNack Shot Novinka", "nicknack"); ?>" />
					</div>
				<?php endif; ?>
			</div>
			<div class="img-cont">
				<?php if ($gif2) : ?>
					<img class="rotating" src="<?php echo ($gif2[0]); ?>" alt="<?php _e("Panák s klipem na něco ostřejšího", "nicknack"); ?>" />
				<?php endif; ?>
				<?php if ($gifStatic2) : ?>
					<img class="static" src="<?php echo ($gifStatic2[0]); ?>" alt="<?php _e("Panák s klipem na něco ostřejšího", "nicknack"); ?>" />
				<?php endif; ?>
				<?php if ($gif2 && $gifStatic2) : ?>
					<span class="rorate-icon">
						<img src="<?php echo (get_template_directory_uri()); ?>/images/icon_rotate.png" alt="<?php _e("Ikona rotace", "nicknack"); ?>" />
					</span>
				<?php endif; ?>
			</div>
		</div>
		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number"><?= $index; ?></span><?php the_field($prefix . "_name"); ?></h2>
			<p class="short-description">
				<?php the_field($prefix . "_short_desc"); ?>
			</p>
			<a href="#" class="toggle-btn">
				<span class="plus-btn"></span>
				<?php the_field($prefix . "_btn_more_info_text"); ?>
			</a>
			<div class="long-desc-cont">
				<?php the_field($prefix . "_long_desc"); ?>
			</div>
			<ul class="attr-list">

				<?php while (have_rows($prefix . "_attrs")) : the_row(); ?>
					<li><strong><?php the_sub_field("left"); ?></strong> <?php the_sub_field("right"); ?></li>
				<?php endwhile; ?>

			</ul>
			<?php /* <div class="btn-cont">
				<a href="#" class="button toggle-form" id="toggleIML" data-reveal-id="<?= ICL_LANGUAGE_CODE=='cs' ? 'inquiryForm' : 'formST'; ?>"><?php the_field("rs_btn_order_text"); ?></a>
			</div> */ ?>
		</div>
	</div>
	<div class="row medium cup-slider-row">
		<h2><?php the_field($prefix . "_slider_title"); ?></h2>
		<ul class="small-12 columns cup-slider">

			<?php
			$images = get_field($prefix . "_gallery");

			foreach ($images as $image) : ?>

				<li>
					<a class="fancybox" rel="<?= $prefix; ?>" href="<?php echo $image['url']; ?>">
						<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
					</a>
				</li>

			<?php endforeach; ?>

		</ul>
	</div>
</section>
<?php /* <script>
	var imgGifUrl2 = "<?php echo($gif2[0]); ?>";
	var imgGifStaticUrl2 = "<?php echo($gifStatic2[0]); ?>";

	jQuery(".rs .img-cont").hover(
		function() {
			jQuery(this).children("img").attr("src", imgGifUrl2);
		},
		function() {
			jQuery(this).children("img").attr("src", imgGifStaticUrl2);
		}
	);
</script> */ ?>

<!-- Colored cup -->
<?php $index++; ?>
<section id="barevny-kelimek" class="bk cup-section section">
	<div class="row medium">
		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number"><?= $index; ?></span><?php the_field("bk_name"); ?></h2>
			<p class="short-description">
				<?php the_field("bk_short_desc"); ?>
			</p>
			<a href="#" class="toggle-btn">
				<span class="plus-btn">

				</span>
				<?php the_field("bk_btn_more_info_text"); ?>
			</a>
			<div class="long-desc-cont">
				<?php the_field("bk_long_desc"); ?>
			</div>

			<div class="above-text-cont">
				<span><?php the_field("bk_upnote"); ?></span>
			</div>

			<ul class="color-var-list">

				<?php
				$i = 0;
				while (have_rows("bk_variations")) : the_row(); ?>

					<li class="c-<?php echo ($i); ?> color switch-on-hover has-tip tip-top" data-tooltip tabindex="1" title="<?= get_sub_field("title_color") . ' (' . get_sub_field("hex_color") . ')'; ?>" data-id="<?php echo ($i); ?>">
						<span class="color-inner" style="background-color:<?php the_sub_field("hex_color"); ?>;">
						</span>
					</li>

				<?php ++$i;
				endwhile; ?>

			</ul><br />

			<p><em style="font-size: 90%; margin-top: 10px">O aktuálních skladových zásobách barevných kelímků se informujte u obchodního týmu NN</em></p>

			<div class="below-text-cont">
				<span><?php the_field("bk_vari_subtext"); ?></span>
			</div>
			<ul class="attr-list">

				<?php while (have_rows("bk_attrs")) : the_row(); ?>

					<li><strong><?php the_sub_field("left"); ?></strong> <?php the_sub_field("right"); ?></li>

				<?php endwhile; ?>

			</ul>
			<div class="btn-cont">
				<a href="#" class="button toggle-form" id="toggleBK" data-reveal-id="<?= ICL_LANGUAGE_CODE == 'cs' ? 'inquiryForm' : 'formBK'; ?>"><?php the_field("rs_btn_order_text"); ?></a>
				<div id="formBK" class="product-form-modal  reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
					<div class="row medium header">
						<div class="title-cont small-12 columns">
							<h2 class="form-header"><?php _e("OBJEDNEJTE SI NICKNACK", "nicknack"); ?></h2>
						</div>
					</div>
					<div class="row medium">
						<div class="small-12 columns">

							<?php echo (do_shortcode("[gravityform id=" . $form_id__color . " title=false description=false ajax=false]")); ?>

						</div>
					</div>

					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
			</div>
		</div>
		<div class="image small-12 medium-5 large-5 columns">

			<div class="img-cont">
				<ul class="img-var-list switch-clicker">

					<?php
					$i = 0;
					while (have_rows("bk_variations")) : the_row();
						$img = wp_get_attachment_image_src(get_sub_field("pic"), "large");
						$imgL = wp_get_attachment_image_src(get_sub_field("pic"), "full"); ?>

						<li class="img-<?php echo ($i); ?> color switch-on-hover">
							<?php /*<a href="<?php echo($imgL[0]); ?>" class="" onclick="function() { return false; }"> */ ?>
							<img src="<?php echo ($img[0]); ?>" alt="<?php _e("Barevný kelímek"); ?>" class="img">
							<?php /*</a>*/ ?>
						</li>

					<?php ++$i;
					endwhile; ?>

				</ul>

				<?php /*<span class="rorate-icon">
					<img src="<?php echo(get_template_directory_uri()); ?>/images/icon_zoom.png" alt="<?php _e("Ikona zvětšení", "nicknack"); ?>" />
				</span> */ ?>
			</div>
		</div>
	</div>
</section>
<script>
	jQuery(".color-var-list .color").hover(
		function() {
			jQuery(".img-var-list li").css("z-index", 1);

			var targetId = jQuery(this).data("id");
			jQuery(".img-" + targetId).css("z-index", 2);
		},
		function() {}
	);
</script>

<!-- Video section -->
<!-- <?php
$uploads = wp_upload_dir();
$uploads_dir = $uploads['baseurl'];

$poster_url = '';
$video_urls = array(
	$uploads_dir . '/video/Nicknack_2017_CZ_final.mp4',
	''
);

if (ICL_LANGUAGE_CODE == 'pl') {
	$poster_url = get_template_directory_uri() . '/video/video_produkt_caption_pl.jpg';
	$video_urls = array(
		$uploads_dir . '/video/Nicknack_PRODUKT_PL_2019.mp4',
		$uploads_dir . '/video/Nicknack_PRODUKT_PL_2019.webm'
	);
} elseif (ICL_LANGUAGE_CODE == 'en') {
	$video_urls = array(
		$uploads_dir . '/video/Nicknack_EN.mp4',
		''
	);
} ?>

<section class="cont-vid product-vid">
	<video id="promo" preload="auto" width="auto" poster="<?php echo $poster_url; ?>">
		<source src="<?= isset($video_urls[0]) ? $video_urls[0] : ''; ?>" type="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2&quot;">
		<source src="<?= isset($video_urls[1]) ? $video_urls[1] : ''; ?>" type="video/webm; codecs=&quot;vp8, vorbis&quot;">

		<?php _e('Video not supported.', 'nicknack'); ?>

		<script>
			(function($) {

				$('#promo').click(function() {
					if (this.paused) {

					} else {
						if ($(window).width() > 1025) {
							$('html, body').delay(500).animate({
								scrollTop: $("#promo").offset().top - 50
							}, 500);
						}
					}
				});


				/* ------ Video controls ---- */


				$('.cont-vid').hover(
					function() {
						jQuery('video#promo').attr("controls", "controls");
					},
					function() {
						jQuery('video#promo').removeAttr("controls");
					}
				);

				$(document).ready(function() {

					$('video#promo').on('ended', function() {
						$('video#promo').load();
						$('video#promo').removeClass('bg_vid');
						$('#play').show();
						$('.cont-vid').removeClass('widened');
					});

					$('#promo').on('playing', function() {
						$('video#promo').addClass('bg_vid');
						$('#play').hide();
						$('.cont-vid').addClass('widened');


						if ($(window).width() > 1025) {
							$('html, body').delay(500).animate({
								scrollTop: $("#promo").offset().top - 50
							}, 500);
						}

					});
				});
			})(jQuery);
		</script>

	</video>

	<div id="buttonbar">
		<div class="poster">
			<span class="vid-text">
				<?php the_field("bk_play_vid_left"); ?>
				<button id="play" onclick="vidplay();">

					<?php if (ICL_LANGUAGE_CODE == 'pl') : ?>
						<?php echo '<?xml version="1.0" encoding="utf-8"?>
							<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "https://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg version="1.1" id="Layer_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px"
								width="192.326px" height="235.955px" viewBox="246.832 281.011 192.326 235.955"
								enable-background="new 246.832 281.011 192.326 235.955" xml:space="preserve">
							<path fill="#ffffff" d="M246.832,516.966V281.011l192.326,117.978L246.832,516.966z"/>
							</svg>'; ?>
					<?php else : ?>
						<?php echo '<?xml version="1.0" encoding="utf-8"?>
							<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "https://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg version="1.1" id="Layer_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px"
								width="192.326px" height="235.955px" viewBox="246.832 281.011 192.326 235.955"
								enable-background="new 246.832 281.011 192.326 235.955" xml:space="preserve">
							<path fill="#444444" d="M246.832,516.966V281.011l192.326,117.978L246.832,516.966z"/>
							</svg>'; ?>
					<?php endif; ?>

				</button>
				<?php the_field("bk_play_vid_right"); ?>
			</span>
		</div>
	</div>
</section>
</div>
<script>
	/**
	 * Video fns definitions
	 */

	function vidplay() {

		var video = document.getElementById("promo");
		var button = document.getElementById("play");
		video.volume = 0.35;

		video.play();
		jQuery('#buttonbar').addClass('hidden');

	}


	function restart() {
		var video = document.getElementById("promo");
		video.currentTime = 0;
	}

	function skip(value) {
		var video = document.getElementById("promo");
		video.currentTime += value;
	}
</script> -->

<!-- PS -->
<?php
$index++;
$img = wp_get_attachment_image_src(get_field("ps_picture"), "large");
$badge = wp_get_attachment_image_src(get_field("ps_badge"), "large");
?>
<section id="party-sada" class="ps cup-section section">
	<div class="row medium">
		<div class="image small-12 medium-5 large-5 columns">
			<?php if (!empty($badge) && isset($badge[0])) { ?>
				<div class="badge-cont">
					<img src="<?php echo esc_url($badge[0]); ?>" alt="<?php echo esc_attr(__('Novinka', 'nicknack')); ?>" />
				</div>
			<?php } ?>
			<div class="img-cont">
				<img src="<?php echo ($img[0]); ?>" alt="<?php _e("Kelímek s potiskem Rotačním síťotiskem", "nicknack"); ?>" />
			</div>
		</div>

		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number"><?= $index; ?></span><?php the_field("ps_name"); ?></h2>

			<p class="short-description">
				<?php the_field("ps_short_desc"); ?>
			</p>

			<div class="long-desc-cont no-hide">
				<?php the_field("ps_content"); ?>
			</div>

			<div class="btn-cont">
				<a href="#" class="button toggle-form" id="togglePS" data-reveal-id="<?= ICL_LANGUAGE_CODE == 'cs' ? 'inquiryForm' : 'formPS'; ?>"><?php the_field("ps_btn_order_text"); ?></a>
				<div id="formPS" class="product-form-modal  reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">

					<div class="row medium header">
						<div class="title-cont small-12 columns">
							<h2 class="form-header"><?php _e("OBJEDNEJTE SI NICKNACK", "nicknack"); ?></h2>
						</div>
					</div>
					<div class="row medium">
						<div class="small-12 columns">

							<?php echo (do_shortcode("[gravityform id=" . $form_id__party . " title=false description=false ajax=false]")); ?>

						</div>
					</div>
					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
			</div>
		</div>
	</div>
</section>


<?php /* <script>
	var imgGifUrl2 = "<?php echo($gif2[0]); ?>";
	var imgGifStaticUrl2 = "<?php echo($gifStatic2[0]); ?>";

	jQuery(".rs .img-cont").hover(
		function() {
			jQuery(this).children("img").attr("src", imgGifUrl2);
		},
		function() {
			jQuery(this).children("img").attr("src", imgGifStaticUrl2);
		}
	);
</script> */ ?>

<!-- Next NN advantages section -->
<section class="vychytavky-section" id="vychytavky">
	<div class="row heading-row">
		<div class="large-12 columns">
			<h2><?php _e('Discover more NICKNACK tricks', 'nicknack') ?></h2>
		</div>
	</div>
	<div class="row">
		<div class="large-4 medium-4 columns">
			<?php $image1 = get_field('vyhoda_obrazek1'); ?>
			<div class="vychytavka-img">
				<img src="<?= $image1['url']; ?>" alt="<?= $image1['alt']; ?>" />
			</div>
			<h3><?= get_field('vyhoda_text1') ?></h3>
		</div>
		<div class="large-4 medium-4 columns">
			<?php $image2 = get_field('vyhoda_obrazek2'); ?>
			<div class="vychytavka-img">
				<img src="<?= $image2['url']; ?>" alt="<?= $image2['alt']; ?>" />
			</div>
			<h3><?= get_field('vyhoda_text2') ?></h3>
		</div>
		<div class="large-4 medium-4 columns">
			<?php $image3 = get_field('vyhoda_obrazek3'); ?>
			<div class="vychytavka-img">
				<img src="<?= $image3['url']; ?>" alt="<?= $image3['alt']; ?>" />
			</div>
			<h3><?= get_field('vyhoda_text3') ?></h3>
		</div>
	</div>
</section>

<!-- Cup slider section -->
<section class="potisk-section">
	<div class="row">
		<div class="large-12 columns">
			<?php the_field('potisk'); ?>
			<a href="#objednej" class=" button scroll-to-anchor"><?php _e('Order nicknack', 'nicknack') ?></a>
		</div>
	</div>

	<!-- Slick CSS & scripts -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.0/slick.css" />
	<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.0/slick.min.js"></script>
	<script>
		jQuery('.variable-width').slick({
			dots: false,
			arrows: true,
			infinite: true,
			slidesToShow: 5,
			slidesToScroll: 1
		});
		jQuery('.cup-slider').slick({
			dots: false,
			arrows: true,
			infinite: true,
			slidesToShow: 5,
			slidesToScroll: 1,
			responsive: [{
					breakpoint: 800,
					settings: {
						slidesToShow: 4,
					}
				},
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 3,
					}
				},
				{
					breakpoint: 450,
					settings: {
						slidesToShow: 2,
					}
				},
			]
		});

		jQuery(document).ready(function() {
			jQuery(".cup-slider").each(function() {
				jQuery(this).append("<div class=\"overlay-left topper\">&nbsp;</div>");
			});
			jQuery(".cup-slider").each(function() {
				jQuery(this).append("<div class=\"overlay-right topper\">&nbsp;</div>");
			});
		});

		jQuery('.scroll-to-anchor').click(function(e) {
			jQuery('html, body').animate({
				scrollTop: jQuery(jQuery.attr(this, 'href')).offset().top - 40
			}, 500);
			e.preventDefault();
			return false;
		});

		jQuery(function() {
			jQuery('a[href=#vychytavky]').click(function() {
				jQuery('html,body').animate({
					'scrollTop': jQuery(jQuery('#vychytavky')).offset().top - 100
				}, 1000);
			});
		});
	</script>
</section>

<!-- Additional serveices section -->
<section class="psluzby-section">
	<div class="row">
		<div class="large-12 columns">
			<?php the_field('sluzby') ?>
			<a href="<?= get_permalink(icl_object_id(54, 'page')) ?>" class="button" newtext="<?php _e('More about the services', 'nicknack') ?>"><?php _e('More about services', 'nicknack') ?></a>
		</div>
	</div>
</section>

<!-- Quality section -->
<section class="kvalita-section">
	<div class="row">
		<div class="large-12 columns">
			<?= get_field('kvalita') ?>
			<a href="<?= get_permalink(icl_object_id(1913, 'page')) ?>" class="button"><?php _e('Contact us for more info', 'nicknack') ?></a>
		</div>
	</div>
</section>

<script>
	jQuery(".toggle-btn").click(function(e) {
		e.preventDefault();
		jQuery(this).toggleClass("expanded").next().slideToggle();
	});

	jQuery("#field_<?= $form_id__iml; ?>_6 .gfield_label").click(function(e) {
		e.preventDefault();
		jQuery(this).next().find("#input_<?= $form_id__iml; ?>_6").click();
	});
	jQuery("#field_<?= $form_id__sito; ?>_6 .gfield_label").click(function(e) {
		e.preventDefault();
		jQuery(this).next().find("#input_<?= $form_id__sito; ?>_6").click();
	});
	jQuery("#field_<?= $form_id__color; ?>_79 .gfield_label").click(function(e) {
		e.preventDefault();
		jQuery(this).next().find("#input_<?= $form_id__color; ?>_79").click();
	});

	if (location.hash) {
		window.scrollTo(0, 0);
		setTimeout(function() {
			window.scrollTo(0, 0);
			goToSection(location.hash);
		}, 1);
	}

	jQuery('#header .dropdown a').on('click', function(e) {
		let href = jQuery(this).attr('href'),
			hash = href.split('#')[1];

		if (href.indexOf('#') > 0) {
			e.preventDefault();

			if (hash) {
				goToSection('#' + hash);
			}
		}
	});

	function goToSection(el, customOffset) {
		if (jQuery(el).length > 0) {
			let hh = jQuery('#header').outerHeight(), // Header height
				abh = 0; // Height of the admin bar
			if (jQuery('#wpadminbar').length > 0) {
				abh = jQuery('#wpadminbar').outerHeight();
			}
			if (!customOffset) {
				customOffset = 0;
			}
			jQuery('html,body').animate({
				scrollTop: parseInt(jQuery(el).offset().top - hh - abh - customOffset)
			}, 1000, 'swing');
		}
	};


	// BK form scripts
	jQuery("#field_<?= $form_id__color; ?>_13").find("li").each(function() {
		var lItem = jQuery(this);

		var color = lItem.find("label").html();
		console.log(color);

		lItem.find("label").html(" ").append("<span class=\"color\"><span class=\"color-inner\" style=\"background-color:" + color + "\"></span></span>");
	});

	jQuery(".color-section ").each(function() {
		var lItem = jQuery(this);

		var color = lItem.find("h2").html();
		console.log(color);

		lItem.find("h2").html(" ").append("<span class=\"color long\"><span class=\"color-inner\" style=\"background-color:" + color + "\"></span></span>");
	});


	jQuery("#field_<?= $form_id__iml; ?>_6").find(".ginput_container").each(function() {

		var text = jQuery("#input_<?= $form_id__iml; ?>_6").parent().find(".ginput_preview strong").html();

		if (text != undefined) {

		} else {
			text = '<?php _e("Nebyl vybrán žádný soubor"); ?>';
		}

		jQuery(this).append("<span class=\"file-text\">" + text + "</span>");
	});
	jQuery("#field_<?= $form_id__sito; ?>_6").find(".ginput_container").each(function() {

		var text = jQuery("#input_<?= $form_id__sito; ?>_6").parent().find(".ginput_preview strong").html();

		if (text != undefined) {

		} else {
			text = '<?php _e("Nebyl vybrán žádný soubor"); ?>';
		}

		jQuery(this).append("<span class=\"file-text\">" + text + "</span>");
	});
	jQuery("#field_<?= $form_id__color; ?>_79").find(".ginput_container").each(function() {

		var text = jQuery("#input_<?= $form_id__color; ?>_79").parent().find(".ginput_preview strong").html();

		if (text != undefined) {

		} else {
			text = '<?php _e("Nebyl vybrán žádný soubor"); ?>';
		}

		jQuery(this).append("<span class=\"file-text\">" + text + "</span>");
	});

	jQuery("#input_<?= $form_id__iml; ?>_6").change(function() {
		var text = jQuery(this).val();
		text = text.split("/").pop();
		text = text.split("\\").pop();

		if (!text) {
			text = '<?php _e("Nebyl vybrán žádný soubor"); ?>';
		}

		jQuery("#field_<?= $form_id__iml; ?>_6").find(".file-text").html(text);
	});

	jQuery("#input_<?= $form_id__sito; ?>_6").change(function() {
		var text = jQuery(this).val();
		text = text.split("/").pop();
		text = text.split("\\").pop();

		if (!text) {
			text = '<?php _e("Nebyl vybrán žádný soubor"); ?>';
		}

		jQuery("#field_<?= $form_id__sito; ?>_6").find(".file-text").html(text);
	});

	jQuery("#input_<?= $form_id__color; ?>_79").change(function() {
		var text = jQuery(this).val();
		text = text.split("/").pop();
		text = text.split("\\").pop();

		if (!text) {
			text = '<?php _e("Nebyl vybrán žádný soubor"); ?>';
		}

		jQuery("#field_<?= $form_id__color; ?>_79").find(".file-text").html(text);
	});
</script>

<?php get_footer(); ?>