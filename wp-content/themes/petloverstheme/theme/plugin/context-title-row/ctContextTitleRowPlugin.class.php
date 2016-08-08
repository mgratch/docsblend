<?php

/**
 * Created by PhpStorm.
 * User: Patryk
 * Date: 2015-01-26
 * Time: 21:04
 */
class ctContextTitleRowPlugin
{

    /**
     *
     */
    private function setupConstants()
    {
        if (!defined('CT_CONTEXT_TITLE_TAG')) {
            define('CT_CONTEXT_TITLE_TAG', apply_filters('ct_context_title.tag', esc_html__('Posts tagged: ', 'ct_theme')));
        }

        if (!defined('CT_CONTEXT_TITLE_CAT')) {
            define('CT_CONTEXT_TITLE_CAT', apply_filters('ct_context_title.cat', esc_html__('Posts in: ', 'ct_theme')));
        }

        if (!defined('CT_CONTEXT_TITLE_AUTHOR')) {
            define('CT_CONTEXT_TITLE_AUTHOR', apply_filters('ct_context_title.author', esc_html__('Posts by: ', 'ct_theme')));
        }

        if (!defined('CT_CONTEXT_TITLE_SEARCH')) {
            define('CT_CONTEXT_TITLE_SEARCH', apply_filters('ct_context_title.search', esc_html__('Search Results for: ', 'ct_theme')));
        }

        if (!defined('CT_CONTEXT_TITLE_NOTHING_FOUND')) {
            define('CT_CONTEXT_TITLE_NOTHING_FOUND', apply_filters('ct_context_title.nothing_found', esc_html__('Nothing Found', 'ct_theme')));
        }

        if (!defined('CT_CONTEXT_TITLE_BLOG_DEFAULT')) {
            define('CT_CONTEXT_TITLE_BLOG_DEFAULT', apply_filters('ct_context_title.blog_default', esc_html__('Blog', 'ct_theme')));
        }

        if (!defined('CT_CONTEXT_TITLE_DAILY_ARCHIVES')) {
            define('CT_CONTEXT_TITLE_DAILY_ARCHIVES', apply_filters('ct_context_title.blog_daily_archives', esc_html__('Daily Archives: ', 'ct_theme')));
        }


        if (!defined('CT_CONTEXT_TITLE_MONTHLY_ARCHIVES')) {
            define('CT_CONTEXT_TITLE_MONTHLY_ARCHIVES', apply_filters('ct_context_title.blog_monthly_archives', esc_html__('Monthly Archives: ', 'ct_theme')));
        }

        if (!defined('CT_CONTEXT_TITLE_YEARLY_ARCHIVES')) {
            define('CT_CONTEXT_TITLE_YEARLY_ARCHIVES', apply_filters('ct_context_title.blog_yearly_archives', esc_html__('Yearly Archives: ', 'ct_theme')));
        }



        if (!defined('CT_CONTEXT_TITLE_ARCHIVES')) {
            define('CT_CONTEXT_TITLE_ARCHIVES', apply_filters('ct_context_title.blog_archives', esc_html__('Archives', 'ct_theme')));
        }

         if (!defined('CT_CONTEXT_TITLE_404')) {
            define('CT_CONTEXT_TITLE_404', apply_filters('ct_context_title.404', esc_html__('404', 'ct_theme')));
        }

    }


    /**
     *
     */
    public function __construct()
    {
        $this->setupConstants();
        add_filter('ct_page_title', array($this, 'getTitleFiltered'));
    }


    /**
     * @return bool|string
     */
    public function getBaseContext()
    {


        $qoID = get_queried_object_id();
        $templateSlug = get_post_meta($qoID, '_wp_page_template', true);

        //is search?
        if (is_search()) {
            return 'search';
        }
        //is tag?
        if (is_tag()) {
            return 'tag';
        }
        //is category?
        if (is_category()) {
            return 'category';
        }
        //is author?
        if (is_author()) {
            return 'author';
        }

        //is blog?
        if (get_option('page_for_posts') == get_queried_object_id()
            && !is_year()
            && !is_day()
            && !is_month()
        ) {
            //#27300 bug fix
            if (!function_exists('is_woocommerce') || !is_woocommerce()) {
                return 'blog';
            }
        }


        //is page?
        if (is_page() && ($templateSlug !=='archive.php')) {
            return 'page';
        }

        //is 404?
        if (is_404()) {
            return '404';
        }


        //is single?
        if (is_single()) {
            return get_post_type();
        }


        //is archive?
        if (is_archive() && !is_author() && !is_category() && !is_tag() && !is_search()) {
            if (is_day()) {
                return 'day';
            } elseif (is_month()) {
                return 'month';
            } elseif (is_year()) {
                return 'year';
            } else {
                return 'archive';
            }
        }

        if ($templateSlug == 'archive.php'){
            return  'archive';
        }

        //Bug #27799 , scenario: home url + not specified frotntpage
        if (is_home() && ''=== ct_get_option('page_on_front')){
            return 'blog';
        }

        //for unhandled cases:
        return 'blog';


    }


