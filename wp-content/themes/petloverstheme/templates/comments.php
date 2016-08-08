<?php if (!post_password_required()
    && (get_post_type() == 'post' && ct_get_context_option("posts_single_show_comments", 1))
    || (get_post_type() == 'page' && ct_get_context_option("pages_single_show_comments", 0))
):
    ?>
    <?php $commentsCount = count(get_comments(array('type' => 'comment', 'post_id' => $post->ID)));?>
    <?php get_template_part('templates/comments/comments-single'); ?>
    <?php if (comments_open() || $commentsCount > 0): ?>



            <?php if (((get_post_type() == 'post' && ct_get_context_option("posts_single_show_comment_form", 1))
                    || get_post_type() == 'page' && ct_get_context_option("pages_single_show_comment_form", 0)
                    || get_post_type() == 'portfolio' && ct_get_context_option("portfolio_single_show_comment_form", 0)
                )
                && comments_open()
            ) : ?>
                <p class="text-uppercase ct-fw-600">

                </p>
            <?php endif ?>


    <div class="ct-u-paddingBoth40">

        <h5 class="ct-fw-600 text-uppercase"><?php ct_reviews_count() ?> <?php _e('for', 'ct_theme') ?> <?php echo esc_html(ct_get_blog_item_title()) ?> </h5>
    <ul class="ct-mediaList list-unstyled">
        <?php wp_list_comments(array('callback' => 'theme_comments', 'style' => 'ol', 'type' => 'comment')); ?>
    </ul>
</div>
    <?php get_template_part('templates/comments/comments-trackbacks-pingbacks'); ?>
    <?php get_template_part('templates/comments/comments-pagination'); ?>
<?php endif; ?>
    <?php get_template_part('templates/comments/comments-form'); ?>
<?php endif; ?>