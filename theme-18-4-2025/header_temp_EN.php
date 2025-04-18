<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  
  <?php wp_head(); ?>

  <?php if(is_front_page()) { ?>    
  <link href="<?=get_template_directory_uri()?>/js/zoomslider/zoomslider.css" rel="stylesheet">
  <script src="<?=get_template_directory_uri()?>/js/zoomslider/jquery.zoomslider.min.js"></script> 
  <?php } ?>    
      
  <link href='http://fonts.googleapis.com/css?family=Exo:400,500,600,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/timeline.css"> <!-- Resource style -->
  <script src="<?php echo get_template_directory_uri(); ?>/js/resize-header-on-scroll/js/classie.js"></script>
  
  
  <link rel="shortcut icon" type="image/x-icon" href="<?=get_template_directory_uri()?>/images/favicon.png" />
        
</head>

<body <?php body_class(); ?>>
  
  <?php get_template_part( 'content', 'off_canvas' ); ?>

  <?php if( get_theme_mod( 'wpforge_nav_position' ) == 'top') { ?>
      <?php get_template_part( 'content', 'nav' ); ?>
  <?php } // end if ?>

  <?php if( get_theme_mod( 'wpforge_nav_position' ) == 'fixed') { ?>
      <?php get_template_part( 'content', 'nav' ); ?>
  <?php } // end if ?>


  <div class="header_container">
   
        <header id="header" class="header_wrap" role="banner">
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
            
                <div class="header-info">
                  <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                  <p class="site-description"><?php bloginfo( 'description' ); ?></p>                    
                </div><!-- /.header-info -->
                
              <?php if (ICL_LANGUAGE_CODE == 'cs') {?>

                <div class="header-contact">
                  <p class="header-lang"><?php icl_post_languages() ?></p>
                  <p class="header-email"><?=do_shortcode('[email-obfuscate email="'.get_field('settings-email', 554, false, 'cs').'"]')?></p>
                  <p class="header-phone"><a href="tel:<?=str_replace(" ", "", get_field('settings-telefon2', 554, false, 'cs'))?>"><?=get_field('settings-telefon2', 554, false, 'cs')?></a>
                  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon', 554, false, 'cs'))?>"><?=get_field('settings-telefon', 554, false, 'cs')?></a>
                  
                  </p>                  
                </div>
                
              <?php } elseif (ICL_LANGUAGE_CODE == 'pl')  { ?>

                <div class="header-contact">
                  <p class="header-lang"><?php icl_post_languages() ?></p>
                  <p class="header-email"><?=do_shortcode('[email-obfuscate email="biuro@nicknack.pl"]')?></p>
                  <p class="header-phone"><a href="tel:48501423155">+48 883 858 500</a></p>                    
                </div>

              <?php } else { ?>

                <div class="header-contact">
                  <p class="header-lang"><?php icl_post_languages() ?></p>
                  <p class="header-email"><?=do_shortcode('[email-obfuscate email="sales@clipclapcups.com"]')?></p>
                  <p class="header-phone"><a href="tel:447776591277">+44 7776 591 277</a></p>                  
                </div>

              <?php } ?>

                <?php get_template_part( 'content', 'nav' ); ?>
  
              </div>                    
             </div><!-- .site-header -->
           </div>
        </header><!-- /header --> 
        
        

             
  </div><!-- end .header_container -->
   
  <div class="content_container">
          
      <section class="content_wrap" role="document">
          
            
            
                
                