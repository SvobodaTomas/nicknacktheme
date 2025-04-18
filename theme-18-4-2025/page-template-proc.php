<?php
/*
Template Name: Proč NickNack
*/
get_header();

?>

<?php
  while ( have_posts() ) : the_post();
  $img = wp_get_attachment_image_src( get_post_thumbnail_id($slide->ID), 'full' );
?>

<section class="proc-header" style="background-image: url('<?=$img[0]?>')">
  <div class="row">
    <div class="large-12 columns">
      <div class="main-content">
         <?php the_content(); ?>
      </div>
    </div>
  </div>
</section>

<section class="proc-section">
  <div class="row heading-row">
    <div class="large-12 columns">
      <h2><?php _e("NICKNACK's benefits", 'nicknack') ?></h2>
    </div>
  </div>
  <div class="row proc">

      <?php for($i = 1; $i <= 4; $i++) { ?>

        <div class="large-6 medium-6 columns">
          <div class="number"><?=$i?></div>
          <?= get_field('co-mluvi'.$i) ?>
        </div>

      <?php } ?>

      <div class="small-12" style="clear:both;"><a href="<?=get_permalink(icl_object_id(2198, 'page'))?>" class="button"><?php _e('More about the product', 'nicknack') ?></a></div>

  </div>
</section>

<?php if ( ICL_LANGUAGE_CODE=='cs' ) : ?>

  <?php // HP Slide
  $slide_id = 197;
  $slide = get_post($slide_id);
  // $slide_id = icl_object_id($slide->ID, 'homepage', false, 'cs');
  $img = wp_get_attachment_image_src( get_post_thumbnail_id($slide_id), 'full' ); ?>

  <section class="why-nicknack-reuse">

    <div class=""
      data-center="background-position: 50% 0px;"
      data-top-bottom="background-position: 50% -100px;"
      data-anchor-target="#slide-<?=$i?>"
      style="background-image: url('<?=$img[0]?>');background-size: cover;">

      <div class="hsContainer hsContainerOverlay">
        <div class="hsContent">

          <h2 class="hsHeading"
            data-150-top="opacity: 1"
            data-80-top="opacity: 1"
            data-anchor-target="#slide-<?=$i?> h2">
            <?= $slide->post_title ?>
          </h2>

          <div class="row"
            data-100-top="opacity: 1"
            data--50-top="opacity: 1"
            data-anchor-target="#slide-<?=$i?> .row">

            <?= apply_filters( 'the_content', get_post_field('post_content', $slide->ID) ); ?>

            <div class="reuse-system">
              <div class="large-4 medium-4 small-12 columns">
                <img src="<?= get_field('reuse_img1', $slide->ID) ?>" alt="" />
                <div class="reuse-popis"><?= (ICL_LANGUAGE_CODE=='cs') ? '<span class="reuse-order-number"><span class="number">1</span></span>' : ''; ?><?= get_field('reuse_popis1', $slide->ID) ?></div>
              </div>
              <div class="large-4 medium-4 small-12 columns">
                <img src="<?= get_field('reuse_img2', $slide->ID) ?>" alt="" />
                <div class="reuse-popis"><?= (ICL_LANGUAGE_CODE=='cs') ? '<span class="reuse-order-number"><span class="number">2</span></span>' : ''; ?><?= get_field('reuse_popis2', $slide->ID) ?></div>
              </div>
              <div class="large-4 medium-4 small-12 columns">
                <img src="<?= get_field('reuse_img3', $slide->ID) ?>" alt="" />
                <div class="reuse-popis"><?= (ICL_LANGUAGE_CODE=='cs') ? '<span class="reuse-order-number"><span class="number">3</span></span>' : ''; ?><?= get_field('reuse_popis3', $slide->ID) ?></div>
              </div>
            </div>
            <div class="clear"></div>

            <?php
              $odkaz = get_field('odkaz', $slide->ID);

              if(!empty($odkaz)) {
                echo '<div class="clear"><a href="'.$odkaz.'" class="button" style="visibility:hidden;">'.get_field('text_odkazu', $slide->ID).'</a></div>';
              }
            ?>

          </div>
        </div>
      </div>
    </div>
  </section>

<?php else : ?>

