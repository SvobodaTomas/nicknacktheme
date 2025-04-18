<?php
/*
Template Name: Kontakt v3
*/
get_header();

?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php if ( ICL_LANGUAGE_CODE == 'cs' || ICL_LANGUAGE_CODE == 'en' || ICL_LANGUAGE_CODE == 'nl' ) : ?>

        <div class="kontakt-section kontakt-v3">
            <div class="row">

                <div class="small-12 quick-contact">
                    <h2 class="element--lined text-center"><span class="element--lined__inner"><?= __('Potřebujete zjistit cenu?','nicknack'); ?></span></h2>
                    <div class="row text-center" style="padding-bottom:20px;">
                        <p><?= sprintf( __('Získejte nabídku přímo na Váš email pomocí %skonfigurátoru%s.','nicknack'), '<a href="#" data-reveal-id="inquiryForm">', '</a>'); ?></p>
                        <div><a href="#" class="toggle-form button-form-opener" data-reveal-id="inquiryForm"><?= __('Nezávazně spočítat','nicknack'); ?> <svg class="cup-icon" data-name="Vrstva 1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 18.68 25.86"><defs><style>.cls-1{fill:#e2007a;}</style></defs><path class="cls-1" d="M18.33.41A1.33,1.33,0,0,0,17.38,0H0L2.93,25.86H13.5L16.31,1h1.07a.29.29,0,0,1,.22.1.28.28,0,0,1,.08.22l-.63,11.15,1,.06.63-11.15A1.32,1.32,0,0,0,18.33.41ZM12.61,24.86H3.82L1.12,1H15.31Z"/></svg></a></div>
                    </div>
                </div>

                <div class="small-12 quick-contact" style="margin-top: 70px;margin-bottom: 50px;">
                    <?php if ( $quick_contact = get_field('pate_template_quick_contact_heading') ) : ?>
                        <h2 class="element--lined text-center"><span class="element--lined__inner"><?= $quick_contact; ?></span></h2>
                    <?php endif; ?>
                    <div class="row quick-contact__content">
                        <div class="small-12 medium-6 columns text-center"><?php the_field('pate_template_quick_contact_left'); ?></div>
                        <div class="small-12 medium-6 columns text-center"><?php the_field('pate_template_quick_contact_right'); ?></div>
                    </div>
                </div>

                <div class="small-12">
                    <div class="row">
                        <?php // Get people terms
                        $people_terms = get_terms(
                            'tax-people-',
                            array(
                                'orderby'    => 'menu_order',
                                'order'      => 'DESC',
                                'hide_empty' => 0,
                            )
                        );

                        foreach ($people_terms as $term) : ?>

                            <div class="row people-row" data-equalizer>

                                <h2 class="small-12 element--lined text-center"><span class="element--lined__inner"><?php echo $term->name; ?></span></h2>

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
                                $i = 0;

                                if ( $ppl->post_count % 4 == 0 ) :
                                    $classes = 'medium-3 ';
                                else :
                                    $classes = "flex-medium-4 ";
                                    echo '<div class="flex-wrapper">';
                                endif;

                                while ($ppl->have_posts()) : $ppl->the_post(); $i++; ?>

                                    <div class="ppl-box columns small-12 text-center <?= $classes; $i==$ppl->post_count ? ' end' : ''; ?>" data-equalizer-watch>

                                        <?php if (has_post_thumbnail()) : ?>

                                            <div class="portrait">
                                                <?php the_post_thumbnail('medium'); ?>
                                            </div>

                                        <?php endif; ?>

                                        <h3 class="ppl-box__name"><?php the_title(); ?></h3>
                                        <?php the_content(); ?>

                                    </div>

                                <?php endwhile;
                                wp_reset_query();
                                if ( $ppl->post_count % 4 > 0 ) :
                                    echo '</div>';
                                endif; ?>

                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

            </div>

            <?php if ( $image_id = get_field('page_template_team_photo') ) : ?>
                <!-- team photo photo -->
                <img src="<?= wp_get_attachment_image_src($image_id, 'large')[0]; ?>" alt="Společná fotka týmu NickNack" style="width:100%;height:auto;">
            <?php endif; ?>

            <div class="background--gray">

                <div class="kontakt-form cs">
                    <h2 class="text-center"><?php _e('Write to us', 'nicknack') ?></h2>

                    <?php // Get the right contact form ID and render this contact form
                    $contact_form_id = ICL_LANGUAGE_CODE == 'cs' ? '1' : '3';
                    echo do_shortcode('[gravityform id="'.$contact_form_id.'" name="Kontaktní formulář" title="false" description="false" ajax="true"]'); ?>
                </div>

            </div>

            <div class="row addresses">

                <div class="small-12">
                    <h2 class="text-center element--lined"><span class="element--lined__inner"><?= __('Adresy', 'nicknack'); ?></span></h2>

                    <div class="residency-box text-center">
                        <div class="entry-content">
                            <?php the_field('page_template_residency'); ?>
                        </div>
                    </div>

                    <div class="row">

                        <div class="small-12 medium-6 columns office-box text-center">
                            <div class="entry-content">
                                <?php the_field('page_template_office_address'); ?>
                            </div>
                            <div id="map1" class="gmap"></div>
                        </div>

                        <div class="small-12 medium-6 columns warehouse-box text-center">
                            <div class="entry-content">
                                <?php the_field('page_template_warehouse'); ?>
                            </div>
                            <div id="map2" class="gmap"></div>
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

            // myLatlng1 = new google.maps.LatLng(49.197331, 16.635127); // Filipinskeho
            myLatlng1 = new google.maps.LatLng(49.1847788187963, 16.660158678826626);
            myLatlng2 = new google.maps.LatLng(49.251288, 16.591662);

            function init() {

                var mapOptions1 = {
                    panControl: true,
                    zoomControl: true,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: false,
                    overviewMapControl: false,
                    fullscreenControl: false,
                    zoom: 16,
                    center: myLatlng1,
                    styles: [{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"stylers":[{"hue":"#00aaff"},{"saturation":-100},{"gamma":2.15},{"lightness":12}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"lightness":24}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":57}]}]
                };

                var mapOptions2 = {
                    panControl: true,
                    zoomControl: true,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: false,
                    overviewMapControl: false,
                    fullscreenControl: false,
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
                    title: 'Nicknack s.r.o. kanceláře',
                    icon: image
                });

                var marker2 = new google.maps.Marker({
                    position: myLatlng2,
                    map: map2,
                    title: 'Nicknack s.r.o. sklad',
                    icon: image
                });

                var iw1 = new google.maps.InfoWindow({
                    content: "<strong>Nicknack s.r.o.</strong><br>kanceláře<br><a href=\"https://www.google.com/maps/place/Olomouck%C3%A1+888%2F164,+627+00+Brno-%C4%8Cernovice/@49.1846406,16.6575738,17z/data=!3m1!4b1!4m5!3m4!1s0x471294d13d93a933:0x53fb81b4e3317fa!8m2!3d49.1846406!4d16.6597678\" target=\"_blank\">otevřít na mapách</a>"
                });

                var iw2 = new google.maps.InfoWindow({
                    content: "<strong>Nicknack s.r.o.</strong><br>sklad<br><a href=\"https://www.google.com/maps/place/Kar%C3%A1sek+1767%2F1,+621+00+Brno-%C5%98e%C4%8Dkovice+a+Mokr%C3%A1+Hora/@49.251232,16.5900533,17z/data=!3m1!4b1!4m5!3m4!1s0x471293dfefab0f49:0x127357308b384595!8m2!3d49.251232!4d16.592242\" target=\"_blank\">otevřít na mapách</a>"
                });

                google.maps.event.addListener(marker1, "click", function (e) { iw1.open(map1, marker1); });
                google.maps.event.addListener(marker2, "click", function (e) { iw2.open(map2, marker2); });
            }
        </script>

    <?php endif; ?>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>