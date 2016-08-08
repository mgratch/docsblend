<?php while (have_posts()) :
    the_post(); ?>
    <?php global $post ?>
    <?php $custom = get_post_custom(get_the_ID()); ?>
    <?php $prev = get_next_post(); ?>
    <?php $next = get_previous_post();



    ?>


    <section class="<?php echo get_section_class('single-portfolio-magnificPopup') ?>">

<div class="container text-center">
        <img src="<?php echo esc_url(ct_get_feature_image_src(get_the_ID(), 'full')); ?>"
             alt="<?php echo esc_attr(get_the_title()) ?>"/>
</div>

        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
    </section>
<?php endwhile; ?>


