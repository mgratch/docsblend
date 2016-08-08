<?php

/**
 * Draw breadcrumbs with woocommerce support
 * @author jacek
 *
 */
class ctBreadcrumbs
{

    private $settings;

    /**
     * default settings
     * @param 'home_label'
     * @param 'shop_label'
     * @param 'post_types'
     * @param 'wrapper_class' - a class to add to the main breadcrumb wrapper
     */

    public function __construct()
    {

        if (ct_is_woocommerce_active()) {
            $shop_page_title = get_the_title(woocommerce_get_page_id('shop'));
        } else {
            $shop_page_title = '';
        }

        $this->settings = apply_filters('ct.breadcrumbs.settings', array(
            'home_label' => esc_html__('Home', 'ct_theme'),
            'shop_label' => $shop_page_title,
            'post_types' => $this->getCustomPostTypes(),
            'wrapper_class' => 'breadcrumb',
        ));

        add_filter('ct.breadcrumbs.display', array($this, 'displayForFilter'), 10, 2);

    }

    /**
     * display filtered breadcrumb trail
     * @param $output
     * @param array $options
     * @return null|string
     */

    public function displayForFilter($output, $options = array())
    {
        return $this->display($options);
    }

    /**
     * read all of the CPT and unset the default and woocommerce ones
     * @return array
     */

    protected function getCustomPostTypes()
    {

        $types = get_post_types();
        unset($types['revision'], $types['nav_menu_item'], $types['post'], $types['page'], $types['product']);
        return $types;
    }

    /**
     * build the breadcrumbs trail
     * @param array $settings
     * @return null|string
     * get_option('page_for_posts');
     */

