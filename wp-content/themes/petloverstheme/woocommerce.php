


<?php
$darkFlavour = "";
if ( ct_get_context_option('general_flavour') ==  'ct--darkMotive') {
    $darkFlavour = "ct-u-backgroundDarkGray";
}?>
<?php if ( is_shop() ) {
    $pageTitle = woocommerce_page_title(false);
} elseif ( is_product_category() ) {
    $pageTitle = woocommerce_page_title(false);
} elseif ( is_product_tag() ) {
    $pageTitle = woocommerce_page_title(false);
} else {
    $pageTitle = ct_get_title();
} ?>

</div>
<?php  ?>
   <div class="ct-u-paddingTop60">
       <div class="container">
           <?php  ?>


           <?php if(is_product()): ?>
               <?php woocommerce_content(); ?>
           <?php else: ?>

           <?php // with sidebar ?>
           <?php if(1): ?>
               <div class="row">
                   <div class="col-md-9 col-md-push-3">
                       <?php woocommerce_content(); ?>
                   </div>
                   <div class="col-md-3 col-md-pull-9 ct-js-sidebar">
                       <div class="row">
                           <?php get_template_part('templates/sidebar-woocommerce') ?>
                       </div>
                   </div>
               </div>
               <!--row_end!-->
               <?php // no sidebar?>
           <?php else: ?>
               <div class="row">
                   <div class="col-md-12">
                       <?php woocommerce_content(); ?>
                   </div>
               </div>
               <!--row_end!-->
           <?php endif; ?>
       </div>
   </div>
        <?php endif; ?>
<div class="container">
