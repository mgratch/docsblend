<!--container!--></div>
<?php get_template_part('templates/page', 'head'); ?>

<?php /*$breadcrumbs = ct_show_index_post_breadcrumbs('team') ? 'yes' : 'no'; */?>
<?php if (ct_get_option("team_single_show_p_title", 1) || $breadcrumbs == "yes"): ?>
    <?php /*$pageTitle = (ct_get_option("posts_index_show_p_title", 1)) ? ct_get_option("team_single_page_title", 1) : ''; */?>
<!-- --><?php /*echo do_shortcode('[title_row context="team_single" header="' . $pageTitle . '" breadcrumbs="' . $breadcrumbs . '"]') */?>
<?php endif ?>
<div class="container">


    <?php get_template_part('templates/content', 'single-team'); ?>
