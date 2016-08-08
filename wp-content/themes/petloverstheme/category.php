<!--container!--></div>


<section class="<?php echo get_section_class('category') ?>">
    <div class="container">

        <div class="ct-pageSectionHeader ct-u-paddingBoth50">
            <h3 class="text-uppercase ct-u-size60 text-center"><?php echo get_category(get_query_var('cat'))->name;?></h3>
        </div>
        <div class="row">
            <div class="col-md-8">
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
<div class="container">

