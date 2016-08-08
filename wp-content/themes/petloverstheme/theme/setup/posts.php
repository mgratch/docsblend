<?php


if (!function_exists('ct_theme_setup_posts')) {
    /**
     * Set basic formats etc
     */

    function ct_theme_setup_posts()
    {
        //custom theme formats
        add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

        //add size for featured image
        add_image_size('featured_image', 735, 475, true);
        add_image_size('featured_image_small', 335, 284, true);
        add_image_size('portfolio_thumb', 260, 190, true);
        add_image_size('post_format_gallery', 688, 503, true);
        add_image_size('slider_custom_big', 1115, 578, true);
    }
}
add_action('after_setup_theme', 'ct_theme_setup_posts');


if (!function_exists('ct_get_post_short_month_name')) {
    /**
     * @return string
     */
    function ct_get_post_short_month_name()
    {
        $time = mktime(0, 0, 0, get_the_time('m'));
        $short_month_name = strftime("%b", $time);

        return $short_month_name;
    }
}


if (!function_exists('ct_get_post_day')) {
    /**
     * @return int|string
     */
    function ct_get_post_day()
    {
        $day = get_the_time('d');

        return $day;
    }
}


/**
 * returns video html for video format post
 */
if (!function_exists('ct_post_video')) {

    /**
     * @param $postid
     * @param int $width
     * @param int $height
     * @return string
     */
    function ct_post_video($postid, $width = 500, $height = 300)
    {
        $m4v = get_post_meta($postid, 'videoM4V', true);
        $ogv = get_post_meta($postid, 'videoOGV', true);
        $direct = get_post_meta($postid, 'videoDirect', true);
        return (do_shortcode('[video width="' . $width . '" height="' . $height . '" link="' . $direct . '" m4v="' . $m4v . '" ogv="' . $ogv . '"]'));
    }
}


/**
 * returns audio html for audio format post
 */
if (!function_exists('ct_post_audio')) {
    /**
     * @param $postid
     * @param int $width
     * @param int $height
     */
    function ct_post_audio($postid, $width = 500, $height = 300)
    {
        $mp3 = get_post_meta($postid, 'audioMP3', true);
        $ogg = get_post_meta($postid, 'audioOGA', true);
        $poster = get_post_meta($postid, 'audioPoster', true);
        $audioPosterHeight = get_post_meta($postid, 'audioPosterHeight', true);

        // Calc $height for small images; large will return same value
        //$height = $height * $width / 580;
        return do_shortcode('[audio height="' . $height . '" width="' . $width . '" mp3="' . $mp3 . '" ogg="' . $ogg . '" poster="' . $poster . '" posterheight="' . $audioPosterHeight . '"]');
    }
}





if (!function_exists('get_section_class')) {
    /**
     * @param string $type
     *
     * @return string
     */
    function get_section_class($type = 'blog')
    {
        $classes = array();
        switch ($type) {
            case 'blog-index':
            default:
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom50';
                break;

            case 'portfolio-standard':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom50';
                break;

            case 'portfolio-ajax':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom50';
                break;

            case 'faq':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom50';
                break;

            case 'post-single':
                $clases[] = 'ct-u-paddingBoth100';
                $clases[] = 'ct-u-diagonalTopLeft';
                $clases[] = 'ct-u-diagonalBottomRight';
                $clases[] = ct_get_context_option('general_flavour') == 'ct--darkMotive' ? 'ct-u-backgroundDarkGray' : '';
                break;


            case 'single-portfolio-standard':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom50';
                break;

            case 'single-portfolio-magnificPopup':
            case 'single-portfolio-ajax':
                $clases[] = 'ct-gallerySingleAjax';
                break;


            case '404':
                $clases[] = 'ct-errorText';
                $clases[] = 'text-center';
                $clases[] = 'text-uppercase';
                $clases[] = 'ct-u-paddingBottom100';
                break;

            case 'author':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom150';
                $clases[] = 'ct-u-backgroundGray2';
                break;

            case 'category':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom150';
                $clases[] = 'ct-u-backgroundGray2';
                break;

            case 'image':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom150';
                $clases[] = 'ct-u-backgroundGray2';
                break;

            case 'page-left':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom150';
                $clases[] = 'ct-u-backgroundGray2';
                break;

            case 'page-right':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom150';
                $clases[] = 'ct-u-backgroundGray2';
                break;

            case 'search':
                $clases[] = 'ct-u-paddingTop100';
                $clases[] = 'ct-u-paddingBottom150';
                $clases[] = 'ct-u-backgroundGray2';
                break;

        }

        return implode(' ', $classes);
    }
}


