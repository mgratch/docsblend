<?php
/*
Template Name: Faq Template
*/
?>

<?php
$bgClass = ct_get_context_option('faq_bg', '');
?>



</div>
<section
    class="<?php echo get_section_class('faq-index') ?>">
    <div class="container">
        <header class="ct-pageSectionHeader ct-pageSectionHeader--numbered">
            <h2 class="ct-fw-600">
                <span class="text-lowercase"><?php echo ct_get_context_option('faq_section_header', '') ?></span>
                <small
                    class="ct-u-colorMotive ct-fw-300"><?php echo ct_get_context_option('faq_section_subheader', '') ?></small>
            </h2>
        </header>
        <?php get_template_part('templates/content-faq'); ?>
    </div>
</section>


