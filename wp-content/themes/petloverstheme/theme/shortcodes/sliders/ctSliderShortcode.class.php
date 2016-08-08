<?php

/**
 * Flex Slider shortcode
 * /**
 * Class ctSliderShortcode
 */
class ctSliderShortcode extends ctShortcodeQueryable implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Slider';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'ct_slider';
    }

    /**
     *
     */
    public function enqueueScripts()
    {


        wp_register_script('ct-easing', CT_THEME_ASSETS . '/js/jquery.easing.1.3.js', array('jquery'), false, true);
        wp_enqueue_script('ct-easing');

        wp_register_script('ct-flex-slider', CT_THEME_ASSETS . '/js/flexslider/jquery.flexslider-min.js', array('jquery'), false, true);
        wp_enqueue_script('ct-flex-slider');

        wp_register_script('ct-flexslider_init', CT_THEME_ASSETS . '/js/flexslider/init.js', array('ct-flex-slider'), false, true);
        wp_enqueue_script('ct-flexslider_init');


//joao

        wp_register_script('ct-owl_init', CT_THEME_ASSETS . '/js/owl/init.js', array('jquery'), false, true);
        wp_enqueue_script('ct-owl_init');

        wp_register_script('ct-carousel_init', CT_THEME_ASSETS . '/js/owl/owl.carousel.min.js', array('jquery'), false, true);
        wp_enqueue_script('ct-carousel_init');


    }

    /**
     * Custom type
     * @param $Imageid
     * @return string
     */
    public function getImageSlideMarkup($Imageid, $size = 'featured_image')
    {
        //also for masonry blog and portfolio ajax and Simple Slide and Team
        $img = wp_get_attachment_image_src($Imageid, 'featured_image');
        $img = $img[0];


        $html = '
            <li>
                <img src="' . esc_url($img) . '" alt="">
            </li>';
        return $html;
    }

    //joao

    public function getImageSlideMarkup2($Imageid, $size = 'featured_image')
    {
        //also for masonry blog and portfolio ajax and Simple Slide and Team
        $img = wp_get_attachment_image_src($Imageid, 'featured_image');
        $img = $img[0];


        $html = '<div>
                <img src="' . esc_url($img) . '" alt="">
            </div>';
        return $html;
    }



    public function getImageSlideMarkup3($Imageid, $size = 'featured_image')
    {
        //also for masonry blog and portfolio ajax and Simple Slide and Team
        $img = wp_get_attachment_image_src($Imageid, 'featured_image');
        $img = $img[0];


        $html = '


 <li>
                <a href="' . esc_url($img) . '" class="ct-js-magnificPopupImage">
                    <div class="ct-imageOverlay-container">
                        <div class="ct-imageButton"></div>
                        <img class="ct-u-motiveGrayLighter--bg" src="' . esc_url($img) . '" alt="">
                    </div>
                </a>

            </li>

          ';
        return $html;
    }



    /**
     *
     */
    public function getTestimonialHslideMarkup($data = array())
    {
        $testimonial_auth_name = isset($data[0]['custom']["testimonial_auth_name"][0]) ? $data[0]['custom']["testimonial_auth_name"][0] : "";
        $testimonial_auth_surname = isset($data[0]['custom']["testimonial_auth_surname"][0]) ? $data[0]['custom']["testimonial_auth_surname"][0] : "";
        $testimonial_auth_desc = isset($data[0]['custom']["testimonial_auth_desc"][0]) ? $data[0]['custom']["testimonial_auth_desc"][0] : "";

        $testimonial_auth_name_2 = isset($data[1]['custom']["testimonial_auth_name"][0]) ? $data[1]['custom']["testimonial_auth_name"][0] : "";
        $testimonial_auth_surname_2 = isset($data[1]['custom']["testimonial_auth_surname"][0]) ? $data[1]['custom']["testimonial_auth_surname"][0] : "";
        $testimonial_auth_desc_2 = isset($data[1]['custom']["testimonial_auth_desc"][0]) ? $data[1]['custom']["testimonial_auth_desc"][0] : "";

        $content = $data[0]['content'];
        $content2 = $data[1]['content'];

        return '
                            <li>
                                <div class="col-sm-6">
                                    <blockquote class="ct-blockquote ct-blockquote--secondary">
                                        <cite class="h3"><span class="ct-fw-300">' . $testimonial_auth_name . '</span> <span class="ct-fw-600">' . $testimonial_auth_surname . '</span></cite><br>
                                        <span class="h6 text-uppercase ct-fw-600">' . $testimonial_auth_desc . '</span>
                                        <br>
                                        <br>
                                            <span class="h4 ct-fs-i ct-fw-300 ct-u-arapey">
                                            ' . $content . '
                                            </span>
                                    </blockquote>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <blockquote class="ct-blockquote ct-blockquote--secondary">
                                        <cite class="h3"><span class="ct-fw-300">' . $testimonial_auth_name_2 . '</span> <span class="ct-fw-600">' . $testimonial_auth_surname_2 . '</span></cite><br>
                                        <span class="h6 text-uppercase ct-fw-600">' . $testimonial_auth_desc_2 . '</span>
                                        <br>
                                        <br>
                                            <span class="h4 ct-fs-i ct-fw-300 ct-u-arapey">
                                            ' . $content2 . '
                                            </span>
                                    </blockquote>
                                </div>
                            </li>
        ';
    }

    /**
     * @param array $custom
     * @param $content
     * @return string
     */
    public function getTestimonialVslideMarkup($custom = array(), $content)
    {
        //gets 2 quotes in parameter
        $testimonial_auth_name = isset($custom["testimonial_auth_name"][0]) ? $custom["testimonial_auth_name"][0] : "";
        $testimonial_auth_surname = isset($custom["testimonial_auth_surname"][0]) ? $custom["testimonial_auth_surname"][0] : "";
        $testimonial_auth_desc = isset($custom["testimonial_auth_desc"][0]) ? $custom["testimonial_auth_desc"][0] : "";
        return '
                            <li>
                                <blockquote class="ct-blockquote ct-blockquote--default">
                                    <div class="col-sm-5">
                                        <div class="text-right">
                                            <cite class="h3"><span class="ct-fw-300">' . $testimonial_auth_name . '</span> <span class="ct-u-colorMotive">' . $testimonial_auth_surname . '</span></cite><br>
                                            <span class="h6 text-uppercase">' . $testimonial_auth_desc . '</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <span class="h4 ct-fs-i ct-fw-300 ct-u-arapey">
                                        ' . $content . '
                                        </span>
                                    </div>
                                    <div class="clearfix"></div>
                                </blockquote>
                            </li>
            ';
    }


    //////////// joao

    public function getTeamslideMarkup($custom = array(), $content, $id)
    {

        //gets 2 quotes in parameter
        $team_position = isset($custom["team_position"][0]) ? $custom["team_position"][0] : "";
        $team_surname = isset($custom["team_surname"][0]) ? $custom["team_surname"][0] : "";
        $team_name = isset($custom["team_name"][0]) ? $custom["team_name"][0] : "";
        $description = isset($custom["description"][0]) ? $custom["description"][0] : "";
        $small_description = isset($custom["small_description"][0]) ? $custom["small_description"][0] : "";
        $link = get_permalink($id);


        $imgsrc = ct_get_feature_image_src($id, 'featured_image');
        $itemwidth='';
        //  $image =

        return '

            <li class="ct-u-backgroundWhite ct-teamMember" style="width: '.$itemwidth.'; float: left; display: block;">
                    <a href="'.$link.'">
                        <img src="' . esc_url($imgsrc) . '" alt="' . $team_name . ' ' . $team_surname . '">
                        <div class="ct-teamMember--bg ct-u-paddingBoth20">
                            <p class="text-uppercase text-center ct-fw-600">' . $team_name . '  ' . $team_surname . '</p>
                            <p class="ct-fw-400 text-center">' . $team_position . '</p>
                        </div>
                        <div class="ct-u-motiveDark">
                            <p class="text-center ct-u-paddingTop15 ct-u-paddingBottom60">' . $small_description . '</p>
                            <div class="ct-curlPlus-wrapper">
                                <div class="ct-curlPlus ct-curlPlus--topleft"></div>
                                <div class="ct-curlPlus ct-curlPlus--bottomright"></div>
                                <span>+</span>
                            </div>
                        </div>
                    </a>
                </li>
            ';
    }


    /**
     * @param $str
     * @param $needle
     * @return bool
     */
    private static function isStringStartsWith($str, $needle)
    {
        return substr($str, 0, strlen($needle)) === $needle;
    }

    /**
     * @param $atts
     * @return array
     */
    private function getImagesFromAtts($atts)
    {
        $idArr = array();
        if (isset($atts['post_id']) && $atts['post_id'] != '' && is_numeric($atts['post_id'])) {
            return $this->getImagesFromEasyGallery($atts['post_id'], $atts['image_size']);
        }
        foreach ($atts as $k => $v) {

            if (self::isStringStartsWith($k, '__select_')) {
                if ($v != 'custom' && $v != 'none') { //select all
                    $idArr = array_merge($idArr, $this->getImagesFromEasyGallery($v, $atts['image_size']));
                } else {
                    continue;
                }
            } else {
                continue;
            }
        }
        if (!empty($idArr)) {
            return $idArr;
        }


        $idArr = array();
        foreach ($atts as $k => $v) {
            if (self::isStringStartsWith($k, '__image_') && is_numeric($v)) { //custom select
                $idArr[] = $v;
            } else {
                continue;
            }
        }


        return $idArr;
    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {
        //$data = $this->getCollection($attributes, array('post_type' => $post_type));
        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
        extract($attributes);
        $id = ($id == '') ? 'slider' . rand(100, 1000) : $id;

        /*build slider items*/
        $items = '';


        $mainContainerAtts = array(

            'data-height' => $height,
            'id' => $id,

            'data-animations' => $animation,
            'data-directionnav' => $directionnav,
            'data-animationloop' => $animationloop,
            'data-slideshow' => $slideshow,
            'data-pauseonaction' => $pauseonaction,
            'data-controlnav' => $controlnav,
            'data-itemwidth' => $itemwidth,
            'data-itemmargin' => $itemmargin,
            'data-minitems' => $minitems,
            'data-maxitems' => $maxitems,
            'data-move' => $move,
            'data-controlscontainer' => $controlscontainer,

        );

        $mainContainerAtts['class'] = array(
            'flexslider',
            $arrow_type,
        );


        //arrow type
        // controler vertical/horizontal
        //control white/dark

        switch ($type) {

            /******************************************************************************/


            case 'custom':
                $mainContainerAtts['class'][] = 'flexslider';
                $mainContainerAtts['class'][] = 'ct-js-flexslider';
                $itemsHtml = '';
                $images = $this->getImagesFromAtts($attributes);
                //var_dump($atts);

                //var_dump($images);exit();
                if ($images) {
                    foreach ($images as $imageID) {
                        $itemsHtml .= $this->getImageSlideMarkup($imageID, $attributes['image_size']);
                    }
                } else {
                    return '';
                }
                return do_shortcode('
                <div' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                <ul class="slides">
                ' . $itemsHtml . '
                </ul>
                </div>
                ');

                break;


//joao
            case 'custom2':
                $itemsHtml = '';
                $images = $this->getImagesFromAtts($attributes);
                //var_dump($atts);

                //var_dump($images);exit();
                if ($images) {
                    foreach ($images as $imageID) {
                        $itemsHtml .= $this->getImageSlideMarkup2($imageID, $attributes['image_size']);
                    }
                } else {
                    return '';
                }
                return do_shortcode('
                <div class="owl-carousel ct-owlThumbnails ct-u-paddingTop10">
                ' . $itemsHtml . '
                </div>
                ');

                break;


            /******************************************************************************/
            case 'testimonial_vertical':
                if (!post_type_exists('testimonial')) {
                    return '';
                }
                //modifiers
                $mainContainerAtts['data-smoothheight'] = 'true';
                $mainContainerAtts['class'][] = 'flexslider';
                $mainContainerAtts['class'][] = 'ct-js-flexslider';
                $mainContainerAtts = array(

                    'data-animations' => $animation,
                    'data-directionnav' => $directionnav,
                    'data-animationloop' => $animationloop,
                    'data-slideshow' => $slideshow,
                    'data-pauseonaction' => $pauseonaction,
                    'data-controlnav' => $controlnav,
                    'data-itemwidth' => $itemwidth,
                    'data-itemmargin' => $itemmargin,
                    'data-minitems' => $minitems,
                    'data-maxitems' => $maxitems,
                    'data-move' => $move,
                    'data-controlscontainer' => $controlscontainer,);

                $itemsHtml = '';
                $posts = $this->getCollection(array(), array('post_type' => 'testimonial'));
                if ($posts) {
                    foreach ($posts as $p) {
                        $custom = get_post_custom($p->ID);
                        $itemsHtml .= $this->getTestimonialVslideMarkup(get_post_custom($p->ID), $p->post_content);
                    }
                    return '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                        <ul class="slides">' . $itemsHtml . '</ul></div>';
                } else {
                    return '';
                }
                break;


            /******************************************************************************/
            case 'testimonial_horizontal':
                if (!post_type_exists('testimonial')) {
                    return '';
                }
                //modifiers
                $mainContainerAtts['class'][] = 'flexslider';


                $itemsHtml = '';
                $posts = $this->getCollection(array(), array('post_type' => 'testimonial'));
                if ($posts) {
                    $cache = array();
                    $count = 0;
                    $count2 = 0;
                    foreach ($posts as $p) {
                        $cache[$count2]['custom'] = get_post_custom($p->ID);
                        $cache[$count2]['content'] = $p->post_content;
                        $count2++;
                        //get 2 testimonials for horizontal slider type
                        if ($count++ % 2 == 1) {
                            $itemsHtml .= $this->getTestimonialHslideMarkup($cache);
                            unset($cache);
                            $cache = array();
                            $count2 = 0;
                        }
                    }
                    return '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                        <ul class="slides">' . $itemsHtml . '</ul></div>';
                } else {
                    return '';
                }
                break;


            /******************************************************************************/
            case 'team':


                if (!post_type_exists('team')) {
                    return '';
                }
                //modifiers

                $mainContainerAtts['class'][] = 'flexslider ct-flexslider--arrowType2 ct-js-flexslider ct-flexslider--margin25 ct-flexslider-js-noMargin';

                $mainContainerAtts = array(
                    'class' => 'flexslider ' . $arrow_type . ' ct-js-flexslider ct-flexslider--margin25 ct-flexslider-js-noMargin',
                    'data-animations' => $animation,
                    'data-directionnav' => "true",
                    'data-animationloop' => "false",
                    'data-slideshow' => "false",
                    'data-pauseonaction' => $pauseonaction,
                    'data-controlnav' => "false",
                    'data-itemwidth' => "267",
                    'data-itemmargin' => "25",
                    'data-minitems' => $minitems,
                    'data-maxitems' => "4",
                    'data-move' => "1",
                    'data-controlscontainer' => $controlscontainer,
                );

                $itemsHtml = '';
                $posts = $this->getCollection(array(), array('post_type' => 'team'));
                if ($posts) {
                    foreach ($posts as $p) {
                        $cache['custom'] = get_post_custom($p->ID);
                        $cache['content'] = $p->post_content;

                        $itemsHtml .= $this->getTeamslideMarkup(get_post_custom($p->ID), $p->post_content, $p->ID);
                    }
                    return '

                    <div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                     <h4 class="ct-fw-600 ct-u-paddingBottom30 text-uppercase ct-u-size24 ct-u-marginRight80">'.$title.'</h4>
                        <ul class="slides">' . $itemsHtml . '</ul></div>';
                } else {
                    return '';
                }
                break;
            case 'easy_gallery':


                //modifiers

                $mainContainerAtts['class'][] = 'flexslider ct-flexslider--arrowType2 ct-js-flexslider ct-flexslider--margin25 ct-flexslider-col4';

                $mainContainerAtts = array(
                    'class' => 'flexslider ' . $arrow_type . ' ct-js-flexslider ct-flexslider--margin25 ct-flexslider-js-noMargin',
                    'data-animations' => $animation,
                    'data-directionnav' => "true",
                    'data-animationloop' => "false",
                    'data-slideshow' => "false",
                    'data-pauseonaction' => $pauseonaction,
                    'data-controlnav' => "false",
                    'data-itemwidth' => "267",
                    'data-itemmargin' => "25",
                    'data-minitems' => $minitems,
                    'data-maxitems' => "4",
                    'data-move' => "1",
                    'data-controlscontainer' => $controlscontainer,
                );

                $itemsHtml = '';
                $images = $this->getImagesFromAtts($attributes);
                //var_dump($atts);

                //var_dump($images);exit();
                if ($images) {
                    foreach ($images as $imageID) {
                        $itemsHtml .= $this->getImageSlideMarkup3($imageID, $attributes['image_size']);
                    }
                } else {
                    return '';
                }


                return do_shortcode('

                    <div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                     <h4 class="ct-fw-600 ct-u-paddingBottom30 text-uppercase ct-u-size24 ct-u-marginRight80">'.$title.'</h4>
                        <ul class="slides">' . $itemsHtml . '</ul></div>');



                break;

            /******************************************************************************/


        }


    }


    /**
     * @param $PostID
     * @return array
     */
    public static function getImagesFromEasyGallery($PostID, $size = 'featured_image')
    {


        $custom = get_post_custom($PostID);
        $image_gallery = isset($custom["_easy_image_gallery"][0]) ? $custom["_easy_image_gallery"][0] : "";

        $attachments = array_filter(explode(',', $image_gallery));
        $idArr = array();

        foreach ($attachments as $attachment_id) {
            $get_image_id = wp_get_attachment_image_src($attachment_id, $size);
            if (!empty($get_image_id)) {
                $idArr[] = $attachment_id;
            }
        }
        return $idArr;
    }

    /**
     * checks for Easy Gallery images
     * @param $PostID
     * @return array|bool
     */
    public static function hasPostEasyGallery($PostID)
    {
        if (is_array(get_post_meta($PostID, '_easy_image_gallery', true))) {
            return false;
        } else {
            $custom = get_post_custom($PostID);
            $image_gallery = isset($custom["_easy_image_gallery"][0]) ? $custom["_easy_image_gallery"][0] : "";

            if (!empty($image_gallery)) {
                $attachments = explode(',', $image_gallery);

                if (!empty($attachments)) {
                    return $attachments;
                } else {
                    return false;
                }
            }

        }
    }


    /**
     * @return array
     */
    public static function getImageSizes()
    {
        $imageSizeArr = array();
        foreach (get_intermediate_image_sizes() as $size_name => $size_attrs) {

            $imageSizeArr[$size_attrs] = $size_attrs;
        }

        return $imageSizeArr;
    }

    /**
     * @return array
     */
    public static function getSupportedPostTypes()
    {
        return array('post', 'portfolio', 'gallery', 'product', 'testimonial', 'team');
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
                continue;
            } else {
                $items['post_type_' . $postType] = array(
                    'label' => $postType,
                    'type' => 'select',
                    'group' => __("Custom gallery", 'ct_theme'),
                    'choices' =>
                        array(),
                    'help' => __('Select post', 'ct_theme'),
                    'dependency' => array(
                        'element' => 'post_type',
                        'value' => array($postType)
                    )
                );

                $noImages = true;
                foreach ($posts as $p) {
                    if (is_object($p)) {
                        if (is_object($p) && self::hasPostEasyGallery($p->ID)) {
                            //$items['post_id'] = array('value' => $p->ID, 'type' => false, 'default' => $p->ID);
                            $items['post_type_' . $postType]['choices']['post' . $p->ID] = $p->post_title;
                            $images = self::getImagesFromEasyGallery($p->ID);
                            if (!empty($images)) {
                                $noImages = false;
                                $items['__select_' . $p->ID] = array(
                                    'label' => __("Show images from " . $p->post_title, 'ct_theme'),
                                    'type' => 'select',
                                    'group' => __("Custom gallery", 'ct_theme'),
                                    'choices' =>
                                        array(
                                            'none' => __("none", "ct_theme"),
                                            $p->ID => __("Select All", "ct_theme"),
                                            "custom" => __("Custom select", "ct_theme"),
                                        ),
                                    'default' => 'none',
                                    'help' => __('Use all images', 'ct_theme'),
                                    'dependency' => array(
                                        'element' => 'post_type_' . $postType,
                                        'value' => array('post' . $p->ID)
                                    )
                                );
                                foreach ($images as $k => $imageID) {
                                    $img = wp_get_attachment_image_src($imageID, 'featured_image');
                                    $img = $img[0];

                                    $items['__image_' . $imageID] = array(
                                        //'label' => sprintf(__('Image %d', 'ct_theme'), $imageID),
                                        'label' => false,

                                        'type' => 'checkbox',
                                        'default' => 'none',
                                        'group' => __("Custom gallery", 'ct_theme'),
                                        'value' => $imageID,
                                        'help' => '<img class="ct_vc_thumb" src="' . esc_url($img) . '">',
                                        'dependency' => array(
                                            'element' => 'post_type_' . $postType,
                                            'value' => array('post' . $p->ID)
                                        )
                                    );
                                }
                            }
                        }
                    } else {
                        continue;
                    }
                }


                if ($noImages == true) {
                    unset($items['post_type']['choices'][$postType]);
                }
            }
        }
//        var_dump($items);    exit;
        return $items;

    }
    /**
     * Returns config
     * @return null
     *
     *
     */
    public function getAttributes(){
        $items['type'] = array(
            'label' => __('Slider type', 'ct_theme'),
            'default' => 'with_content',
            'type' => 'select',
            'choices' =>
                array(
                    "gallery" => __("gallery", "ct_theme"),


                    //  "testimonial_horizontal" => __("testimonial horizontal", "ct_theme"),
                    //  "testimonial_vertical" => __("testimonial vertical", "ct_theme"),


                    "custom" => __("custom", "ct_theme"),
                    "custom2" => __("custom2", "ct_theme"),
                    "sldier" => __("Slider", "ct_theme"),
                    "team" => __("Team", "ct_theme"),
                    "logos" => __("logos", "ct_theme"),
                    "easy_gallery"=> __("easy gallerry", "ct_theme"),

                ),
            'help' => __('Select slider type', 'ct_theme')
        );


        $items['arrow_type'] = array(
            'label' => __('Arrow type', 'ct_theme'),
            'default' => 'ct-flexslider--arrowType1',
            'type' => 'select',
            'choices' =>
                array(
                    "ct-flexslider--arrowType1" => __("type 1", "ct_theme"),
                    "ct-flexslider--arrowType2" => __("type 2", "ct_theme"),
                    "ct-flexslider--arrowType3" => __("type 3", "ct_theme"),
                ),
            'help' => __('Select arrow type', 'ct_theme')
        );

        $items['title'] = array('label' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input',
            'dependency' => array(
                'element' => 'type',
                'value' => array('team','easy_gallery')
            )
        );

        $items['post_id'] = array('label' => __('Post id', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Post ID", 'ct_theme'));

        $items['id'] = array('label' => __('Slider id', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("html id attribute", 'ct_theme'));

        $items['image_size'] = array('label' => __('Select registered image size', 'ct_theme'), 'default' => 'featured_image', 'type' => 'select', 'choices' => self::getImageSizes());

        $items['limit'] = array('label' => __('Limit', 'ct_theme'), 'default' => '50', 'type' => 'input');

        $items['height'] = array('label' => __('Height', 'ct_theme'), 'default' => '475px', 'type' => 'input');

        $items['class'] = array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme'));


        $items['animation'] = array(
            'label' => __('Animation type', 'ct_theme'),
            'default' => 'slide',
            'type' => 'select',
            'choices' =>
                array(
                    "fade" => __("fade", "ct_theme"),
                    "Slide" => __("slide", "ct_theme"),
                ),
            'help' => __('Controls the animation type', 'ct_theme')
        );

        $items['directionnav'] = array(
            'label' => __("Directionnav", 'ct_theme'),
            'type' => 'checkbox',
            'default' => 'false',
            'value' => 'true',
            'help' => __('Create previous/next arrow navigation.', 'ct_theme'),
        );


        $items['controlnav'] = array(
            'label' => __("Controlnav", 'ct_theme'),
            'type' => 'checkbox',
            'default' => 'false',
            'value' => 'true',
            'help' => __('Create navigation for paging control of each slide.', 'ct_theme'),
        );

        $items['animationloop'] = array(
            'label' => __("Animation loop", 'ct_theme'),
            'type' => 'checkbox',
            'default' => 'false',
            'value' => 'true',
            'help' => __('will allow sliders to have a seamless infinite loop.', 'ct_theme'),
        );

        $items['itemwidth'] = array(
            'label' => __('Item width', 'ct_theme'),
            'default' => 0,
            'type' => 'input',
            'help' => __('Box-model width of individual carousel items, including horizontal borders and padding.', 'ct_theme')
        );

        $items['itemmargin'] = array(
            'label' => __('Item Margin', 'ct_theme'),
            'default' => '0',
            'type' => 'input',
            'help' => __('Margin between carousel items.', 'ct_theme')
        );

        $items['minitems'] = array(
            'label' => __('Minimum items', 'ct_theme'),
            'default' => '0',
            'type' => 'input',
            'help' => __('Minimum number of carousel items that should be visible.', 'ct_theme')
        );

        $items['maxitems'] = array(
            'label' => __('Maximum items', 'ct_theme'),
            'default' => '0',
            'type' => 'input',
            'help' => __('Maximum number of carousel items that should be visible.', 'ct_theme')
        );

        $items['move'] = array(
            'label' => __('Move', 'ct_theme'),
            'default' => '0',
            'type' => 'input',
            'help' => __('Number of carousel items that should move on animation.', 'ct_theme')
        );

        $items['controlscontainer'] = array(
            'label' => __('Controls container', 'ct_theme'),
            'default' => '',
            'type' => 'input',
            'help' => __('Container the navigation elements should be appended to.', 'ct_theme')
        );


        $items['slideshow'] = array(
            'label' => __("Slideshow", 'ct_theme'),
            'type' => 'checkbox',
            'default' => 'true',
            'value' => 'true',
            'help' => __('allows the slider to have automatic animation.', 'ct_theme'),
        );


        $items['pauseonaction'] = array(
            'label' => __("Pause on action", 'ct_theme'),
            'type' => 'checkbox',
            'default' => 'true',
            'value' => 'true',
            'help' => __('Pause the slideshow when interacting with control elements.', 'ct_theme'),
        );

        $items = array_merge($items, $this->preGetAttributes());

        return $this->getAttributesWithQuery($items);
    }


    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-picture-o',
            'container' => true,
            'description' => __("Add slider with testimonials, gallery or custom images", 'ct_theme')
        ));
    }

}

new ctSliderShortcode();

//#28144
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortcode_ct_slider extends WPBakeryShortCodesContainer{}
}