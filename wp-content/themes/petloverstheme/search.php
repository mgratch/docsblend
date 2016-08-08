<?php
/**
 * Displays search results. Called automatically by WordPress
 */

?>
<!--container!--></div>


<section class="<?php echo get_section_class('search') ?>">
    <div class="container">
        <div class="ct-pageSectionHeader ct-u-paddingBoth50">
            <h3 class="text-uppercase ct-u-size60 text-center"><?php _e('Search Results','ct_theme'); ?></h3>
        </div>
        <div class="row">
            <div class="col-md-<?php echo ct_use_blog_index_sidebar()?'8':'12'?>">

                <?php get_template_part('templates/content'); ?>
                <!--col-md-8 end!-->
            </div>
            <?php if (ct_use_blog_index_sidebar()): ?>
                <div class="col-md-4 ct-js-sidebar">
                    <?php get_template_part('templates/sidebar') ?>
                </div>
            <?php endif ?>

        </div>
        <!--row_end!-->
    </div>
</section>