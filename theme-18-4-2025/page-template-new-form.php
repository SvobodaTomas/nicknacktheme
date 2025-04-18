<?php
/**
 * Template Name: Nový formulář
 */
get_header(); ?>


<!-- Main content section -->
<?php while (have_posts()) { 
    the_post(); ?>

<?php } ?>

<!-- IML -->
<?php 
$gif = wp_get_attachment_image_src(get_field("iml_gif",2198), "large");
$gifStatic = wp_get_attachment_image_src(get_field("iml_gif_static",2198), "large");
$badge = wp_get_attachment_image_src(get_field("iml_badge",2198), "medium"); ?>

<div class="iml cup-section section">
	<div class="row medium">
		<div class="image small-12 medium-5 large-5 columns">
			<div class="badge-cont">
				<img src="<?php echo($badge[0]); ?>" alt="<?php _e("Foto realistický potisk", "nicknack"); ?>" />	
			</div>
			<div class="img-cont">
				<img class="rotating" src="<?php echo($gif[0]); ?>" alt="<?php _e("Kelímek s potiskem IML", "nicknack"); ?>" />
				<img class="static" src="<?php echo($gifStatic[0]); ?>" alt="<?php _e("Kelímek s potiskem IML", "nicknack"); ?>" />
				<span class="rorate-icon">
					<img src="<?php echo(get_template_directory_uri()); ?>/images/icon_rotate.png" alt="<?php _e("Ikona rotace", "nicknack"); ?>" />
				</span>
			</div>
		</div>
		<div class="content small-12 medium-7 large-7 columns">
			<h2><span class="number">1</span><?php the_field("iml_name",2198); ?></h2>
			<p class="short-description">
				<?php the_field("img_short_desc",2198); ?>
			</p>
			<a href="#" class="toggle-btn">
				<span class="plus-btn">

				</span>
				<?php the_field("iml_btn_more_info_text",2198); ?>
			</a>
			<div class="long-desc-cont">
				<?php the_field("img_long_desc",2198); ?>
			</div>
			<ul class="attr-list">
				
				<?php while(have_rows("iml_attrs",2198)) { 
					the_row(); ?>

					<li><strong><?php the_sub_field("left",2198); ?></strong> <?php the_sub_field("right",2198); ?></li>

				<?php } ?>

			</ul>
			<div class="btn-cont">
				<a href="#" class="button toggle-form" data-reveal-id="inquiryForm"><?php the_field("iml_btn_order_text",2198); ?></a>
			</div>
		</div>
	</div>
</div>
<script>
	var imgGifUrl = "<?php echo($gif[0]); ?>";
	var imgGifStaticUrl = "<?php echo($gifStatic[0]); ?>";

	jQuery(".iml .img-cont").hover(
		function() {
			// jQuery(this).children("img").attr("src", imgGifUrl);
		},
		function() {
			// jQuery(this).children("img").attr("src", imgGifStaticUrl);
		}
	);
</script>

<script>
	jQuery(".toggle-btn").click(function(e) {
		e.preventDefault();
		jQuery(this).toggleClass("expanded").next().slideToggle();
	});
</script>

<?php get_footer(); ?>