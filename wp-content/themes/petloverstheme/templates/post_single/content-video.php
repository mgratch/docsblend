<?php global $post; ?>

<?php get_template_part('templates/post_single/content-video', 'video'); ?>

<!-- Meta -->
<div class="ct-articleBox-titleBox">
    <h4><?php echo esc_html(ct_get_blog_item_title()) ?></h4>
    <?php get_template_part('templates/post_single/content-meta'); ?>
</div>

<!-- Content -->
<?php if (ct_get_context_option("posts_single_show_content", 1) && get_the_content()): ?>
    <div class="ct-articleBox-description">
        <?php the_content(); ?>
        <?php wp_link_pages(array('before' => '<div class="ct-u-marginTop20 ct-u-marginBottom10"><div class="pagination-post">', 'after' => '</div></div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
    </div>
<?php endif ?>