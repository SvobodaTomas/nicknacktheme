<?php
/*
Template Name: Kontakt v2
*/
get_header();

?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php if ( ICL_LANGUAGE_CODE == 'cs' ) : ?>

        <div class="kontakt-section kontakt-v2">
            <div class="row">

                <div class="large-6 medium-12 small-12 left-column columns">
                    <div class="entry-content main-contact">
                        <?php the_content(); ?>
                    </div>

                    <div class="people">
                        <?php // Get people terms
                        $people_terms = get_terms( 
                            'tax-people-', 
                            array(
                                'orderby'    => 'menu_order',
                                'order'      => 'DESC',
                                'hide_empty' => 0,
                            ) 
                        );

                        foreach ($people_terms as $term) { ?>

                            <h2><?php echo $term->name; ?></h2>

                            <?php // get ppls
                            $args = array(
                                'post_type'         => 'cpt-people',
                                'post_status'       => 'published',
                                'posts_per_page'    => -1,
                                'tax_query'         => array(
                                    array(
                                        'taxonomy'      => 'tax-people-',
                                        'field'         => 'slug',
                                        'terms'          => $term->slug,
                                    )
                                )
                            );

                            $ppl = new WP_Query($args);

                            while ($ppl->have_posts()): 
                                $ppl->the_post(); ?>

                                <div class="ppl-box">

                                    <?php if (has_post_thumbnail()) { ?>

                                        <div class="portrait">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </div>

                                    <?php } ?> 

                                    <h3><?php the_title(); ?></h3>
                                    <?php the_content(); ?>

                                </div>


                            <?php endwhile; 
                            wp_reset_query();
                        } ?>

                    </div>

                </div>

                <div class="large-6 medium-12 small-12 right-column columns">

                    <div class="kontakt-form cs">
                        <h2><?php _e('Write to us', 'nicknack') ?></h2>
                        <?= do_shortcode('[gravityform id="1" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
                    </div>

                    <div class="office-box">
                        <div class="entry-content">
                            <?php the_field('page_template_office_address'); ?>
                        </div>
                        <div id="map1" class="gmap"></div>
                    </div>

                    <div class="warehouse-box">
                        <div class="entry-content">
                            <?php the_field('page_template_warehouse'); ?>
                        </div>
                        <div id="map2" class="gmap"></div>
                    </div>

                    <div class="residency-box">
                        <div class="entry-content">
                            <?php the_field('page_template_residency'); ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjCNF1NS9ilPcazmYn_ATLomPmLMy1_h0"></script>
        <script src="<?=get_template_directory_uri()?>/js/markerwithlabel.js" type="text/javascript"></script>
        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', init);

            // Latlangs 
            var myLatlng1;
            var myLatlng2;

            myLatlng1 = new google.maps.LatLng(49.197331, 16.635127);
            myLatlng2 = new google.maps.LatLng(49.251288, 16.591662);

            function init() {

                var mapOptions1 = {     
                    panControl: true,
                    zoomControl: true,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: true,
                    overviewMapControl: false,                    
                    zoom: 16,
                    center: myLatlng1, 
                    styles: [{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"stylers":[{"hue":"#00aaff"},{"saturation":-100},{"gamma":2.15},{"lightness":12}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"lightness":24}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":57}]}]
                };

                var mapOptions2 = {     
                    panControl: true,
                    zoomControl: true,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: true,
                    overviewMapControl: false,                    
                    zoom: 16,
                    center: myLatlng2, 
                    styles: [{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"stylers":[{"hue":"#00aaff"},{"saturation":-100},{"gamma":2.15},{"lightness":12}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"lightness":24}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":57}]}]
                };

                var image = '<?=get_template_directory_uri()?>/images/gm-icon.png';
                var mapElement1 = document.getElementById('map1');
                var mapElement2 = document.getElementById('map2');
                var map1 = new google.maps.Map(mapElement1, mapOptions1);
                var map2 = new google.maps.Map(mapElement2, mapOptions2);

                var marker1 = new google.maps.Marker({
                    position: myLatlng1,
                    map: map1,
                    title: '<strong>Nicknack s.r.o.</strong><br />kanceláře',
                    icon: image
                }); 

                var marker2 = new google.maps.Marker({
                    position: myLatlng2,
                    map: map2,
                    title: '<strong>Nicknack s.r.o.</strong><br />sklad',
                    icon: image
                }); 

                var iw1 = new google.maps.InfoWindow({
                    content: "Kanceláře<br />Brno – Zábrdovice<br /><br /><a href=\"https://www.google.cz/maps/place/Vlhk%C3%A1+170%2F14,+602+00+Brno-Brno-st%C5%99ed/@49.1951872,16.6172768,17z\" target=\"_blank\">otevřít na mapách</a>"
                });

                var iw2 = new google.maps.InfoWindow({
                    content: "Sklad<br />Brno – Zábrdovice<br /><br /><a href=\"https://www.google.cz/maps/place/Vlhk%C3%A1+170%2F14,+602+00+Brno-Brno-st%C5%99ed/@49.1951872,16.6172768,17z\" target=\"_blank\">otevřít na mapách</a>"
                });

                google.maps.event.addListener(marker1, "click", function (e) { iw.open(map1, marker1); });    
                google.maps.event.addListener(marker2, "click", function (e) { iw.open(map2, marker2); });             
            }
        </script>

    <?php elseif ( ICL_LANGUAGE_CODE == 'pl' ) : ?>

        <section class="kontakt-section">
          <div class="row">
            <div class="small-12 medium-6 columns">            
                <?php the_content(); ?>
            </div>
            <div class="small-12 medium-6 columns">
                <h2><?php _e('Write to us', 'nicknack') ?></h2>
                <?= do_shortcode('[gravityform id="4" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
            </div>
          </div>
          <?php /* <div class="row">
            <div class="large-12 columns">  
              <div class="kde">
                <?php //<h2><?php _e('Where to find us', 'nicknack') ?></h2>
                <div id="map"></div> ?>
              </div>

                <div class="kontakt-form pl">
                    <h2><?php _e('Write to us', 'nicknack') ?></h2>
                    <?= do_shortcode('[gravityform id="4" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
                </div>

            </div>    
          </div> */ ?>
        </section>
        <?php elseif ( ICL_LANGUAGE_CODE == 'nl' ) : ?>

            <section class="kontakt-section">
          <div class="row">
            <div class="small-12 medium-6 columns">            
                <?php the_content(); ?>
            </div>
            <div class="small-12 medium-6 columns">
                <h2><?php _e('Write to us', 'nicknack') ?></h2>
                <?= do_shortcode('[gravityform id="26" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
            </div>
          </div>
        </section>

        <?php elseif ( ICL_LANGUAGE_CODE == 'de' ) : ?>

<section class="kontakt-section">
<div class="row">
<div class="small-12 medium-6 columns">            
    <?php the_content(); ?>
</div>
<div class="small-12 medium-6 columns">
    <h2><?php _e('Write to us', 'nicknack') ?></h2>
    <?= do_shortcode('[gravityform id="27" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
</div>
</div>
</section>

    <?php else : ?>

        <section class="kontakt-section">
          <div class="row">
            <div class="small-12 medium-6 columns">            
                <?php the_content(); ?>
            </div>
            <div class="small-12 medium-6 columns">
                <h2><?php _e('Write to us', 'nicknack') ?></h2>
                <?= do_shortcode('[gravityform id="3" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
            </div>
          </div>
          <?php /* <div class="row">
            <div class="large-12 columns">  
              <div class="kde">
                <?php //<h2><?php _e('Where to find us', 'nicknack') ?></h2>
                <div id="map"></div> ?>
              </div>

            <div class="kontakt-form en">
                <h2><?php _e('Write to us', 'nicknack') ?></h2>
                <?= do_shortcode('[gravityform id="3" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
            </div>
                
            </div>    
          </div>  */ ?>
        </section>

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
        <script src="<?=get_template_directory_uri()?>/js/markerwithlabel.js" type="text/javascript"></script>
        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', init);

            function init() {
                var myLatlng = new google.maps.LatLng(49.184625, 16.659815);
                var mapOptions = {     
                    panControl: true,
                    zoomControl: true,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: true,
                    overviewMapControl: false,                    
                    zoom: 16,
                    center: myLatlng, 
                    styles: [{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"stylers":[{"hue":"#00aaff"},{"saturation":-100},{"gamma":2.15},{"lightness":12}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"lightness":24}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":57}]}]
                };

                var image = '<?=get_template_directory_uri()?>/images/gm-icon.png';
                var mapElement = document.getElementById('map');
                var map = new google.maps.Map(mapElement, mapOptions);


                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: '<strong>Nicknack s.r.o.</strong><br />Vlhká 170/14',
                    icon: image
                }); 

                var iw = new google.maps.InfoWindow({
                    content: "Vlhká 170/14<br />Brno – Zábrdovice<br /><br /><a href=\"https://www.google.cz/maps/place/Vlhk%C3%A1+170%2F14,+602+00+Brno-Brno-st%C5%99ed/@49.1951872,16.6172768,17z\" target=\"_blank\">otevřít na mapách</a>"
                });

                google.maps.event.addListener(marker, "click", function (e) { iw.open(map, marker); });             
            }
        </script>

    <?php endif; ?>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>