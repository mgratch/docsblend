<?php global $post;
global $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$columnsFromQuery = get_query_var('ct_columns');//from onepager shortcode


if (is_numeric($columnsFromQuery)) {
    switch ($columnsFromQuery) {
        default:
        case 1:
            $class = 'ct-gallery--col1';
            break;
        case 2:
            $class = 'ct-gallery--col2';
            break;
        case 3:
            $class = 'ct-gallery--col3';
            break;
        case 4:
            $class = 'ct-gallery--col4';
            break;
    }
} elseif (isset($_GET['portfolio_columns'])) {//from URL parameter
    switch ($_GET['portfolio_columns']) {
        default:
        case 1:
            $class = 'ct-gallery--col1';
            break;
        case 2:
            $class = 'ct-gallery--col2';
            break;
        case 3:
            $class = 'ct-gallery--col3';
            break;
        case 4:
            $class = 'ct-gallery--col4';
            break;
    }
} else {// From theme options

    switch (apply_filters('ct.portfolio_columns', ct_get_context_option('portfolio_masonry_columns', '3'))):

        case '1':

            apply_filters('ct.portfolio_columns.template_name', ct_get_context_option('portfolio_masonry_columns', 3));
            $class = 'ct-gallery--col1';
            break;

        case '2':
            apply_filters('ct.portfolio_columns.template_name', ct_get_context_option('portfolio_masonry_columns', 3));
            $class = 'ct-gallery--col2';
            break;

        case '3':
            apply_filters('ct.portfolio_columns.template_name', ct_get_context_option('portfolio_masonry_columns', 3));
            $class = 'ct-gallery--col3';
            break;

        case '4':
            apply_filters('ct.portfolio_columns.template_name', ct_get_context_option('portfolio_masonry_columns', 3));
            $class = 'ct-gallery--col4';
            break;


            endswitch;

/*

    if (ct_get_context_option('portfolio_masonry_columns', 3) == 1) {
        $class = 'ct-gallery--col1';
    } elseif (ct_get_context_option('portfolio_masonry_columns', 3) == 2) {
        $class = 'ct-gallery--col2';
    } elseif (ct_get_context_option('portfolio_masonry_columns', 3) == 3) {
        $class = 'ct-gallery--col3';
    } else {
        $class = 'ct-gallery--col4';
    }*/
}

//check for shortcode
if (get_query_var('ct_shortcode_mode') == true) {
    $fixOnScroll = '';
} else {
    $fixOnScroll = 'ct-js-fixOnScroll';
}





if (!function_exists('get_cat_filter_class')) {
    function get_cat_filter_class($cat)
    {
        return strtolower(str_replace(' ', '-', $cat->slug));
    }
}


if (ct_get_context_option('portfolio_index_filters', 1)):
    $all = ct_get_context_option('portfolio_index_all_label', 'ALL');
    $catsListHtml = $all != '' ? '<li><a data-filter="*" class="btn btn-motiveDark ct-u-marginTop20 active"><span>' . $all . '</span></a></li>' : '';
    $orderby = ct_get_context_option('portfolio_index_filters_orderby', 1);
    $order = ct_get_context_option('portfolio_index_filters_order', 1);

    $args = array (
        'hide_empty' => true,
        'orderby' => $orderby,
        'order' => $order
    );

    $terms = get_terms('portfolio_category', $args);

    $post_ids = wp_list_pluck($wp_query->posts, 'ID');

    foreach ($terms as $term) {



        $show = false;

        //hide empty category labels (taking into account current query)
        foreach($post_ids as $id) {
            if(has_term($term->term_id, 'portfolio_category', $id)) {
                $show = true;
                break;
            }
        }

        if($show === true) {
            $catsListHtml .= '<li><a data-filter=".' . get_cat_filter_class($term) . '" class="btn btn-motiveDark ct-u-marginTop20"><span>' . $term->name . '</span></a></li>';
        }

    }?>





<?php switch (apply_filters('ct.portfolio', ct_get_context_option('portfolio_space', 'boxed'))):
case 'full':
    apply_filters('ct.portfolio.template_name', ct_get_context_option('portfolio_space', 'boxed'));

    break;
