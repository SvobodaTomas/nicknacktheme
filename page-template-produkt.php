<?php
/*
Template Name: Produkt
*/
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<section class="produkt-section">
  <div class="row heading-row">
    <div class="large-12 columns">
      <?php the_content(); ?>

      <div class="produkt-kelimky">
        <div class="large-4 medium-4 small-12 columns produkt-kelimek-1">
          <div class="large-7 medium-7 small-7 columns">
            <div class="produkt-text">
              <h2><?php _e('Photorealistic IML', 'nicknack') ?></h2>
              <p><?php _e('Photorealistic print around the whole cup? Only with iml technology just from&nbsp;<u>2000</u>&nbsp;pcs.', 'nicknack') ?></p>
            </div>
          </div>
          <div class="large-5 medium-5 small-5 columns">
            <img src="<?=get_template_directory_uri()?>/images/produkt-kelimek-1.png" alt="" />
          </div>
        </div>
        <div class="large-4 medium-4 small-12 columns produkt-kelimek-2">
          <div class="large-5 medium-5 small-5 columns">
            <img src="<?=get_template_directory_uri()?>/images/produkt-kelimek-2.png" alt="" />
          </div>
          <div class="large-7 medium-7 small-7 columns">
            <div class="produkt-text">
              <h2><?php _e('Cup', 'nicknack') ?></h2>
              <p><?php _e('Available in many colours and&nbsp;various transparencies<br /><small>/PANTONE, CMYK, RAL/', 'nicknack') ?></small></p>
            </div>
          </div>
        </div>
        <div class="large-4 medium-4 small-12 columns produkt-kelimek-3">
          <div class="large-5 medium-5 small-5 columns">
            <img src="<?=get_template_directory_uri()?>/images/kelimekk<?php if (ICL_LANGUAGE_CODE == 'en') { echo '_en';} elseif (ICL_LANGUAGE_CODE == 'pl') {echo '_pl';} else { echo '';} ?>.png" alt="" />
          </div>
          <div class="large-7 medium-7 small-7 columns">
            <div class="produkt-text">
              <h2><?php _e('Silk screen printing', 'nicknack') ?></h2>
              <p><?php _e('Now can you imagine your logo or simpler motive on nicknack? Thanks to rotary silk screen printing it can last for years. Just from&nbsp;<u>250</u>&nbsp;pcs.', 'nicknack') ?></p>
            </div>
          </div>
        </div>
      </div>

      <a href="#vychytavky" class="button pink"><?php _e('More about the product', 'nicknack') ?></a>

    </div>
  </div>
</section>

<section class="vychytavky-section" id="vychytavky">   
  <div class="row heading-row">
    <div class="large-12 columns">
      <h2><?php _e('Discover further nicknack tricks', 'nicknack') ?></h2>
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

<section class="potisk-section">
  <div class="row">
    <div class="large-12 columns">
       <?= get_field('potisk') ?>
       <a href="<?=get_permalink(icl_object_id(1913, 'page'))?>" class=" button scroll-to-anchor"><?php _e('Order nicknack', 'nicknack') ?></a>          
    </div>
  </div>
</section>

<section class="psluzby-section">
  <div class="row">
    <div class="large-12 columns">
       <?= get_field('sluzby') ?>
       <a href="<?=get_permalink(icl_object_id(54, 'page'))?>" class="button"><?php _e('More about services', 'nicknack') ?></a>
    </div>
  </div>
</section>

<section class="objednej" id="objednej">
  <div class="row">
    <div class="large-12 columns">
       <?= get_field('objednavka') ?>
    </div>
  </div>
</section>

<section class="kelimky-section">
  <img src="<?php echo get_template_directory_uri(); ?>/images/nicknack_barevny_plastovy_kelimek.jpg" alt="Kelimky" />
  <div class="pink-stripe"><h2><?php _e('You can have your Nicknack in many colors'); ?></h2></div>
</section>

<section class="kvalita-section">
  <div class="row">
    <div class="large-12 columns">
       <?= get_field('kvalita') ?>
       <a href="<?=get_permalink(icl_object_id(1913, 'page'))?>" class="button"><?php _e('Contact us for more info', 'nicknack') ?></a>
    </div>
  </div>
</section>


<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.0/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.0/slick.min.js"></script>
<script>
jQuery('.variable-width').slick({
  dots: false,
  infinite: true,
  slidesToShow: 5,
  slidesToScroll: 1
});

jQuery('.scroll-to-anchor').click(function(e){
    jQuery('html, body').animate({
        scrollTop: jQuery( jQuery.attr(this, 'href') ).offset().top - 40
    }, 500);
    e.preventDefault();
    return false;
});

jQuery(function() {
    jQuery('a[href=#vychytavky]').click(function() {
        jQuery('html,body').animate({'scrollTop' :  jQuery( jQuery('#vychytavky') ).offset().top - 100},1000);
    });
});
</script>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>