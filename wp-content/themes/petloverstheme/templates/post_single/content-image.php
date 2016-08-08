<?php global $post;?>

<?php if (ct_get_context_option("posts_single_show_image", 1) && has_post_thumbnail(get_the_ID())): ?>

    <!-- Image -->
    <?php get_template_part('templates/post_single/content-featured-image'); ?>

<?php endif; ?>

<!-- Meta -->
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



