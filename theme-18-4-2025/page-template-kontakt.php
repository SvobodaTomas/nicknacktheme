<?php
/*
Template Name: Kontakt
*/
get_header();

?>

<?php while ( have_posts() ) : the_post(); ?>

<section class="kontakt-section">
  <div class="row">
    <div class="large-12 columns">
      <?php the_content(); ?>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">  
      <div class="kde">
        <?php /*<h2><?php _e('Where to find us', 'nicknack') ?></h2>
        <div id="map"></div>*/ ?>
      </div>
      
      <?php if ( ICL_LANGUAGE_CODE == 'cs') { ?>
      <div class="kontakt-form cs">
        <h2><?php _e('Write to us', 'nicknack') ?></h2>
        <?= do_shortcode('[gravityform id="1" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
    </div>
    <?php } elseif ( ICL_LANGUAGE_CODE == 'pl') { ?>

    <div class="kontakt-form pl">
        <h2><?php _e('Write to us', 'nicknack') ?></h2>
        <?= do_shortcode('[gravityform id="4" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
    </div>

    <?php } else { ?>

    <div class="kontakt-form en">
        <h2><?php _e('Write to us', 'nicknack') ?></h2>
        <?= do_shortcode('[gravityform id="3" name="Kontaktní formulář" title="false" description="false" ajax="true"]')?>
    </div>

    <?php } ?>
    </div>
  </div>
</section>

<?php endwhile; // end of the loop. ?>

<?php /*if ( ICL_LANGUAGE_CODE == 'pl') { ?>

    <script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            var myLatlng = new google.maps.LatLng(49.197331, 16.635127);
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

<?php } else {*/ if ( ICL_LANGUAGE_CODE != 'pl') { ?>

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

<?php } ?>


<?php get_footer(); ?>