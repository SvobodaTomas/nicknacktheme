<?php
/*
Template Name: Služby
*/
get_header();

?>

<?php
  while ( have_posts() ) : the_post();
  $img = wp_get_attachment_image_src( get_post_thumbnail_id($slide->ID), 'full' );
?>

  <section class="sluzby-header" style="background-image: url('<?=$img[0]?>')">
    <div class="row">
      <div class="large-12 columns">
        <div class="main-content">
            <?php the_content(); ?>
        </div>
      </div>
    </div>
  </section>

  <section class="sluzby-section<?= (ICL_LANGUAGE_CODE=='cs') ? ' sluzby-vypis' : ''; ?>">
    <?php
    $i = 0;
    $args = array(
      'post_type' => 'sluzby-main',
      'posts_per_page' => -1,
      'suppress_filters' => false
    );
    $sluzby = get_posts($args);
    foreach($sluzby as $sluzba) { $i++;
      echo ((($i-1)%3) == 0) ? '<div class="row sluzby-row">' : '';
      echo '<div class="large-4 medium-4 small-12 left columns">
              <div class="sluzby-thumb">'.get_the_post_thumbnail($sluzba->ID).'</div>
              <h2>'.$sluzba->post_title.'</h2>
              <p>'.$sluzba->post_content.'</p>
            </div>';
      echo (($i%3) == 0 || $i == count($sluzby)) ? '</div>' : '';
    }
    ?>

    <div class="row">
      <div class="large-12 columns">
        <a href="<?=get_permalink(icl_object_id(1913, 'page'))?>" class="button"><?php _e('Get in touch with us') ?></a>
      </div>
    </div>
  </section>

  <?php if ( ICL_LANGUAGE_CODE=='cs' ) : ?>

    <?php $slide_reasons_id = icl_object_id(237, 'homepage', false, 'cs'); ?>

    <div class="hsContainer services-reasons">
      <div class="hsContent">
        <h2 class="hsHeading"><?= get_the_title($slide_reasons_id); ?></h2>
        <?php /*if ( $title_color ) : ?>
          <style>#slide-<?=$i?> .hsHeading::before,#slide-<?=$i?> .hsHeading::after{border-color:<?= $title_color; ?>}</style>
        <?php endif;*/ ?>

        <div class="row">

          <?php
            $fakta_text1 = get_field('fakta_text1', $slide_reasons_id);
            if(!empty($fakta_text1)) {
          ?>

            <div class="fakta row">
              <div class="large-3 medium-6 small-12 columns">
                <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo1', $slide_reasons_id).'</span>', get_field('fakta_text1', $slide_reasons_id)) ?>
              </div>
              <div class="large-3 medium-6 small-12 columns">
                <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo2', $slide_reasons_id).'</span>', get_field('fakta_text2', $slide_reasons_id)) ?>
              </div>
              <div class="large-3 medium-6 small-12 columns"> 
                <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo3', $slide_reasons_id).'</span>', get_field('fakta_text3', $slide_reasons_id)) ?>
              </div>
              <div class="large-3 medium-6 small-12 columns">
                <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo4', $slide_reasons_id).'</span>', get_field('fakta_text4', $slide_reasons_id)) ?>
              </div>
            </div>

          <?php }

            // Content of the custom slide (without filter if there is a video fake "shortcode")
            if ( strpos(get_post_field('post_content', $slide_reasons_id),'[video]')!==false ) {
              $post_content = get_post_field('post_content', $slide_reasons_id);
              $post_content = str_replace('[video]',nicknack_video_shortcode(),$post_content);
              echo $post_content;
            } else {
              echo apply_filters( 'the_content', get_post_field('post_content', $slide_reasons_id) );
            }

            $odkaz = get_field('odkaz', $slide_reasons_id);
            $vlastni_odkaz = get_field('vlastni_odkaz', $slide_reasons_id);
            $typ_odkazu = get_field('typ_odkazu', $slide_reasons_id);

            if ( $typ_odkazu && !empty($vlastni_odkaz) ) {
              $odkaz = $vlastni_odkaz;
            }

            if(!empty($odkaz)) {
              echo '<div class="clear columns"><a href="'.$odkaz.'" class="button">'.get_field('text_odkazu', $slide_reasons_id).'</a></div>';
            }
          ?>

        <figure class="wp-block-video" style="position: relative; top: 2em">
        <video controls="" src="https://www.nicknack.cz/wp-content/uploads/2023/12/nicknackcrewcz.mp4" poster="https://www.nicknack.cz/wp-content/uploads/2023/12/nncrewcz-scaled.jpg
