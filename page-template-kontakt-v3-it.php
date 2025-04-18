<?php
/*
Template Name: Kontakt v3 IT
*/
get_header();

?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php if ( ICL_LANGUAGE_CODE == 'cs' || ICL_LANGUAGE_CODE == 'en' || ICL_LANGUAGE_CODE == 'nl' ) : ?>

        <div class="kontakt-section kontakt-v3">
            <div class="row">
                <?php
            // Get main ACF fields
        $title = get_field('title');
        $description = get_field('description') ? get_field('description') : "Ricevi un'offerta direttamente sulla tua email";
        $button_text = get_field('button_text');
        $team_photo = get_field('page_template_team_photo');
        ?>
                <div class="small-12 quick-contact">
                    <h2 class="element--lined text-center"><span class="element--lined__inner"><?= $title ?></span></h2>
                    <div class="row text-center" style="padding-bottom:20px;">
                        <p><?= sprintf( __($description), '<a href="#" data-reveal-id="inquiryForm">', '</a>'); ?></p>
                        <div><a href="#" class="toggle-form button-form-opener" data-reveal-id="inquiryForm"><?= $button_text ?> <svg class="cup-icon" data-name="Vrstva 1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 18.68 25.86"><defs><style>.cls-1{fill:#e2007a;}</style></defs><path class="cls-1" d="M18.33.41A1.33,1.33,0,0,0,17.38,0H0L2.93,25.86H13.5L16.31,1h1.07a.29.29,0,0,1,.22.1.28.28,0,0,1,.08.22l-.63,11.15,1,.06.63-11.15A1.32,1.32,0,0,0,18.33.41ZM12.61,24.86H3.82L1.12,1H15.31Z"/></svg></a></div>
                            <?php if ( $image_id = $team_photo ) : ?>
                <!-- team photo photo -->
                 <div style="padding-top:10px;">
                <img src="<?= wp_get_attachment_image_src($image_id, 'large')[0]; ?>" alt="" style="width:50%;height:auto;">
                </div>
            <?php endif; ?>                    
                        </div>
                </div>
            
            <?php 
                // Contact sections from repeater field
                if (have_rows('contact_section')) :
                    while (have_rows('contact_section')) : the_row();
                $section_title = get_sub_field('title');
                $left_column = get_sub_field('left_column');
                $right_column = get_sub_field('right_column');
        ?>                
                <div class="small-12 quick-contact" style="margin-top: 70px;margin-bottom: 50px;">
                    <?php if ($section_title) : ?>
                        <h2 class="element--lined text-center"><span class="element--lined__inner"><?php echo esc_html($section_title); ?></span></h2>
                        <?php endif; ?>
                    <div class="row quick-contact__content_it" style="  color: #e2007a !important;">
                        <div class="small-12 medium-6 columns text-center"> <?php echo wp_kses_post($left_column); ?></div>
                        <div class="small-12 medium-6 columns text-center"> <?php echo wp_kses_post($right_column); ?></div>
                    </div>
                </div>
            <?php 
        endwhile;
        endif; ?>
            </div>

            <?php 
        endif; ?>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>