<?php

/**
 * Flex Slider shortcode
 * /**
 * Class ctSliderShortcode
 */
class ctBigSliderShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Big Slider';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'ct_big_slider';
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

    }


    /**
     * @param $id
     * @param $size
     * @return array
     */
    private function getAttachedImages($id, $size)
    {
        $urlArr = array();
        $imageUrl = '';
        $width = 270;
        $height = 160;
        $args = array(
            'post_type' => 'attachment',
            'numberposts' => -1,
            'post_status' => null,
            'post_parent' => $id
        );

        $attachments = get_posts($args);
        if ($attachments) {
            foreach ($attachments as $attach) {
                $image = wp_get_attachment_image_src($attach->ID, $size);

                $imageUrl = $image[0];
                $urlArr[] = $imageUrl;
            }
        }
        return $urlArr;
    }


    /**
     *
     */
    public function getRoundedImageSlideMarkup($Imageid)
    {
        $img = wp_get_attachment_image_src($Imageid, 'featured_image');
        $img = $img[0];

        $html = '
            <li>
                <img src="' . esc_url($img) . '">
            </li>';
        return $html;

    }


    /**
     * Custom type
     * @param $Imageid
     * @return string
     */
    public function getImageSlideMarkup($Imageid)
    {
        //also for masonry blog and portfolio ajax and Simple Slide and Team
        $img = wp_get_attachment_image_src($Imageid, 'featured_image');
        $img = $img[0];


        $html = '
            <li>
                <img src="' . esc_url($img) . '">
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
        $testimonial_auth_surname = isset($custom["testimonial_auth_surmane"][0]) ? $custom["testimonial_auth_surmane"][0] : "";
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

        if ($atts['post_id'] != '' && is_numeric($atts['post_id'])) {
            return $this->getImagesFromEasyGallery($atts['post_id']);
        }

        foreach ($atts as $k => $v) {

            if (self::isStringStartsWith($k, '__select_')) {
                if ($v != 'custom' && $v != 'none') { //select all
                    $idArr = array_merge($idArr, $this->getImagesFromEasyGallery($v));
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


            if (self::isStringStartsWith($k, '__image_')) { //custom select
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


        /*build slider items*/
        $items = '';

        $mainContainerAtts = array(


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
            'data-height' => $height,
        );


        if ($add_shadow == 'yes') {


            $shadow = '<div class="ct-containerAbsolute">
                             <!--<div class="ct-borderLeft"></div>-->
                            <!--<div class="ct-borderRight"></div>-->
                        <div class="ct-flexslider-progress">
                        <div class="ct-flexslider-progressBar" ></div>
                    </div>
                <div class="ct-containerAbsolute-inside"></div>
                 </div>';
        } else {
            $shadow = '';
        }


        switch ($type) {

            case 'small':

                return '

                <section class="flexslider ct-flexslider--mainSlider ct-u-marginBoth0 ct-js-flexslider" data-pauseonaction="false" data-directionnav="true"  data-animations="true" data-height="'.$height.'" data-controlnav="true" data-animationloop="true" data-controlscontainer="ct-containerAbsolute" data-slideshow="true" >
                            ' . $shadow . '

                <ul class="slides">' . do_shortcode($content) . '</ul>

                </section>';

                break;




            case 'full':

                return '
                <section class="ct-mediaSection" data-height="100%">
                    <div class="flexslider ct-flexslider--fw ct-flexslider--controls3 ct-flexslider--mainSlider ct-u-marginBoth0 ct-js-flexslider"
                    data-pauseonaction="false" data-directionnav="true" data-animations="true" data-height="100%"  data-controlnav="true"
                     data-animationloop="true" data-controlscontainer="ct-containerAbsolute" data-slideshow="true">


                <ul class="slides">' . do_shortcode($content) . '</ul>
                <div class="ct-flexslider-progress">
            <div class="ct-flexslider-progressBar"></div>
        </div>

                </div></section>

                ';
                break;

        }


    }


    /**
     * @param $PostID
     * @return array
     */
    public static function getImagesFromEasyGallery($PostID)
    {

        $custom = get_post_custom($PostID);
        $image_gallery = isset($custom["_easy_image_gallery"][0]) ? $custom["_easy_image_gallery"][0] : "";

        $attachments = array_filter(explode(',', $image_gallery));
        $idArr = array();

        foreach ($attachments as $attachment_id) {
            $get_image_id = wp_get_attachment_image_src($attachment_id, 'featured_image');
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
                                            '' => __("none", "ct_theme"),
                                            $p->ID => __("Select All", "ct_theme"),
                                            "custom" => __("Custom select", "ct_theme"),
                                        ),
                                    'default' => 'custom',
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
                                        'default' => $imageID,
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

        $items['type'] = array(
            'label' => __('Type', 'ct_theme'),
            'default' => 'small',
            'type' => 'select',
            'choices' =>
                array(
                    "small" => __("small", "ct_theme"),
                    "full" => __("Full Screen", "ct_theme"),
                ));


        $items['add_shadow'] = array(
            'label' => __('Shadow', 'ct_theme'),
            'default' => 'yes',
            'type' => 'select',
            'choices' =>
                array(
                    "yes" => __("yes", "ct_theme"),
                    "no" => __("no", "ct_theme"),
                ),
            'dependency' => array(
                'element' => 'type',
                'value' => array('small')
            )
        );


        $items['height'] = array(
            'label' => __('height', 'ct_theme'),
            'default' => 650,
            'type' => 'input',
            'help' => __('Height', 'ct_theme')
        );


        $items['itemwidth'] = array(
            'label' => __('Item width', 'ct_theme'),
            'default' => 0,
            'type' => 'input',
            'help' => __('Box-model width of individual carousel items, including horizontal borders and padding.', 'ct_theme')
        );

        $items['itemmargin'] = array(
            'label' => __('Play text', 'ct_theme'),
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


        $items['animationloop'] = array(
            'label' => __("Animation loop", 'ct_theme'),
            'type' => 'checkbox',
            'default' => 'true',
            'value' => 'true',
            'help' => __('will allow sliders to have a seamless infinite loop.', 'ct_theme'),
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


        $items['controlnav'] = array(
            'label' => __("Controlnav", 'ct_theme'),
            'type' => 'checkbox',
            'default' => 'false',
            'value' => 'true',
            'help' => __('Create navigation for paging control of each slide.', 'ct_theme'),
        );

        $items['directionnav'] = array(
            'label' => __("Directionnav", 'ct_theme'),
            'type' => 'checkbox',
            'default' => 'false',
            'value' => 'true',
            'help' => __('Create previous/next arrow navigation.', 'ct_theme'),
        );


        return ($items);
    }

    public function getChildShortcodeInfo()
    {
        return array('name' => 'ct_big_slider_home_item', 'min' => 1, 'max' => 100, 'default_qty' => 3);
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
            'description' => __("Add slider with custom content", 'ct_theme')
        ));
    }

}

new ctBigSliderShortcode();

//#28144
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortcode_ct_big_slider extends WPBakeryShortCodesContainer{}
}