"></video>
        
        
        </figure>



        </div>
      </div>
    </div>

    <?= do_shortcode('[partners-services]'); ?>
  <?php endif; ?>
  
  <?php if ( ICL_LANGUAGE_CODE=='en' ) : ?>

    <?php $slide_reasons_id = icl_object_id(627, 'homepage', false, 'en'); ?>

    <div class="hsContainer services-reasons">
      <div class="hsContent">
        <h2 class="hsHeading"><?= get_the_title($slide_reasons_id); ?></h2>
        <?php /*if ( $title_color ) : ?>
          <style>#slide-<?=$i?> .hsHeading::before,#slide-<?=$i?> .hsHeading::after{border-color:<?= $title_color; ?>}</style>
        <?php endif;*/ ?>

        <div class="row">

          <?php
            $fakta_text1 = get_field('fakta_text1', $slide_reasons_id);
            if(!empty($fakta_text1)) {
          ?>

            <div class="fakta row">
              <div class="large-3 medium-6 small-12 columns">
                <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo1', $slide_reasons_id).'</span>', get_field('fakta_text1', $slide_reasons_id)) ?>
              </div>
              <div class="large-3 medium-6 small-12 columns">
                <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo2', $slide_reasons_id).'</span>', get_field('fakta_text2', $slide_reasons_id)) ?>
              </div>
              <div class="large-3 medium-6 small-12 columns"> 
                <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo3', $slide_reasons_id).'</span>', get_field('fakta_text3', $slide_reasons_id)) ?>
              </div>
              <div class="large-3 medium-6 small-12 columns">
                <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo4', $slide_reasons_id).'</span>', get_field('fakta_text4', $slide_reasons_id)) ?>
              </div>
            </div>

          <?php }

            // Content of the custom slide (without filter if there is a video fake "shortcode")
            if ( strpos(get_post_field('post_content', $slide_reasons_id),'[video]')!==false ) {
              $post_content = get_post_field('post_content', $slide_reasons_id);
              $post_content = str_replace('[video]',nicknack_video_shortcode(),$post_content);
              echo $post_content;
            } else {
              echo apply_filters( 'the_content', get_post_field('post_content', $slide_reasons_id) );
            }

            $odkaz = get_field('odkaz', $slide_reasons_id);
            $vlastni_odkaz = get_field('vlastni_odkaz', $slide_reasons_id);
            $typ_odkazu = get_field('typ_odkazu', $slide_reasons_id);

            if ( $typ_odkazu && !empty($vlastni_odkaz) ) {
              $odkaz = $vlastni_odkaz;
            }

            if(!empty($odkaz)) {
              echo '<div class="clear columns"><a href="'.$odkaz.'" class="button">'.get_field('text_odkazu', $slide_reasons_id).'</a></div>';
            }
          ?>
          
          
                  <figure class="wp-block-video" style="position: relative; top: 2em">
        <video controls="" src="https://www.nicknack.cz/wp-content/uploads/2023/12/nicknackcrew.mp4" poster="https://www.nicknack.cz/wp-content/uploads/2023/12/nncrew-2-scaled.jpg"></video>
        </figure>

        </div>
      </div>
    </div>

    <?= do_shortcode('[partners-services]'); ?>
  <?php endif; ?>

  <?php if ( ICL_LANGUAGE_CODE=='nl' ) : ?>

<?php $slide_reasons_id = icl_object_id(627, 'homepage', false, 'nl'); ?>

<div class="hsContainer services-reasons">
  <div class="hsContent">
    <h2 class="hsHeading"><?= get_the_title($slide_reasons_id); ?></h2>
    <?php /*if ( $title_color ) : ?>
      <style>#slide-<?=$i?> .hsHeading::before,#slide-<?=$i?> .hsHeading::after{border-color:<?= $title_color; ?>}</style>
    <?php endif;*/ ?>

    <div class="row">

      <?php
        $fakta_text1 = get_field('fakta_text1', $slide_reasons_id);
        if(!empty($fakta_text1)) {
      ?>

        <div class="fakta row">
          <div class="large-3 medium-6 small-12 columns">
            <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo1', $slide_reasons_id).'</span>', get_field('fakta_text1', $slide_reasons_id)) ?>
          </div>
          <div class="large-3 medium-6 small-12 columns">
            <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo2', $slide_reasons_id).'</span>', get_field('fakta_text2', $slide_reasons_id)) ?>
          </div>
          <div class="large-3 medium-6 small-12 columns"> 
            <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo3', $slide_reasons_id).'</span>', get_field('fakta_text3', $slide_reasons_id)) ?>
          </div>
          <div class="large-3 medium-6 small-12 columns">
            <?= str_replace('<h3>', '<h3><span class="animate-me">'.get_field('fakta_cislo4', $slide_reasons_id).'</span>', get_field('fakta_text4', $slide_reasons_id)) ?>
          </div>
        </div>
        
        

      <?php }

        // Content of the custom slide (without filter if there is a video fake "shortcode")
        if ( strpos(get_post_field('post_content', $slide_reasons_id),'[video]')!==false ) {
          $post_content = get_post_field('post_content', $slide_reasons_id);
          $post_content = str_replace('[video]',nicknack_video_shortcode(),$post_content);
          echo $post_content;
        } else {
          echo apply_filters( 'the_content', get_post_field('post_content', $slide_reasons_id) );
        }

        $odkaz = get_field('odkaz', $slide_reasons_id);
        $vlastni_odkaz = get_field('vlastni_odkaz', $slide_reasons_id);
        $typ_odkazu = get_field('typ_odkazu', $slide_reasons_id);

        if ( $typ_odkazu && !empty($vlastni_odkaz) ) {
          $odkaz = $vlastni_odkaz;
        }

        if(!empty($odkaz)) {
          echo '<div class="clear columns"><a href="'.$odkaz.'" class="button">'.get_field('text_odkazu', $slide_reasons_id).'</a></div>';
        }
      ?>

    </div>
  </div>
</div>

<?= do_shortcode('[partners-services]'); ?>
<?php endif; ?>



<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>