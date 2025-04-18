<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  
  <?php wp_head(); ?>

  <?php if(is_front_page()) { ?>    
  <link href="<?=get_template_directory_uri()?>/js/zoomslider/zoomslider.css" rel="stylesheet">
  <script src="<?=get_template_directory_uri()?>/js/zoomslider/jquery.zoomslider.min.js"></script> 
  <?php } ?>    
      
  <link href='https://fonts.googleapis.com/css?family=Exo:400,500,600,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/timeline.css?v=<?= filemtime(get_stylesheet_directory() . '/css/timeline.css'); ?>"> <!-- Resource style -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/resize-header-on-scroll/js/classie.js"></script>
  
  <link rel="shortcut icon" type="image/x-icon" href="<?=get_template_directory_uri()?>/images/favicon.png" />
        
</head>

<body <?php body_class(); ?> id="lang-<?php echo ICL_LANGUAGE_CODE; ?>">
	
<!--
	<div class="section" id="notice">
	   <div class="row"><strong>2. 7. - 6. 8. 2018</strong> <?php _e('is the entire Nicknack team working at festivals. This is why we apologize for limited communication. We will be back in August 7, 2018. Thank you.', 'nicknack') ?></div>	      
	   </div>
-->
	

  
  <?php get_template_part( 'content', 'off_canvas' ); ?>

  <?php if( get_theme_mod( 'wpforge_nav_position' ) == 'top') { ?>
      <?php get_template_part( 'content', 'nav' ); ?>
  <?php } // end if ?>

  <?php if( get_theme_mod( 'wpforge_nav_position' ) == 'fixed') { ?>
      <?php get_template_part( 'content', 'nav' ); ?>
  <?php } // end if ?>

  <div class="header_container">
   
        <header id="header" class="header_wrap show-for-large-up" role="banner">

       
          <div class="row"> 
            <div class="site-header medium-12 large-12 columns">
              <div class="container clearfix">
                <div class="header-logo">
                  <div id="logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                      <img src="<?= get_template_directory_uri() ?>/images/nicknack_logo.svg" class="header-image" alt="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>" />
                    </a>
                  </div>
                </div><!-- /.header-logo -->
            
                <div class="header-info hide">
                  <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                  <p class="site-description"><?php bloginfo( 'description' ); ?></p>
                </div><!-- /.header-info -->

                <div class="header-contact">
                  <p class="header-lang">
                    <?php icl_post_languages() ?>
                    <a href="https://nicknack.no">Scandinavian</a>
                  </p>
                
                  <?php if (ICL_LANGUAGE_CODE == 'cs') : ?>

                      <p class="header-email"><?=do_shortcode('[email-obfuscate email="'.get_field('settings-email', 554, false, 'cs').'"]')?></p>
                      <p class="header-phone form-opener">
                      <?php /* <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon2', 554, false, 'cs'))?>"><?=get_field('settings-telefon2', 554, false, 'cs')?></a>
                        <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon', 554, false, 'cs'))?>"><?=get_field('settings-telefon', 554, false, 'cs')?></a> */ ?>
                        <a href="#" class="toggle-form" data-reveal-id="inquiryForm"><?= __('Nezávazně spočítat','nicknack'); ?> <svg class="cup-icon" data-name="Vrstva 1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 18.68 25.86"><defs><style>.cls-1{fill:#e2007a;}</style></defs><path class="cls-1" d="M18.33.41A1.33,1.33,0,0,0,17.38,0H0L2.93,25.86H13.5L16.31,1h1.07a.29.29,0,0,1,.22.1.28.28,0,0,1,.08.22l-.63,11.15,1,.06.63-11.15A1.32,1.32,0,0,0,18.33.41ZM12.61,24.86H3.82L1.12,1H15.31Z"/></svg></a>
                      </p>
                    
                  <?php elseif (ICL_LANGUAGE_CODE == 'pl') : ?>

                      <p class="header-email"><?=do_shortcode('[email-obfuscate email="biuro@nicknack.pl"]')?></p>
                      <p class="header-phone"><a href="tel:+48883858500">+48 883 858 500</a></p>

                  <?php else : ?>

                      <p class="header-email"><?=do_shortcode('[email-obfuscate email="nicknack@nicknack.cz"]')?></p>
                      <p class="header-phone"><a href="tel:447776591277">+420 732 531 075</a></p>

                  <?php endif; ?>
                </div>

                <?php get_template_part( 'content', 'nav' ); ?>
  
              </div>
             </div><!-- .site-header -->
           </div>
        </header><!-- /header --> 
        
  </div><!-- end .header_container -->
   
  <div class="content_container">
	
      <?php if (ICL_LANGUAGE_CODE == 'cs') : ?>

        <div id="inquiryForm" class="product-form-modal reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
          <div class="row medium header">
            <div class="title-cont small-12 columns">
              <h2 class="form-header"><?php _e("POPTÁVKOVÝ FORMULÁŘ", "nicknack"); ?></h2>
            </div>
          </div>
          <div class="row medium">
            <div class="small-12 columns">
              
              <?php echo(do_shortcode("[gravityform id=".F1." title=false description=false ajax=true tabindex=1]")); ?>
              
              <?php echo(do_shortcode("[gravityform id=".F2." title=false description=false ajax=false tabindex=2]")); ?>

            </div>
          </div>
          <a class="close-reveal-modal close-product-reveal-modal" aria-label="Close" title="Close"></a>
        </div>

      <?php endif; ?>

      <section class="content_wrap" role="document">
          
            
            
                
                