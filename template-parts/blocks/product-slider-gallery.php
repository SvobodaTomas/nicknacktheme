<div class="row medium custom-cup-slider-row">
	<h2 class="custom-cup-slider-row__title"><?php the_field("title"); ?></h2>
	<ul class="small-12 columns cup-slider">

		<?php $images = get_field('gallery'); 

		foreach( $images as $image ) : ?>

			<li>
				<a class="fancybox" rel="iml" href="<?php echo $image['url']; ?>">
					<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
				</a>
			</li>

		<?php endforeach; ?>

	</ul>
</div>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.0/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.0/slick.min.js"></script>
<script>
	jQuery('.cup-slider').slick({
		dots: false,
		arrows: true,
		infinite: true,
		slidesToShow: 5,
		slidesToScroll: 1,
		responsive: [
			{
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
</script>