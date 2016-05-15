<?php defined('ABSPATH') or die("No script kiddies please!");?>
<?php $wr_options = get_option('wr_wp'); ?>
<?php
get_header();
/*Template Name:Default Template*/
 ?>
       
         <?php if ( is_singular( 'product' ) ) {
           woocommerce_content();
          }else{
          //For ANY product archive.
          //Product taxonomy, product search or /shop landing
           woocommerce_get_template( 'archive-product.php' );
          }?>
          
       
      
<?php get_footer(); ?>
