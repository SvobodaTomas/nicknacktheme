<section class="homeSlide homeSlide--video cont-vid">
	<div class="bcg">
		<div class="hsContainer">

			<div class="hsContent">

				<h2 class="hsHeading"><?php the_title(); ?></h2>

				<?php
					$uploads = wp_upload_dir();
					$uploads_dir = $uploads['baseurl'];

					// $poster_url = get_template_directory_uri() . '/video/video_caption_2020.png';
					$poster_url = '';
					if ( $poster_img = get_field( 'homepage_video_poster' ) ) {
						$poster_url = $poster_img['sizes']['large'];
					}
					$video_urls = array(
						$uploads_dir . '/video/'.get_field('homepage_video_filename').'.mp4',
						$uploads_dir . '/video/'.get_field('homepage_video_filename').'.webm'
					);
				?>
				<div style="position:relative;">
					<video id="promo" preload="auto" width="auto" poster="<?php echo $poster_url; ?>">
						<source src="<?php echo $video_urls[0]; ?>" type="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2&quot;">
						<source src="<?php echo $video_urls[1]; ?>" type="video/webm; codecs=&quot;vp8, vorbis&quot;">
						<?php _e('Video not supported.', 'nicknack'); ?>
					</video>
					<div id="buttonbar" class="buttonbar-new">
						<button id="play" class="play-new" onclick="vidplay();">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 162 162"><defs><style>.cls-1{fill:#fff;}</style></defs><path class="cls-1" d="M142.82,234.25a81,81,0,1,1,81-81A81,81,0,0,1,142.82,234.25Zm0-141.75a60.75,60.75,0,1,0,60.74,60.75A60.75,60.75,0,0,0,142.82,92.5Zm-20.26,30.37,50.63,30.38-50.63,30.37Z" transform="translate(-61.82 -72.25)"/></svg>
						</button>
					</div>
				</div>
			</div>

		</div>
	</div>
	<script>
		(function($) {

			$('#promo').click(function() {
				if (this.paused) {

				} else {
					if ( $(window).width() > 1025 ) {
						$('html, body').delay(500).animate({
							scrollTop: $("#promo").offset().top - 50
						}, 500);
					}
				}
			});

			// ------ Video controls ----

			$('.cont-vid').hover(
				function () {
					jQuery('video#promo').attr("controls", "controls");
				},
				function () {
					jQuery('video#promo').removeAttr("controls");
				}
			);

			$(window).on('load resize',function(){
				$('.cont-vid').closest('.row').css({'max-width':'initial!important'});
				$('.cont-vid').closest('.hsContent').css({'padding-left':'0','padding-right':'0','padding-bottom':'0'});
				var hh = $('#header').outerHeight(),
					vh = $(window).height();
				if(vh<600+hh) {
					$('#promo').css({'max-height':'calc(100vh - '+hh+'px)','object-fit':'cover'});
				} else {
					$('#promo').css({'max-height':'600px','object-fit':'cover'});
				}
				$('#promo').on('ended',function(){
					$('#promo').load();
					$('#promo').removeClass('bg_vid');
					$('#play').show();
					$('.cont-vid').removeClass('widened');
				});
				$('#promo').on('playing', function() {
					$('video#promo').addClass('bg_vid');
					$('#play').hide();
					$('.cont-vid').addClass('widened');

					if ( $(window).width() > 1025 ) {
						$('html, body').delay(500).animate({
							scrollTop: $("#promo").offset().top - 50
						}, 500);
					}
				});
				$('#promo').on('pause', function() {
					$('#play').show();
					jQuery('#buttonbar').removeClass('hidden');
				});
			});
		})(jQuery);
		// Video fns definitions
		function vidplay() {
			var video = document.getElementById("promo");
				hh = document.getElementById("header").offsetHeight,
				button = document.getElementById("play");
			video.volume = 0.35;
			video.style.objectFit = 'contain';
			document.getElementById('promo').style.maxHeight = 'calc(100vh - '+hh+'px)';

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
	</script>
</section>