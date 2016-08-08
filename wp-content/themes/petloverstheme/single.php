<!--container!--></div>

<section class="ct-u-paddingBottom10 <?php echo get_section_class('post-single') ?>">
    <div class="container">





<?php if (ct_get_context_option("posts_single_show_title_row", 1)): ?>
        <div class="ct-pageSectionHeader ct-u-paddingBoth50">
            <h3 class="text-uppercase ct-u-size60 text-center"><?php echo ct_get_context_option('posts_single_title_row') ?></h3>
        </div>
        <?php else: ?>
        <div class="ct-pageSectionHeader ct-u-paddingBoth50">
            <h3 class="text-uppercase ct-u-size60 text-center">   </h3>
        </div>

<?php endif ?>



        <div class="row">
            <div class="col-md-<?php echo ct_use_blog_post_sidebar()?'8':'12'?>">
                <?php get_template_part('templates/content', 'single'); ?>
            </div>

            <?php if (ct_use_blog_post_sidebar()): ?>
                <div class="col-sm-3 col-sm-offset-1">
                    <?php get_template_part('templates/sidebar') ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>