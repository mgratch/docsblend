<?php global $post; ?>

<!-- Title Box -->
<div class="ct-articleBox-titleBox">
    <?php get_template_part('templates/post_masonry/content-meta'); ?>
</div>

<?php if (ct_get_context_option("posts_index_show_excerpt", 1)): ?>
    <!-- Description -->
    <div class="ct-articleBox-description">
        <a href="<?php echo esc_url(get_post_meta($post->ID, 'link', true)) ?>"><?php _e(esc_html(ct_get_blog_item_title())) ?> <i class="fa fa-long-arrow-right"></i></a>

        <!-- Tags -->
        <?php get_template_part('templates/post_masonry/content-meta','tags'); ?>

    </div>
<?php endif ?>


