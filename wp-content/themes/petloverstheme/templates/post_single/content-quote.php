<?php global $post; ?>
    <!-- Meta -->
    <div class="ct-articleBox-titleBox">
        <?php get_template_part('templates/post_single/content-meta'); ?>
    </div>

<!-- Quote Box-->
<div class="ct-articleBox-description">
    <div class="ct-u-paddingBoth40 ct-blog-item--quote">

    <p class="ct-fw-400 ct-u-marginBottom0"> <?php the_content();
        $quote = get_post_meta($post->ID,'quote',true);
        if ($quote != '') : ?>

        "<?php echo esc_html(strip_tags(strip_shortcodes($quote))) ?>" </p>

        <?php endif;?>


        <?php $author = get_post_meta($post->ID, 'quoteAuthor', true);?>
        <?php if ($author !='') :?>
            <span class="ct-u-size18 ct-fw-600">- <?php echo esc_html(strip_tags(strip_shortcodes($author))) ?></span>
        <?php endif;?>



    </div>
</div>