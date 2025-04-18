<?php
/*
Template Name: HotCup
*/
get_header();

?>

<?php
  while ( have_posts() ) : the_post(); 
  $img = wp_get_attachment_image_src( get_post_thumbnail_id($slide->ID), 'full' );
?>

<section class="proc-header" style="background-image: url('<?=$img[0]?>')">
  <div class="row">
    <div class="large-12 columns">
      <div class="main-content">
         <?php the_field('header_content') ?>
      </div>
    </div>
  </div>
</section>

<div class="entry-content gutenberg-content" style="margin-top:50px">
  <?php the_content(); ?>
</div>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>