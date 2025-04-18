<?php

/**
 * The template that supplies Off-Canvas support to WP-Forge
 *
 * @package WordPress
 * @subpackage WP_Forge
 * @since WP-Forge 5.5.0.1
 */
?>

<?php if (get_theme_mod('wpforge_mobile_display') == 'yes') { ?>

  <div class="off-canvas-wrap" data-offcanvas>

    <div class="inner-wrap">

      <nav class="tab-bar">

        <?php if (get_theme_mod('wpforge_mobile_position') == 'right') { ?>
          <section class="right-small">
            <a class="right-off-canvas-toggle menu-icon" href="#"><span></span></a>
          </section>
        <?php } else { ?>
          <section class="left-small">
            <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
          </section>
        <?php } // end if 
        ?>

        <?php if (get_theme_mod('wpforge_mobile_position') == 'right') { ?>

          <section class="middle tab-bar-section go-right">

            <div class="title">

              <img src="<?= get_template_directory_uri() ?>/images/nicknack_logo.svg" alt="" />

            </div>

          </section>

        <?php } else { ?>

          <section class="middle tab-bar-section go-left">

            <div class="title">

              <img src="<?= get_template_directory_uri() ?>/images/nicknack_logo.svg" alt="" />

            </div>
            <div class="language-dropdown header-language">

              <button class="button"><?php $my_current_lang = apply_filters('wpml_current_language', null);
                                      echo $my_current_lang; ?></button>
              <div class="dropdown-content">
                <?php icl_post_languages() ?>
                <a href="https://nicknack.no">NO</a>
                <a href="https://zakup.ro/">RO</a>
              </div>
            </div>

          </section>

        <?php } // end if 
        ?>

      </nav>

      <?php if (get_theme_mod('wpforge_mobile_position') == 'right') { ?>

        <aside class="right-off-canvas-menu">
          <?php
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'depth' => 0,
            'items_wrap' => '<ul class="off-canvas-list">%3$s</ul>',
            'fallback_cb' => 'wpforge_menu_fallback', // workaround to show a message to set up a menu
            'walker' => new wpforge_walker(array(
              'in_top_bar' => true,
              'item_type' => 'li',
              'menu_type' => 'main-menu'
            )),
          ));
          ?>

        </aside>

      <?php } else { ?>

        <aside class="left-off-canvas-menu">
          <?php
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'depth' => 0,
            'items_wrap' => '<ul class="off-canvas-list">%3$s</ul>',
            'fallback_cb' => 'wpforge_menu_fallback', // workaround to show a message to set up a menu
            'walker' => new wpforge_walker(array(
              'in_top_bar' => true,
              'item_type' => 'li',
              'menu_type' => 'main-menu'
            )),
          ));
          ?>

        </aside>

      <?php } // end if 
      ?>

    <?php } // end if 
    ?>

    <script>
      jQuery(document).ready(function($) {
        // Close off-canvas menu when item is clicked
        jQuery('.dropdown').click(function() {
          jQuery('.off-canvas-wrap').removeClass('move-right');
          console.log('REMOVED!!!!!!!!!');
        });
      });
    </script>