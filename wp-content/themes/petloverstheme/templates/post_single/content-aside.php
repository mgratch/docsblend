<?php global $post; ?>
<?php get_template_part('templates/post_single/content-meta'); ?>
<!-- Content -->
<div class="ct-articleBox-description">
    <?php if (ct_get_context_option("posts_single_show_content", 1) && get_the_content()): ?>
        <?php echo esc_html(strip_tags(strip_shortcodes(get_the_content()))) ?>
    <?php endif ?>
</div>