case 'boxed':?>
<div class="container">
<?php apply_filters('ct.portfolio.template_name', ct_get_context_option('portfolio_space', 'boxed'));?>
<?php break;


     endswitch ?>





    <?php if (ct_get_context_option('portfolio_index_show_title_row')== '1'){?>

    <div class="ct-sectionHeader ">
        <h2><?php echo ct_get_context_option('portfolio_index_title_row') ?></h2>
    </div>
       <?php }?>


    <?php if ($catsListHtml): ?>
    <div class="clearfix <?php echo sanitize_html_class($fixOnScroll) ?>">
        <div class="text-center">
            <ul class="ct-gallery-filters list-unstyled list-inline ct-gallery-buttons ct-u-marginBottom50">
                <?php echo $catsListHtml ?>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
<?php endif ?>
<?php endif ?>

    <?php $class .= ' ' . 'ct-js-magnificPortfolioPopupGroup' ?>

<div id="ct-gallery" class="ct-gallery  <?php echo esc_attr($class) ?>">

    <?php if (have_posts()) :
     while (have_posts()) : the_post();
        $custom = get_post_custom($post->ID);
        $summary = isset($custom["summary"][0]) ? $custom["summary"][0] : "";
        $displayMethod = isset($custom['display_method'][0]) ? $custom['display_method'][0] : 'image';
        $title = isset($custom["title"][0]) ? $custom["title"][0] : "";
        $top_title = isset($custom["top_title"][0]) ? $custom["top_title"][0] : "";
        $bottom_title = isset($custom["bottom_title"][0]) ? $custom["bottom_title"][0] : "";

         $catClass = ct_get_categories_slug_string(
            get_the_ID(),
            $separator = ' ', $taxonomy = 'portfolio_category'); ?>



        <div class="ct-gallery-item ct-gallery-item--masonry ct-gallery-item--default hidden ct-gallery-item--normal <?php echo esc_attr($catClass) ?>">
            <div class="ct-gallery-itemInner">


                    <a href="<?php echo esc_url(ct_get_feature_image_src(get_the_ID(), 'full')); ?>"
                       class="ct-js-magnificPortfolioPopup">

                        <div class="ct-imageOverlay-container">
                            <div class="ct-imageButton"></div>
                            <div class="ct-imageOverlay">
                                <div class="ct-imageOverlay-text">
                                    <h3 class="text-center text-uppercase ct-fw-300"><?php echo $top_title ?></h3>
                                    <h3 class="text-center text-uppercase ct-fw-300"><span class="ct-fw-500"> <?php echo esc_attr($title) ?></span></h3>
                                    <h3 class="text-center text-uppercase ct-fw-300"><?php echo esc_attr($bottom_title) ?></h3>
                                </div>
                            </div>
                            <img src="<?php echo esc_url(ct_get_feature_image_src(get_the_ID(), 'full')); ?>"
                                 alt="<?php echo esc_attr(get_the_title()) ?>"/>
                        </div>
                    </a>
            </div>
        </div>



    <?php endwhile; ?>
    <?php if (get_query_var('ct_shortcode_mode') != true): ?>
        <?php get_template_part('templates/portfolio/content-portfolio-pagination', 'masonry'); ?>
    <?php endif ?>

</div>



<?php else: ?>
    <div>
        <div class="gallerymessage"><?php _e('No search results found', 'ct_theme'); ?></div>

    </div>
    </div>
<?php
endif;
?>
    <?php switch (apply_filters('ct.portfolio', ct_get_context_option('portfolio_space', 'boxed'))):
    case 'full':
        apply_filters('ct.portfolio.template_name', ct_get_context_option('portfolio_space', 'boxed'));

        break;
    case 'boxed':?>
    </div>
        <?php apply_filters('ct.portfolio.template_name', ct_get_context_option('portfolio_space', 'boxed'));?>
        <?php break;


        endswitch ?>

<?php if (get_query_var('ct_shortcode_mode') != true): ?>
    <?php endif ?>





