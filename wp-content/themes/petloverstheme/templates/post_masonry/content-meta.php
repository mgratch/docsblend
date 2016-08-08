<div class="ct-articleBox-meta">
    <?php if (ct_get_context_option("posts_single_show_date", 1)): ?>
        <?php echo sprintf(__('Posted on %s at %s.', 'ct_theme'), esc_html(get_the_date()), esc_html(get_the_time())); ?>
    <?php endif ?>

    <?php if (ct_get_context_option("posts_single_show_categories", 1)): ?>
        <?php
        _e(' IN ', 'ct_theme');
        foreach (wp_get_post_categories($post->ID) as $cat) {

            // Get the URL of this category
            $category_link = get_category_link($cat);
            $cat_name = get_cat_name($cat);
            echo '<a href="' . esc_url($category_link) . '">' . $cat_name . '</a> / ';
        }
        ?>
    <?php endif ?>


    <?php if (ct_get_context_option("posts_single_show_comments_link", 1)): ?>
        <span class="entry-comments"><a
                href="<?php echo get_permalink($post->ID) ?>#comments"><?php ct_comments_count() ?></a></span>
    <?php endif ?>
</div>


