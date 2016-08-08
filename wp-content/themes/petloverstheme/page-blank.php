</div>
<?php
/*
Template Name: Maintenance Page
*/
?>


<div class="ct-maintenanceNav">
    <div class="container">
        <div class="ct-u-paddingBoth40">

                <img  src="<?php echo esc_url(ct_get_context_option('general_logo_standard')); ?>" alt="">

        </div>
    </div>
</div>




<section class="ct-sectionMaintenance">
    <div class="ct-sectionMaintenance-inner">

        <div class="container">
            <h3 class="ct-maintenanceHeader"> <?php echo ct_get_context_option('maintenance_page_title', 'We Will Launch Our Website Very Soon')?></h3>
            <p class="ct-u-motiveBody text-center"><?php echo ct_get_context_option('maintenance_page_description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae quam massa. Suspendisse potenti. Morbi vel nunc ante. Morbi dictum in eros a placerat. Phasellusu etau ultrices ligula non dui tincidunt pulvinar. Nullam arcu nunc, mollis eget massa a, vestibulum eleifend urna.')?></p>


        <?php get_template_part('templates/content', 'page'); ?>



        </div>
    </div>


</section>


<footer class="ct-footerBig">
    <div class="ct-footerBig-inner">
        <div class="container">

            <div class="ct-footerBig-buttons">
                    <?php echo do_shortcode('[socials use_global="yes" type="3"]') ?>
            </div>

            <a href="<?php echo ct_get_context_option('general_footer_link') ?>"><p class="ct-u-motiveDark ct-u-paddingBoth10 ct-u-size14 ct-fw-600"> <?php echo ct_get_context_option('general_footer_text')?></p></a>



        </div>
    </div>
</footer>