<section class="why-nicknack-reuse">

    <div class=""
      data-center="background-position: 50% 0px;"
      data-top-bottom="background-position: 50% -100px;"
      data-anchor-target="#slide-<?=$i?>"
      style="background-image: url('https://www.nicknack.cz/wp-content/uploads/2020/12/reuse-system-bg-2.jpg');background-size: cover;">

      <div class="hsContainer hsContainerOverlay">
        <div class="hsContent">

              <div class="row heading-row">
        <h2 class="hsHeading"><?php _e('How the deposit works', 'nicknack') ?></h2>
    </div>


          <div class="row"
            data-100-top="opacity: 1"
            data--50-top="opacity: 1"
            data-anchor-target="#slide-<?=$i?> .row">

            <div class="reuse-system">
              <div class="large-4 medium-4 small-12 columns">
                <img src="<?= get_field('reuse_img1', icl_object_id(197, 'homepage')) ?>" alt="" />
				<div class="reuse-popis"><span class="reuse-order-number"><span class="number">1</span></span><?= get_field('reuse_popis1', icl_object_id(197, 'homepage')) ?></div>
              </div>
              <div class="large-4 medium-4 small-12 columns">
                <img src="<?= get_field('reuse_img2', icl_object_id(197, 'homepage')) ?>" alt="" />
				<div class="reuse-popis"><span class="reuse-order-number"><span class="number">2</span></span><?= get_field('reuse_popis3', icl_object_id(197, 'homepage')) ?></div>
              </div>
              <div class="large-4 medium-4 small-12 columns">
                <img src="<?= get_field('reuse_img3', icl_object_id(197, 'homepage')) ?>" alt="" />
				<div class="reuse-popis"><span class="reuse-order-number"><span class="number">3</span></span><?= get_field('reuse_popis3', icl_object_id(197, 'homepage')) ?></div>
              </div>
            </div>
            <div class="clear"></div>

         </div>
        </div>
      </div>
    </div>
  </section>


<!--
  <section class="reuse-section">
    <div class="row heading-row">
      <div class="large-12 columns">
        <h2><?php _e('How the deposit works', 'nicknack') ?></h2>
      </div>
    </div>
    <div class="row">
      <div class="large-4 medium-4 small-12 columns">
        <img src="<?= get_field('reuse_img1', icl_object_id(197, 'homepage')) ?>" alt="" />
        <div class="reuse-popis"><?= get_field('reuse_popis1', icl_object_id(197, 'homepage')) ?></div>
      </div>
      <div class="large-4 medium-4 small-12 columns">
        <img src="<?= get_field('reuse_img2', icl_object_id(197, 'homepage')) ?>" alt="" />
        <div class="reuse-popis"><?= get_field('reuse_popis2', icl_object_id(197, 'homepage')) ?></div>
      </div>
      <div class="large-4 medium-4 small-12 columns">
        <img src="<?= get_field('reuse_img3', icl_object_id(197, 'homepage')) ?>" alt="" />
        <div class="reuse-popis"><?= get_field('reuse_popis3', icl_object_id(197, 'homepage')) ?></div>
      </div>
    </div>
  </section>
-->

<?php endif; ?>

<?php
      $uploads = wp_upload_dir();
      $uploads_dir = $uploads['baseurl'];

      if (ICL_LANGUAGE_CODE == 'pl') {
        $poster_url = get_template_directory_uri() . '/video/video_caption_pl.jpg';
        $video_urls = array(
          $uploads_dir . '/video/Nicknack_HP_PL_2019.mp4',
          $uploads_dir . '/video/Nicknack_HP_PL_2019.webm'
        );
      } else {
        $poster_url = get_template_directory_uri() . '/video/video_caption_new.jpg';
        $video_urls = array(
          $uploads_dir . '/video/Nicknack_video.mp4',
          $uploads_dir . '/video/Nicknack.webm'
        );
      } ?>
     <section class="cont-vid" >
        <video id="promo" preload="auto"  width="auto" poster="<?php echo $poster_url; ?>">
          <source src="<?php echo $video_urls[0]; ?>" type="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2&quot;">
          <source src="<?php echo $video_urls[1]; ?>" type="video/webm; codecs=&quot;vp8, vorbis&quot;">

    <?php _e('Video not supported.', 'nicknack'); ?>

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

        /* ------ Video controls ---- */

         $('.cont-vid').hover(
          function () {
            jQuery('video#promo').attr("controls", "controls");
          },
          function () {
            jQuery('video#promo').removeAttr("controls");
          }
        );

        $(document).ready(function(){
          $('video#promo').on('ended',function(){
            $('video#promo').load();
            $('video#promo').removeClass('bg_vid');
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
        });
      })(jQuery);
    </script>

  </video>
  <div id="buttonbar">
        <button id="play" onclick="vidplay();">
          <svg version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
          <path d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M45.563,30.826l-22,15
            C23.394,45.941,23.197,46,23,46c-0.16,0-0.321-0.038-0.467-0.116C22.205,45.711,22,45.371,22,45V15c0-0.371,0.205-0.711,0.533-0.884
            c0.328-0.174,0.724-0.15,1.031,0.058l22,15C45.836,29.36,46,29.669,46,30S45.836,30.64,45.563,30.826z"/>
          </svg>

        </button>
    </div>
  </section>
</div>


<section class="proc-sluzby-section">
  <div class="row">
    <div class="large-12 columns">
       <?= get_field('proc-sluzby') ?>
       <a href="<?=get_permalink(icl_object_id(54, 'page'))?>" class="button"><?php _e('More about services', 'nicknack') ?></a>
    </div>
  </div>
</section>

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

</script>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>