

          	</section><!-- end .content-wrap -->
          </div><!-- end .content_container -->

          <div class="footer_container">
          	<footer id="footer" class="footer_wrap row" role="contentinfo">
                <div class="large-3 medium-3 columns">
                    <h2><?php _e('Sitemap') ?></h2>
                    <?php
                    if ( has_nav_menu( 'secondary' ) ) {
                      $nav_menu_location = 'secondary';
                    } else {
                      $nav_menu_location = 'primary';
                    }
                    wp_nav_menu( array(
                        'theme_location' => $nav_menu_location,
                        'container' => false,
                        'depth' => 0,
                        'items_wrap' => '<ul class="left">%3$s</ul>',
                        'fallback_cb' => 'wpforge_menu_fallback', // workaround to show a message to set up a menu
                        'walker' => new wpforge_walker( array(
                            'in_top_bar' => true,
                            'item_type' => 'li',
                            'menu_type' => 'main-menu'
                        ) ),
                    ) );
                    ?>
                </div>

                <?php if ( ICL_LANGUAGE_CODE == 'pl') : ?>

                    <div class="large-3 medium-3 columns">
                        <h2><?php _e('Contact') ?></h2>
                        <p class="address">
                          <?=nl2br(get_field('settings-adresa', 1413, false, 'pl'))?><br />
                          NIP: <?=get_field('settings-ic', 1413, false, 'pl')?><br />
                          NIP EU: <?=get_field('settings-dic', 1413, false, 'pl')?>
                        </p>
                        <p>Nasza strona jest dostępna pod domeną <a href="https://www.nicknack.pl">www.nicknack.pl</a> oraz <a href="https://www.ekokubek.pl">www.ekokubek.pl</a></p>
                    </div>
                    <div class="large-3 medium-3 columns">
                        <ul class="pad">
                          <li>Email: <a href="mailto:nicknack@nicknack.cz"><?=do_shortcode('[email-obfuscate email="'.get_field('settings-email', 1413, false, 'pl').'"]')?></a></li>
                          <li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon', 1413, false, 'pl'))?>"><?=get_field('settings-telefon', 1413, false, 'pl')?></a>
                         <!--  <li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon2', 1413, false, 'pl'))?>"><?=get_field('settings-telefon2', 1413, false, 'pl')?></a>
                          <li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon3', 1413, false, 'pl'))?>"><?=get_field('settings-telefon3', 1413, false, 'pl')?></a> -->
                        </ul>
                    </div>
                    <div class="large-3 medium-3 columns">
                        <h2><?php _e('Nicknack in social media') ?></h2>
                        <div class="socials">
                          <div class="social-fb">
                            <a href="<?=get_field('settings-facebook', 1413, false, 'pl')?>" target="_blank">
                              Facebook
                            </a>
                          </div>
                          <div class="social-tw">
                            <a href="<?=get_field('settings-twitter', 554, false, 'cs')?>" target="_blank">
                              Instagram
                            </a>
                          </div>
                          <div class="social-ytb">
                            <a href="<?=get_field('settings-youtube', 1413, false, 'pl')?>" target="_blank">
                              Youtube
                            </a>
                          </div>
                        </div>
                    </div>

                <?php elseif ( ICL_LANGUAGE_CODE == 'cs') : ?>

                    <div class="adresa large-3 medium-3 columns">
                        <h2><?php _e('Contact') ?></h2>
                        <p class="address"><div style="display: inline-block; padding-bottom: 10px;"><?=nl2br(get_field('settings-adresa', 554, false, 'cs'))?></div><br />
                          IČ: <?=get_field('settings-ic', 554, false, 'cs')?><br />
                          DIČ: <?=get_field('settings-dic', 554, false, 'cs')?>
                        </p>
                        <ul class="pad">
                          <li>Email: <a href="mailto:nicknack@nicknack.cz"><?=do_shortcode('[email-obfuscate email="'.get_field('settings-email', 554, false, 'cs').'"]')?></a></li>
                          <li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon', 554, false, 'cs'))?>"><?=get_field('settings-telefon', 554, false, 'cs')?></a>
                          <?php /*<li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon2', 554, false, 'cs'))?>"><?=get_field('settings-telefon2', 554, false, 'cs')?></a> */ ?>

                          <h3>Sklad</h3><br><a style="display: inline-block; padding-bottom: 10px;" href="https://www.google.cz/maps/dir//Kar%C3%A1sek+1767%2F1,+621+00+Brno-%C5%98e%C4%8Dkovice+a+Mokr%C3%A1+Hora/@49.2512226,16.5896919,17z/data=!4m9!4m8!1m0!1m5!1m1!1s0x471293dfefab0f4b:0x20dd7ce3788da222!2m2!1d16.5922722!2d49.2512191!3e0?entry=ttu" target="_blank" rel="noopener">Karásek 1767/1, Řečkovice,<br>621 00 Brno</a>



                        </ul>
                    </div>
                    <div class="adresa2 large-3 medium-3 columns">
                        <p class="address">
                          <?=nl2br(get_field('settings-adresa2', 554, false, 'cs'))?><br />
                        </p>
                    </div>
                    <div class="large-3 medium-3 columns">
                        <h2><?php _e('Nicknack in social media') ?></h2>
                        <div class="socials">
                          <div class="social-fb">
                            <a href="<?=get_field('settings-facebook', 554, false, 'cs')?>" target="_blank">
                              Facebook
                            </a>
                          </div>
                          <div class="social-tw">
                            <a href="<?=get_field('settings-twitter', 554, false, 'cs')?>" target="_blank">
                              Instagram
                            </a>
                          </div>
                          <div class="social-ytb">
                            <a href="<?=get_field('settings-youtube', 554, false, 'cs')?>" target="_blank">
                              Youtube
                            </a>
                          </div>
                        </div>
                    </div>

                    <?php elseif ( ICL_LANGUAGE_CODE == 'nl') : ?>

                    <div class="adresa large-6 medium-6 columns">
                        <h2><?php _e('Contact') ?></h2>
                        <p class="address">
                          <?=nl2br(get_field('settings-adresa', 11424, false, 'nl'))?><!-- <br />
                          IČ: <?=get_field('settings-ic', 554, false, 'cs')?><br />
                          DIČ: <?=get_field('settings-dic', 554, false, 'cs')?> -->
                        </p>
                        <ul class="pad">
                          <li>Email: <?=do_shortcode('[email-obfuscate email="'.get_field('settings-email', 11424, false, 'nl').'"]')?></a></li>
                          <li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon', 11424, false, 'nl'))?>"><?=get_field('settings-telefon', 11424, false, 'nl')?></a>
                          <?php /*<li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon2', 554, false, 'cs'))?>"><?=get_field('settings-telefon2', 554, false, 'cs')?></a> */ ?>

                        </ul>
                    </div>
                    <!-- <div class="adresa2 large-3 medium-3 columns">
                        <p class="address">
                          <?=nl2br(get_field('settings-adresa2', 11424, false, 'nl'))?><br />
                        </p>
                    </div> -->
                    <div class="large-3 medium-3 columns">
                        <h2><?php _e('Nicknack in social media') ?></h2>
                        <div class="socials">
                          <div class="social-fb">
                            <a href="<?=get_field('settings-facebook', 554, false, 'cs')?>" target="_blank">
                              Facebook
                            </a>
                          </div>
                          <div class="social-tw">
                            <a href="<?=get_field('settings-twitter', 554, false, 'cs')?>" target="_blank">
                              Instagram
                            </a>
                          </div>
                          <div class="social-ytb">
                            <a href="<?=get_field('settings-youtube', 554, false, 'cs')?>" target="_blank">
                              Youtube
                            </a>
                          </div>
                        </div>
                    </div>

                    <?php elseif ( ICL_LANGUAGE_CODE == 'de') : ?>

                    <div class="adresa large-6 medium-6 columns">
                        <h2><?php _e('Contact') ?></h2>
                        <p class="address">
                          <?=nl2br(get_field('settings-adresa', 10988, false, 'de'))?>
                        </p>
                        <ul class="pad">
                          <li>Email: <?=do_shortcode('[email-obfuscate email="'.get_field('settings-email', 10988, false, 'de').'"]')?></a></li>
                          <li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon', 11424, false, 'nl'))?>"><?=get_field('settings-telefon', 10988, false, 'de')?></a>
                          <?php /*<li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon2', 554, false, 'cs'))?>"><?=get_field('settings-telefon2', 554, false, 'cs')?></a> */ ?>

                        </ul>
                    </div>

                    <div class="large-3 medium-3 columns">
                        <h2><?php _e('Nicknack in social media') ?></h2>
                        <div class="socials">
                          <div class="social-fb">
                            <a href="<?=get_field('settings-facebook', 554, false, 'cs')?>" target="_blank">
                              Facebook
                            </a>
                          </div>
                          <div class="social-tw">
                            <a href="<?=get_field('settings-twitter', 554, false, 'cs')?>" target="_blank">
                              Instagram
                            </a>
                          </div>
                          <div class="social-ytb">
                            <a href="<?=get_field('settings-youtube', 554, false, 'cs')?>" target="_blank">
                              Youtube
                            </a>
                          </div>
                        </div>
                    </div>

                <?php else : ?>

                    <div class="adresa large-3 medium-3 columns">
                        <h2><?php _e('Contact') ?></h2>
                        <p class="address">
                          <?=nl2br(get_field('settings-adresa', 600, false, 'cs'))?><br />
                          Company ID no.: <?=get_field('settings-ic', 600, false, 'cs')?><br />
                          Tax ID no.: <?=get_field('settings-dic', 600, false, 'cs')?>
                        </p>
                        <ul class="pad">
                          <li>Email: <a href="mailto:nicknack@nicknack.cz"><?=do_shortcode('[email-obfuscate email="'.get_field('settings-email', 600, false, 'cs').'"]')?></a></li>
                          <li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon', 600, false, 'cs'))?>"><?=get_field('settings-telefon', 600, false, 'cs')?></a>
                          <?php /*<li>Tel.:  <a href="tel:<?=str_replace(" ", "", get_field('settings-telefon2', 554, false, 'cs'))?>"><?=get_field('settings-telefon2', 554, false, 'cs')?></a> */ ?>

                        </ul>
                    </div>
                    <div class="adresa2 large-3 medium-3 columns">
                          <?=''//nl2br(get_field('settings-adresa2', 600))?>
                          <?=get_field('settings-adresa2', 600)?><br />
                    </div>
                    <div class="large-3 medium-3 columns">
                        <h2><?php _e('NICKNACK online') ?></h2>
                        <div class="socials">
                          <div class="social-fb">
                            <a href="<?=get_field('settings-facebook', 600, false, 'cs')?>" target="_blank">
                              Facebook
                            </a>
                          </div>
                          <div class="social-tw">
                            <a href="<?=get_field('settings-twitter', 600, false, 'cs')?>" target="_blank">
                              Instagram
                            </a>
                          </div>
                          <div class="social-ytb">
                            <a href="<?=get_field('settings-youtube', 600, false, 'cs')?>" target="_blank">
                              Youtube
                            </a>
                          </div>
                        </div>
                    </div>

                <?php endif; ?>
          	</footer><!-- .row -->

            <footer id="copyright">
              <div class="row">
                <div class="large-12 columns">
                  <p>&copy; <?=date('Y')?> Nicknack s.r.o. | <a href="https://www.grafique.cz" target="_blank" title="Tvorba webových stránek Brno">Webdesign Brno</a> by GRAFIQUE</p>
                </div>
              </div>
            </footer>

          </div><!-- end #footer_container -->

      <?php if( get_theme_mod( 'wpforge_mobile_display' ) == 'yes') { ?>
      	  <a class="exit-off-canvas"></a>
      	</div><!-- .inner-wrap -->
      </div><!-- #off-canvas-wrap -->
      <?php } // end if ?>

    <div id="backtotop">Top</div><!-- #backtotop -->

    <script>
    if(!Modernizr.svg) {
        jQuery('img[src*="svg"]').attr('src', function() {
            return jQuery(this).attr('src').replace('.svg', '.png');
        });
    }

    function init() {

        window.addEventListener('scroll', function(e){
            var distanceY = window.pageYOffset || document.documentElement.scrollTop,
                shrinkOn =20,
                header = document.querySelector("header");
            if (distanceY > shrinkOn) {
                classie.add(header,"smaller");
            } else {
                if (classie.has(header,"smaller")) {
                    classie.remove(header,"smaller");
                }
            }
        });
    }
    window.onload = init();
    </script>

    <?php if(is_front_page()) { ?>
    <script src="<?=get_template_directory_uri()?>/js/zoomslider/jquery.zoomslider.min.js"></script>
    <?php } ?>

    <script>
      jQuery(document).ready(function() {
          jQuery("body").addClass("loaded");

            var modalOpened = localStorage.getItem("modalOpened");
          console.log(modalOpened);

          if (modalOpened && modalOpened != "0") {
            jQuery('#' + modalOpened).foundation('reveal', 'open');
          }

          jQuery(document).on('opened.fndtn.reveal', '[data-reveal]', function () {
            var modal = jQuery(this);
            modal.attr("id");
            localStorage.setItem("modalOpened", modal.attr("id"));
          });

          jQuery(document).on('closed.fndtn.reveal', '[data-reveal]', function () {
            var modal = jQuery(this);
            localStorage.setItem("modalOpened", "0");
          });

      });
    </script>

    <?php wp_footer(); ?>
    <div id="inquiryFormOverlay"></div>
</body>
</html>