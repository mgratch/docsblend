<?php global $post; ?>
<!-- Media -->
<div class="ct-articleBox-media">
    <?php
    $embed = get_post_meta($post->ID, 'videoCode', true);
    if (!empty($embed)) {
        echo stripslashes(htmlspecialchars_decode($embed));//no escape required
    } else {
        echo ct_post_audio($post->ID, '100%', 200);
    }
    ?>
</div>

<!-- Title Box -->
<div class="ct-articleBox-titleBox">
    <h4><?php echo esc_html(ct_get_blog_item_title()) ?></h4>
    <?php get_template_part('templates/post_single/content-meta'); ?>
</div>

<!-- Content -->
<?php if (ct_get_context_option("posts_single_show_content", 1) && get_the_content()): ?>
    <div class="ct-articleBox-description">
        <?php the_content(); ?>

        <!-- Paginate single post -->
        <?php get_template_part('templates/post_single/content-pagination'); ?>

    </div>
<?php endif ?>



