<?php
/*
Template Name: Reference
*/

get_header();  
$img = wp_get_attachment_image_src( get_post_thumbnail_id($slide->ID), 'full' );
?>

<section class="reference-header" style="background-image: url('<?=$img[0]?>')">  
  <div class="row">      
    <div class="large-12 columns">                
      <div class="main-content">          
        <?php while ( have_posts() ) : the_post(); ?>    
          <?php the_content(); ?>
        <?php endwhile ?>
      </div>
    </div>    
  </div> 
</section>

  
        
<?php
  $rlist = get_posts(
    array(
      'showposts' => -1, 
      'post_type' => 'reference',
      'suppress_filters' => false,
      'orderby' => 'menu_order', 
      'order' => 'asc'                
    )
  );       
                     
  $i = 0;                        
  foreach ($rlist as $r) {  $i++;

    echo '<section class="ref-section section-'.(($i%2) == 0 ? 'odd' : 'even').'">
            <div class="row">                    
              <div class="large-6 medium-6 small-12 columns '.(($i%2) == 0 ? 'large-push-6 medium-push-6' : '').' ref-thumb">              
                '.get_the_post_thumbnail($r->ID).'
              </div>           
              <div class="large-6 medium-6 small-12 columns '.(($i%2) == 0 ? 'large-pull-6 medium-pull-6' : '').' ref-content">              
                <p>'.$r->post_content.'</p>
                <h2>'.$r->post_title.'</h2>                         
              </div>
            </div>
         </section>';                 
    
  }          
?>
          
    
    
    
<section class="partners-section">   
  <div class="row heading-row">      
    <div class="large-12 columns">  
      <h2><?php _e('Who propagates Nicknacks in the world?') ?></h2>     
    </div>    
  </div> 
  
  <div class="row">    
  <?php                        
    $reflist = get_posts(
      array(
        'showposts' => -1, 
        'post_type' => 'mau_partners',
        'suppress_filters' => false,
        'orderby' => 'menu_order', 
        'order' => 'asc'                
      )
    );                          
    $i = 0;  
              
    foreach ($reflist as $ref) {  $i++;
      $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($ref->ID), 'full' );
      $partner_url = esc_url( get_post_meta( $ref->ID, '_mau_partner_url', true ) );
      $partner_url = empty($partner_url) ? '#' : $partner_url ;
                                                          
      echo '<div class="large-3 medium-3 left columns">
              <div class="reference-box">                  
                <a href="'.$partner_url.'" title="'.$ref->post_title.'" target="_blank">                  
                  <img src="'.$image_attributes[0].'" width="'.$image_attributes[1].'" height="'.$image_attributes[2].'">
                </a>                
              </div>
            </div>';                                                                                                                          
    }                             
  ?>
  </div>


  <div class="row">
    <div class="large-12 columns">
      <a href="<?=get_permalink(icl_object_id(1913, 'page'))?>" class="button"><?php _e('Get in touch with us') ?></a>
    </div>
  </div>    
  
</section>



<?php get_footer(); ?>
