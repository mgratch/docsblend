<?php global $post; ?>




<div class="ct-articleBox-titleBox">
    <!-- Meta -->
    <?php get_template_part('templates/post_masonry/content-meta'); ?>
</div>

<!-- Quote Box-->
<div class="ct-articleBox-description">
    <blockquote>
        <?php echo esc_html(strip_tags(strip_shortcodes(get_post_meta($post->ID, 'quote', true)))) ?>
        <footer><cite><?php echo esc_html(strip_tags(strip_shortcodes(get_post_meta($post->ID, 'quoteAuthor', true)))) ?></cite></footer>
    </blockquote>

    <!-- Tags -->
    <?php get_template_part('templates/post_masonry/content-meta','tags'); ?>

</div>







