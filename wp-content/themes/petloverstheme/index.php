<!--container!--></div>

<section class="ct-u-paddingBottom40 <?php echo get_section_class('blog-index') ?>">
    <div class="container">

        <?php if (ct_get_context_option("posts_index_show_title_row", 1)): ?>
            <div class="ct-pageSectionHeader ct-u-paddingBoth50">
                <h3 class="text-uppercase ct-u-size60 text-center"><?php echo ct_get_context_option('posts_index_title_row') ?></h3>
            </div>
        <?php else: ?>
            <div class="ct-pageSectionHeader ct-u-paddingBoth50">
                <h3 class="text-uppercase ct-u-size60 text-center"></h3>
            </div>

        <?php endif ?>
        <div class="row">


            <?php switch (apply_filters('ct.sidebar_type', ct_get_context_option('posts_index_sidebar', 'right'))):

            case 'right': ?>

            <div class="col-sm-8 ct-blog">
                <?php get_template_part('templates/' . apply_filters('ct.blog.index.template_name', ct_get_context_option('posts_show_index_as', 'content'))); ?>
            </div>
            <div class="col-sm-3 col-sm-offset-1">
                <?php get_template_part('templates/sidebar') ?>
            </div>

        </div>

    <?php break; ?>

    <?php case 'left': ?>

        <div class="col-sm-3 ">
            <?php get_template_part('templates/sidebar') ?>
        </div>

        <div class="col-sm-8 col-sm-offset-1 ct-blog">
            <?php get_template_part('templates/' . apply_filters('ct.blog.index.template_name', ct_get_context_option('posts_show_index_as', 'content'))); ?>
        </div>

        <?php break; ?>

    <?php
    case 'none':
        ?>
        <div class="col-sm-12">
            <?php get_template_part('templates/' . apply_filters('ct.blog.index.template_name', ct_get_context_option('posts_show_index_as', 'content'))); ?>
        </div>
    <?php endswitch ?>


    </div>

    <!--row_end!-->
    </div>
</section>



