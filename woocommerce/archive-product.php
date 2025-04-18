<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>   


<div class="row">
  <div class="large-12 columns">
    <?php do_action( 'woocommerce_archive_description' ); ?>               
  </div>
  
  <div class="large-5 medium-5 columns">
    <img src="https://nicknack.grafique.cz/wp-content/uploads/2015/01/ph.jpg" class="wp-post-image" alt="ph">
  </div>
  
  <div class="large-7 medium-7 columns">
    <div class="large-6 medium-6 columns">
       <h3>Barevné provedení</h3>
       <ul>
         <li>Bílý</li>
         <li>Barevný</li>
         <li>Fotorealistický plnobarevný potisk</li>
       </ul>  
    </div>
    <div class="large-6 medium-6 columns">
       <h3>Objem</h3>
       <ul>
         <li>0,3l</li>
         <li>0,5l</li>         
       </ul>  
    </div>
  </div>    
</div>


<div class="row">
  <div class="large-12 columns">
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		//do_action( 'woocommerce_before_main_content' );
	?>
    		

		<h2><?php _e('All products') ?></h2>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php //woocommerce_product_loop_start(); ?>
      
      <div class="clear">

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php //woocommerce_product_loop_end(); ?>
      </div>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
	//	do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action( 'woocommerce_sidebar' );
	?>

 </div>   

 <div class="large-12 columns">
  	<h2><?php _e('Want some more or special offer') ?></h2>
    <button><?php _e('Contact us') ?></button>
  </div>
    
</div>

     
<?php get_footer( 'shop' ); ?>
