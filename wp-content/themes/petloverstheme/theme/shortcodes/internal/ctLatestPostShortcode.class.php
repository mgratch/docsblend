<?php

/**
 * Flex Slider shortcode
 * /**
 * Class ctSliderShortcode
 */
class ctLatestPostsShortcode extends ctShortcodeQueryable
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Latest Posts';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'ct_latest_posts';
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


        $mainContainerAtts['class'] = array(

        );


        $posts = $this->getCollection(array('limit' => $limit), array('post_type' => $post_type));

        $items = '<h5 class="text-uppercase"><i class="fa fa-dot-circle-o"></i> ' . $header . '</h5>';
        $items .= '<ul>';

        foreach ($posts as $p) {
            $items .= '<li><a href="' . get_permalink($p->ID) . '">' . $p->post_title . '</a></li>';
        }
        $items .= '</ul>';

        return $items;
    }


    /**
     * @return array
     */
    public static function getSupportedPostTypes()
    {
        return array('post', 'portfolio', 'gallery', 'product', 'testimonial');
    }


    /**
     * @return mixed
     */
    public function preGetAttributes()
    {
        $items['post_type'] = array(
            'label' => __('Select post type', 'ct_theme'),
            'type' => 'select',
            'group' => __("Custom gallery", 'ct_theme'),
            'choices' =>
                array(),
            'help' => __('Select post type', 'ct_theme')
        );

        $postTypes = self::getSupportedPostTypes();
        foreach ($postTypes as $postType) {
            $items['post_type']['choices'][$postType] = $postType;
            $postTypeArr[$postType] = $postType;
            $posts = $this->getCollection(array('limit' => 1000), array('post_type' => $postType));
            if (empty($posts)) {
                unset($items['post_type']['choices'][$postType]);
                //$items = array_values($items);
                continue;
            }
        }
        return $items;

    }


    /**
     * Returns config
     * @return null
     *
     *
     */
    public function getAttributes()
    {


        $items = array(
            'header' => array('label' => __('Header', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'limit' => array('label' => __('limit', 'ct_theme'), 'default' => 3, 'type' => 'input', 'help' => __("Number galleries", 'ct_theme')),
        );


        $items = array_merge($items, $this->preGetAttributes());

        return $this->getAttributesWithQuery($items);
    }


}

new ctLatestPostsShortcode();






