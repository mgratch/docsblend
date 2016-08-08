<?php

/**
 * Recent posts
 * ver. 2.1
 */
class ctRecentPostsWidgetShortcode extends ctShortcodeQueryable
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Recent posts';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'recent_postswidget';
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
        $recentposts = $this->getCollection($attributes);


        $mainContainerAtts = array(
            'class' => array(
                ($widgetmode == 'true') ? 'media-list' : '',
                $class
            ),
        );


        if ($widgetmode == 'true') {
            $html = '<h5 class="text-uppercase ct-fw-600 ct-u-paddingBottom15 ct-u-borderBottomGrayLighter">' . $title . '</h5>';
            $html .= '<ul class="ct-mediaList list-unstyled ct-u-paddingTop10 ct-u-paddingBottom40">';
            foreach ($recentposts as $p) {
                //Get the excerpt without cutting off the last word
                $str = wordwrap($p->post_content, 90);
                $str = explode("\n", $str);
                $str = $str[0] . '...';

                $imgSrc = ct_get_feature_image_src($p->ID);
                if ($imgSrc) {
                    $imgHTML = '<a href="' . get_permalink($p->ID) . '" title="View Post ' . $p->post_title . ' "><img height="75" width="75" src="' . esc_url(ct_get_feature_image_src($p->ID)) . '" alt="' . esc_attr($title) . '"></a>';
                } else {
                    $imgHTML = '';
                }


                $html .= '
                            <li>
                                ' . $imgHTML . '

                            <div>
                           <a href="' . get_permalink($p->ID) . '" title="View Post ' . $p->post_title . ' "> <p class="ct-fw-600 ct-u-size18">' . $p->post_title . '</p>
                            <p class="ct-mediaList-date">' . get_the_time('F jS, Y', $p->ID) . '</p></a>
                            </div>


                            </li>
                    ';
            }
            $html .= '</ul>';
            return do_shortcode($html);

        } else {

            }

            $html .= '</div></div>';

            return do_shortcode($html);
        }



    /**
     * checks for Easy Gallery images
     * @param $PostID
     * @return array|bool
     */


    /**
     * checks for Easy Gallery images
     * @param $PostID
     * @return array|bool
     */


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
        $items = $this->getAttributesWithQuery(array(
            'title' => array('label' => __('Widget title', 'ct_theme'), 'default' => '', 'type' => 'input'),


            'widgetmode' => array('default' => 'false', 'type' => false),
            'limit' => array('label' => __('limit', 'ct_theme'), 'default' => 10, 'type' => 'input'),

            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input')
        ));


        return $items;
    }
}

new ctRecentPostsWidgetShortcode();