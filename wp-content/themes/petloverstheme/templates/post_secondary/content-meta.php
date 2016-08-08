<p class="ct-u-motiveLight">
    <?php echo  _e('By ', 'ct_theme');

    $author = get_the_author();

    echo '<a href="' .esc_url(get_author_posts_url(get_the_author_meta('ID'))). '">' .get_the_author() . '</a>' ?>

    <?php if (ct_get_context_option("posts_single_show_categories", 1)): ?>
        <?php
        _e(' in ', 'ct_theme');
        foreach (wp_get_post_categories(get_the_ID()) as $cat) {

            // Get the URL of this category
            $category_link = get_category_link($cat);
            $cat_name = get_cat_name($cat);
            echo '<a href="' . esc_url($category_link) . '">' . $cat_name . '</a>  ';
        }
        ?>
    <?php endif ?>

    <?php if (ct_get_context_option("posts_single_show_date", 1)): ?>
        <?php echo sprintf(__('on %s -', 'ct_theme'), esc_html(get_the_date())); ?>
    <?php endif ?>

    <?php if (ct_get_context_option("posts_single_show_comments_link", 1)): ?>
        <span class="entry-comments"><a
                href="<?php echo get_permalink(get_the_ID()) ?>#comments"><?php ct_comments_count() ?></a></span>
    <?php endif ?>
</p>


