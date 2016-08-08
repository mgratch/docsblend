<?php

/**
 * Recent posts
 */
class ctPortfolioShortcode extends ctShortcodeQueryable
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Portfolio';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'portfolio';
    }



    /**
     * Add styles
     */
//    public function enqueueHeadScripts() {
    public function enqueueFooterScripts() {

            wp_register_script('isotope', CT_THEME_ASSETS . '/js/portfolio/jquery.isotope.min.js', array('jquery'), null, true);
            wp_enqueue_script('isotope');

            wp_register_script('imagesloaded', CT_THEME_ASSETS . '/js/portfolio/imagesloaded.js', array('jquery'), null, true);
            wp_enqueue_script('imagesloaded');

            wp_register_script('infinitescroll', CT_THEME_ASSETS . '/js/portfolio/infinitescroll.min.js', array('jquery'), null, true);
            wp_enqueue_script('infinitescroll');

            wp_register_script('init-portfolio', CT_THEME_ASSETS . '/js/portfolio/init.js', array('jquery'), null, true);
            wp_enqueue_script('init-portfolio');

            wp_register_script('init-portfolio-ajax', CT_THEME_ASSETS . '/js/ct-portfolioAjax/init.js', array('jquery'), null, true);
            wp_enqueue_script('init-portfolio-ajax');

            wp_register_script('mp', CT_THEME_ASSETS . '/js/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), null, true);
            wp_enqueue_script('mp');

            wp_register_script('ct-init-mp', CT_THEME_ASSETS . '/js/magnific-popup/init.js', array('jquery'), null, true);
            wp_enqueue_script('ct-init-mp');


    }
    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */
    public function handle($atts, $content = null)
    {
        add_action('wp_footer',array($this,'enqueueFooterScripts'));

        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
        extract($attributes);

        ob_start();
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'portfolio',
            'posts_per_page' => $limit,
            'ct_columns'=>$columns,
            'ct_shortcode_mode'=>true,
            'orderby' => (isset($orderby)) ? $orderby : 'date',
            'order' => (isset($order)) ? $order : 'DESC',
        );

        //#28876
         if (isset($id) && !empty($id)) {

             $id = str_replace(' ', '', $id);
             $ids = explode(',', $id);
             $args['post__in'] = $ids;

        }

        if (isset($notids) && !empty($notids)) {
            $notids = str_replace(' ', '', $notids);
             $ids = explode(',', $notids);
             $args['post__not_in'] = $ids;
        }

        if (isset($slug) && !empty($slug)) {
            $slug= str_replace(' ', '', $slug);
             $slugs = explode(',', $slug);
             $args['post_name__in'] = $slugs;
        }

        if (isset($post_parent) && !empty($post_parent)) {
            $post_parent= str_replace(' ', '', $post_parent);
             $ids = explode(',', $post_parent);
             $args['post_parent__in'] = $ids;
        }

        if (isset($cat) && !empty($cat)) {
            $cat= str_replace(' ', '', $cat);
            $in = array();
            $not_in = array();
             $ids = explode(',', $cat);

            foreach($ids as $id) {
                if (substr($id, 0, 1) === '-'){
                    $id = str_replace('-', '', $id);
                    $not_in[] = $id;
                } else {
                    $in[] = $id;
                }
            }

            if(!empty($in)) {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'portfolio_category',
                        'field'    => 'id',
                        'terms'    => $in,
                    ),
                );
            } elseif(!empty($not_in)) {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'portfolio_category',
                        'field'    => 'id',
                        'terms'    => $not_in,
                        'operator' =>'NOT IN'
                    ),
                );
            }

        }

        if (isset($tag) && !empty($tag)) {
            $tag= str_replace(' ', '', $tag);
            $in = array();
            $not_in = array();
             $slugs = explode(',', $tag);

            foreach($slugs as $slug) {
                if (substr($slug, 0, 1) === '-'){
                    $slug = preg_replace('/^(-)/', '', $slug);
                    $not_in[] = $slug;
                } else {
                    $in[] = $slug;
                }
            }

            if(!empty($in)) {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'post_tag',
                        'field'    => 'slug',
                        'terms'    => $in,
                    ),
                );
            } elseif(!empty($not_in)) {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'post_tag',
                        'field'    => 'slug',
                        'terms'    => $not_in,
                        'operator' =>'NOT IN'
                    ),
                );
            }
        }

        if (isset($cat_name) && !empty($cat_name)) {
            $args['portfolio_category'] = $cat_name;
        }

        if (isset($s) && !empty($s)) {
            $args['s'] = $s;
        }

        if (isset($skip) && !empty($skip)) {
            $args['offset'] = $skip;
        }

        query_posts( $args );
        get_template_part('templates/portfolio/content-portfolio', 'masonry');
        $var = ob_get_contents();
        wp_reset_query();
        ob_end_clean();
        return
            '<div class="ct-sectionHeader ">
                <h2>'.$title.'</h2>
                <h3>'.$subtitle.'</h3>
            </div>'.
            $var;

    }

    /**
     * Shortcode type
     * @return string
     */
    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_SELF_CLOSING;
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        $atts = $this->getAttributesWithQuery(array(

            'columns' => array(
                'label' => __('Columns number', 'ct_theme'),
                'default' => 4,
                'type' => 'select',
                'choices' =>
                    array(
                        3 => "3",
                        4 => "4",
                        5 => "5",
                    ),
                'help' => __('Select number of columns', 'ct_theme')
            ),


            'title' => array('label' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'subtitle' => array('label' => __('SubTitle', 'ct_theme'), 'default' => '', 'type' => 'input'),
       //     'index_button_text' => array('label' => __('Blog index button text', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'widgetmode' => array('default' => 'false', 'type' => false),
            'limit' => array('label' => __('limit', 'ct_theme'), 'default' => 10, 'type' => 'input'),
        ));
        return $atts;
    }
}

new ctPortfolioShortcode();