if (!function_exists('ct_update_post_counter')) {
    /**
     * @param string $id
     */
    function ct_update_post_counter($id = '')
    {
        /*update view count meta*/
        $view_count = get_post_meta($id, 'post_view_count', true);
        if ($view_count == '') {
            $view_count = 0;
            delete_post_meta($id, 'post_view_count');
            add_post_meta($id, 'post_view_count', 0);
        } else {
            $view_count++;
            update_post_meta($id, 'post_view_count', $view_count);
        }
    }
}


if (!function_exists('ct_get_blog_item_title')) {
    /**
     * @return string
     */
    function ct_get_blog_item_title()
    {
        $postTitle = get_the_title();
        $custom = get_post_custom(get_the_ID());


        if (!isset($custom['show_title'][0])) {
            $custom['show_title'][0] = 'global';
        }

        if (isset($custom['show_title'][0])) {
            if (ct_get_context_option("posts_single_show_title", 1) && $custom['show_title'][0] == 'global') {
                return $postTitle;

            } else {
                return '';
            }
        }

        if (isset($custom['show_title'][0]) && $custom['show_title'][0] == 'yes') {
            return $postTitle;
        }

        return '';
    }
}


if (!function_exists('ct_new_excerpt_more')) {
    /**
     * @param $more
     *
     * @return string
     */
    function ct_new_excerpt_more($more)
    {
        return '';
    }
}
add_filter('ct_excerpt_more', 'new_excerpt_more');


/* Custom Excerpt length */
if (!function_exists('ct_new_excerpt_length')) {
    function ct_new_excerpt_length()
    {
        return (ct_get_context_option("posts_show_index_as", 'content') == 'content') ? apply_filters('ct_excerpt_length_content', 60)
            : apply_filters('ct_excerpt_length', 20);
    }
}
add_filter('excerpt_length', 'ct_new_excerpt_length', 999);


if (!function_exists('ct_comments_count')) {
    function ct_comments_count()
    {
        comments_number(__('No Comments', 'ct_theme'), '1 ' . __('Comment', 'ct_theme'), '% ' . __('Comments', 'ct_theme'));
    }
}


if (!function_exists('ct_reviews_count')) {
    function ct_reviews_count()
    {
        comments_number(__('No Reviews', 'ct_theme'), '1 ' . __('Review', 'ct_theme'), '% ' . __('Reviews', 'ct_theme'));
    }
}



if (!function_exists('ct_get_excerpt_by_id')) {
    /**
     *
     * @param $post_id
     * @param int $lenght
     * @param string $after_text
     *
     * @return string
     */
    function ct_get_excerpt_by_id($post_id, $lenght = 10, $after_text = '&#8230;')
    {
        $the_post = get_post($post_id);

        $the_excerpt = $the_post->post_excerpt;
        if (!$the_excerpt) {
            $the_excerpt = $the_post->post_content;
        }
        $excerpt_length = $lenght;
        $the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
        $words = explode(' ', $the_excerpt, $excerpt_length + 1);

        if (count($words) > $excerpt_length) {
            array_pop($words);
            array_push($words, $after_text);
            $the_excerpt = implode(' ', $words);
        }

        $the_excerpt = $the_excerpt ;

        return $the_excerpt;
    }
}


if (!function_exists('ct_get_next_post')) {
    /**
     * @return array|null
     */
    function ct_get_next_post($imageSize = 'featured_image')
    {
        $next_post = get_next_post();
        if (is_object($next_post)) {
            return array(
                'image' => ct_get_feature_image_src($next_post->ID, $imageSize),
                'title' => $next_post->post_title,
                'excerpt' => ct_get_excerpt_by_id($next_post->ID, 6, '')
            );
        }
        return '';
    }
}


if (!function_exists('ct_get_previous_post')) {
    /**
     * @return array|null
     */
    function ct_get_previous_post($imageSize = 'featured_image')
    {
        $previous_post = get_previous_post();

        if (is_object($previous_post)) {
            return array(
                'image' => ct_get_feature_image_src($previous_post->ID, $imageSize),
                'title' => $previous_post->post_title,
                'excerpt' => ct_get_excerpt_by_id($previous_post->ID, 6, '')
            );
        }
        return '';
    }
}

