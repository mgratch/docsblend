<?php
/*
Template Name: Archive Portfolio
*/
?>
<?php /*get_template_part('templates/portfolio/content-portfolio-masonry', 'masonry'); */?>

<?php add_action('wp_footer','enqueuePortfolioScripts');?>

<?php get_template_part('templates/portfolio/content-portfolio', 'masonry'); ?>