    /**
     * @return bool|string
     */
    public function isSearchSuccess()
    {
        global $wp_query;
        if (is_object($wp_query) && property_exists($wp_query, 'found_posts')) {
            return (int)$wp_query->found_posts > 0 ? true : false;
        }
        return '';
    }

    /**
     * @return string
     */
    public function getSearchedString()
    {
        global $wp_query;
        if (is_object($wp_query) && property_exists($wp_query, 'query')) {
            $query = $wp_query->query;
            $str =  isset($query['s']) ? $query['s'] : '';
            $str = rawurldecode($str) === '+' ? rawurldecode($str) : str_replace("+", "&nbsp;", rawurldecode($str));
            return $str;
        }
        return '';
    }

    /**
     * @param $pageTitle
     * @return mixed|string
     */
    public function getTitleFiltered($pageTitle)
    {

        //for other  types
        if ($this->getBaseContext() == 'tag') {
            return CT_CONTEXT_TITLE_TAG . single_tag_title('', false);
        }
        if ($this->getBaseContext() == 'category') {
            return CT_CONTEXT_TITLE_CAT . single_cat_title('', false);
        }
        if ($this->getBaseContext() == 'author') {
            $author = get_the_author();
            return CT_CONTEXT_TITLE_AUTHOR . $author;
        }

        if ($this->getBaseContext() == 'search') {
            if ($this->isSearchSuccess()) {
                return CT_CONTEXT_TITLE_SEARCH . $this->getSearchedString();
            } else {
                return CT_CONTEXT_TITLE_NOTHING_FOUND;
            }
        }

        if ($this->getBaseContext() == 'page') {
            return $pageTitle;
        }

         if ($this->getBaseContext() == '404') {
            return CT_CONTEXT_TITLE_404;
        }


        if (ct_is_woocommerce_active()) {
            if (is_shop()) {
                return woocommerce_page_title(false);
            } elseif (is_product_category()) {
                return woocommerce_page_title(false);
            } elseif (is_product_tag()) {
                return woocommerce_page_title(false);
            }
        }

        if ($this->getBaseContext() == 'day') {
            if ($this->isSearchSuccess()) {
                return CT_CONTEXT_TITLE_DAILY_ARCHIVES . get_the_date();
            } else {
                return CT_CONTEXT_TITLE_NOTHING_FOUND;
            }
        }

        if ($this->getBaseContext() == 'month') {
            if ($this->isSearchSuccess()) {
                return CT_CONTEXT_TITLE_MONTHLY_ARCHIVES . get_the_date('F Y');
            } else {
                return CT_CONTEXT_TITLE_NOTHING_FOUND;
            }
        }


        if ($this->getBaseContext() == 'year') {
            if ($this->isSearchSuccess()) {
                return CT_CONTEXT_TITLE_YEARLY_ARCHIVES . get_the_date('Y');
            } else {
                return CT_CONTEXT_TITLE_NOTHING_FOUND;
            }
        }

        if ($this->getBaseContext() == 'archive') {
            if ($this->isSearchSuccess()) {
                return CT_CONTEXT_TITLE_ARCHIVES;
            } else {
                return CT_CONTEXT_TITLE_NOTHING_FOUND;
            }
        }

        return $pageTitle;
    }


    /**
     * @return mixed|void
     */
    public function getTitle()
    {
        $showTitle = ct_get_context_option('show_title_row', 1, array(), array('without_namespace' => array('meta'), 'context' => true));
        if ($showTitle
            && $showTitle !== 'no'
            && $showTitle !== '0'
        ) {
            $title = ct_get_context_option('title_row', '', array(), array('without_namespace' => array('meta'), 'context' => true));
            if ($title) {
                return apply_filters('ct_page_title', $title);
            } else {
                if ($this->getBaseContext() =='blog'){
                    return CT_CONTEXT_TITLE_BLOG_DEFAULT;
                }

                if ($this->getBaseContext() =='post'){
                    return CT_CONTEXT_TITLE_BLOG_DEFAULT;
                }
                return apply_filters('ct_page_title', get_the_title());
            }
        } else {
            $title = '';
            return apply_filters('ct_page_title', $title);
        }
    }

}


/**
 * returns curtrent page title
 */
if (!function_exists('ct_get_title')) {

    /**
     * @return mixed|void
     */
    function ct_get_title()
    {
        $obj = new ctContextTitleRowPlugin();
        return $obj->getTitle();
    }
}




/**
 * @return mixed|void
 */
function ct_get_context()
{
    $obj = new ctContextTitleRowPlugin();
    return $obj->getBaseContext();
}