    public function display($settings = array())
    {
        if (apply_filters('ct_breadcrumbs.display_none',false)){
            return'';
        }

        global $post;
        $bc_string = null;


        $settings = array_merge($this->settings, $settings);



        if (is_404()){
            return '';
        }

        if (!is_front_page()) {
            $bc_string .= $this->wrapItem('<a href="' . esc_url(home_url('/')) . '">' . $settings['home_label'] . '</a>');

        }


        //portfolio and other CPT archives
        if (is_post_type_archive()) {
            $queriedObject = get_queried_object();
            if (isset($queriedObject->rewrite)) {
                $tmp = $queriedObject->rewrite;
                if (isset($tmp['slug'])){
                    $bc_string .= $this->wrapItem($tmp['slug']);

                    return $this->wrapBreadcrumbs($bc_string, $settings);
                }
            }
        }


        if (is_category()) {
            $cat_id = get_query_var('cat');
            $cat_name = get_the_category_by_ID($cat_id);
            $bc_string .= $this->wrapItem($cat_name);
        }





        $blogPageNotDefined = false;
        //is blog?
        if (get_option('page_for_posts')==0 && !is_single() && !is_page() && !is_post_type_archive() ){

                $blogPageNotDefined = '<li>'.esc_html__('Blog','ct_theme').'</li>';


            return $this->wrapBreadcrumbs($blogPageNotDefined, $settings);

        }elseif (get_the_id(get_option('page_for_posts')) == get_the_id() && !is_single() && !is_page()) {
            $bc_string .= $this->wrapItem(get_the_title(get_option('page_for_posts')), 'active');
            return $this->wrapBreadcrumbs($bc_string, $settings);
        }







        /*custom post type*/
        $is_single_cpt = false;
        foreach ($settings['post_types'] as $cpt) {
            if (is_singular($cpt)) {
                $is_single_cpt = true;
                $cpt_index_page = $cpt . '_index_page';
                $archive = ct_get_option($cpt_index_page);
                if ($archive) {
                    $archive_url = get_permalink($archive);
                    $archive_title = get_the_title($archive);
                    $bc_string .= $this->wrapItem('<a href="' . esc_url($archive_url) . '">' . $archive_title . '</a>', 'active');
                }
                $bc_string .= $this->wrapItem(get_the_title());
            }
        }


        if (is_tax() && !is_tax('product_cat')) {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $bc_string .= $this->wrapItem($term->name);
        }


        if (is_home()) {

            $bc_string .= $this->wrapItem($settings['home_label']);
        }

        $woo_mark = false;


        /*woocommerce*/
        if (class_exists('Woocommerce')) {

            if (is_woocommerce()) {
                $woo_mark = true;
            }
            if (is_shop()) {
                $bc_string .= $this->wrapItem($settings['shop_label']);

            }

            if (is_product()) {


                $shop_page_url = get_permalink(woocommerce_get_page_id('shop'));
                $product_name = the_title('', '', false);
                $bc_string .= $this->wrapItem('<a href="' . esc_url($shop_page_url) . '">' . $settings['shop_label'] . '</a>');

                if ($terms = wp_get_post_terms($post->ID, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'))) {

                    $main_term = $terms[0];

                    $ancestors = get_ancestors($main_term->term_id, 'product_cat');

                    $ancestors = array_reverse($ancestors);

                    foreach ($ancestors as $ancestor) {
                        $ancestor = get_term($ancestor, 'product_cat');

                        $bc_string .= $this->wrapItem('<a href="' . esc_url(get_term_link($ancestor->slug, 'product_cat')) . '">' . $ancestor->name . '</a>');
                    }

                    $bc_string .= $this->wrapItem('<a href="' . esc_url(get_term_link($main_term->slug, 'product_cat')) . '">' . $main_term->name . '</a>');

                }
                $bc_string .= $this->wrapItem($product_name);
            }
            if (class_exists('YITH_WCWL')) {
                $wishlist_page_id = get_option('yith_wcwl_wishlist_page_id');
            } else {
                $wishlist_page_id = null;
            }


            if (is_checkout() || is_account_page() || is_cart()) {
                $shop_page_url = get_permalink(woocommerce_get_page_id('shop'));
                $bc_string .= $this->wrapItem('<a href="' . esc_url($shop_page_url) . '">' . $settings['shop_label'] . '</a>');
            }

            if (is_tax('product_cat')) {
                $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                $shop_page_url = get_permalink(woocommerce_get_page_id('shop'));
                $bc_string .= $this->wrapItem('<a href="' . esc_url($shop_page_url) . '">' . $settings['shop_label'] . '</a>');
                $bc_string .= $this->wrapItem($term->name);
            }
        }


        /*page*/
        if (is_page() && !is_front_page()) {
            $parents = array();

            $parent_id = $post->post_parent;

            while ($parent_id) :
                $page = get_post($parent_id);

                $parents[] = '<a href="' . esc_url(get_permalink($page->ID)) . '" title="' . esc_attr(get_the_title($page->ID)) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            endwhile;
            $parents = array_reverse($parents);
            if ($parents) {
                foreach($parents as $singleParent){
                    $bc_string .=$this->wrapItem($singleParent);
                }
            }
            $bc_string .= $this->wrapItem(get_the_title(), 'active');
        }


        /*post single*/
        if (is_single() && !$is_single_cpt && !$woo_mark) {
            if (get_option('page_for_posts')==0){

                    $blogPageNotDefined = esc_html__('Blog','ct_theme');

            }

            if ($blogPageNotDefined){
                $bc_string .= $this->wrapItem('<a href="' . esc_url(home_url('/')) . '">' . $blogPageNotDefined . '</a>');
            }else{
                $bc_string .= $this->wrapItem('<a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">' . get_the_title(get_option('page_for_posts')) . '</a>');
            }

            $categories_1 = get_the_category($post->ID);

            if ($categories_1):
                foreach ($categories_1 as $cat_1):
                    $cat_1_ids[] = $cat_1->term_id;
                endforeach;

                $cat_1_line = implode(',', $cat_1_ids);

            endif;
            $categories = get_categories(array(
                'include' => $cat_1_line,
                'orderby' => 'id'
            ));

            if ($categories && $woo_mark && ct_is_woocommerce_active()) :
                $cats_qty = count($categories);
                $loop_mark = 1;
                foreach ($categories as $cat) :
                    if ($loop_mark == $cats_qty) {
                        $cats[] = $this->wrapItem('<a href="' . esc_url(get_category_link($cat->term_id)) . '" title="' . $cat->name . '">' . $cat->name . '</a>');
                    } else {
                        $cats[] = $this->wrapItem('<a href="' . esc_url(get_category_link($cat->term_id)) . '" title="' . $cat->name . '">' . $cat->name . '</a>', '');
                    }

                    $loop_mark++;
                endforeach;
                $bc_string .= join('', $cats);
            endif;

            $bc_string .= $this->wrapItem(get_the_title(), 'active');

        }
        if (is_tag()) {
            $bc_string .= $this->wrapItem("Tag: " . single_tag_title('', FALSE));
        }
        if (is_year()) {
            $bc_string .= $this->wrapItem(get_the_time('Y'));
        }

        $bc_string = $this->wrapBreadcrumbs($bc_string, $settings);

        return $bc_string;

    }


    /***Do usun**/

    public function my_get_menu_item_name($loc)
    {
        global $post;

        $locs = get_nav_menu_locations();

        $menu = wp_get_nav_menu_object($locs[$loc]);

        if ($menu) {

            $items = wp_get_nav_menu_items($menu->term_id);

            foreach ($items as $k => $v) {
                // Check if this menu item links to the current page
                if ($items[$k]->object_id == $post->ID) {
                    $name = $items[$k]->title;
                    break;
                }
            }

        }
        return $name;
    }

    /**
     * wrap the whole breacrumbs trail
     * @param $html
     * @param $settings
     * @return string
     */

    protected function wrapBreadcrumbs($html, $settings)
    {
        return '<ol class="' . esc_attr($settings['wrapper_class']) . '">' . $html . '</ol>';
    }

    /**
     * wrap single breadcrumb
     * @param $item
     * @param string $class
     * @return string
     */

    protected function wrapItem($item, $class = '')
    {
        $class = $class != '' ? ' class="' . $class . '"' : '';
        return '<li' . $class . '>' . $item . '</li>';
    }

}


/**
 * show single post breadcrumbs?
 */
if (!function_exists('ct_show_breadcrumbs')) {

    /**
     * @return bool
     */
    function ct_show_breadcrumbs()
    {
        $show = ct_get_context_option('show_breadcrumbs', 1, array(), array('without_namespace' => array('meta')));
        return $show == 1 || $show == 'yes';
    }
}


/**
 * generate breadcrumbs html
 */
if (!function_exists('ct_get_breadcrumbs_html')) {

    /**
     * @return bool
     */
    function ct_get_breadcrumbs_html()
    {
        new ctBreadcrumbs();
        if (ct_show_breadcrumbs()) {
            return apply_filters('ct.breadcrumbs.display',
                array('wrapper_class' => "breadcrumb pull-right")
            );
        }
    }
}
