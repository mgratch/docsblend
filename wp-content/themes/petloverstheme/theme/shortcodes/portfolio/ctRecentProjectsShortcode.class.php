<?php

/**
 * Draws works
 */
class ctRecentProjectsShortcode extends ctShortcodeQueryable
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Recent Projects';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'recent_projects';
    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {
        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);

        extract($attributes);


        if(strpos($title, '*') !== false){
            $title2 = explode('*', $title);

            $print = ''.$title2[0].' <span> '.$title2[1].' </span>';
        }else{
            $print =' '.$title.'';
        }


        $recentposts = $this->getCollection($attributes, array('post_type' => 'portfolio'));



        //elements
        $elements = '';
        foreach ($recentposts as $p) {
            if (has_post_thumbnail($p->ID)) {
                $cats = ct_get_categories_string($p->ID,',', $taxonomy = 'portfolio_category');
                $imgsrc = ct_get_feature_image_src($p->ID, 'thumbnail');
                $elements .= '<div class="col-sm-3 col-xs-6">


                            <div class="ct-flip-container" >
                                <div class="ct-flipper">
                                    <div class="ct-front"><img src="' . esc_url($imgsrc) . '" alt="'.esc_attr($p->post_title).'"></div>
                                    <div class="ct-back motive-bg"><h5>'.esc_html($p->post_title).'</h5></div>
                                </div>
                            </div>


                </div>';
            } else {
                continue;
            }
        }


        if($link=='yes'){
            $a='  <a href="'.get_post_type_archive_link('portfolio').'">';
            $b=' </a>';

        }else{
            $a='';
            $b='';
        }

        $headerHtml = (' <div class="col-md-4 ct-u-paddingBoth50">
                <div class="ct-pageSectionHeader"><h3>'.$print.'</h3>
                  '.$a.'
                        <h4 class="ct-fw-300 ct-u-motiveLight ct-u-displayInline">'.$subtitle.'</h4>
                        <div class="ct-ListDiamond"><i class="fa fa-chevron-right"></i></div>
                    '.$b.'
                </div>
            </div>') ;



        $html =
            '<div class="row ct-collections">'.


            $headerHtml.'

        <div class="col-md-8 ct-u-paddingBoth30">
                <div class="ct-flip-wrapper">'  . $elements . '  </div>
            </div></div>';

        return do_shortcode($html);

    }


    /**
     * creates class name for the category
     * @param $cat
     * @return string
     */
    protected function getCatFilterClass($cat)
    {
        return strtolower(str_replace(' ', '-', $cat->slug));
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
            'limit' => array('label' => __('limit', 'ct_theme'), 'default' => 4, 'type' => 'input', 'help' => __("Number of portfolio elements", 'ct_theme')),
            'title' => array('label' => __('title (add * if you want black and motive font color)', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'subtitle' => array('label' => __('subtitle', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'link'            => array(
                'label'   => __( 'Add link', 'ct_theme' ),
                'default' => '',
                'type'    => 'select',
                'choices' => array(
                    'yes'      => __( 'yes', 'ct_theme' ),
                    'no' => __( 'no', 'ct_theme' )
                ),
            ),

            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        ));

        if (isset($atts['cat'])) {
            unset($atts['cat']);
        }
        return $atts;
    }
}

new ctRecentProjectsShortcode();