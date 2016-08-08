<?php

/**
 * Created by PhpStorm.
 * User: Patryk
 * ver: 1.0
 * Date: 2015-01-26
 * Time: 15:19
 */
class ctSecurityPlugin
{
    /**
     *
     * @param $attribute
     * @param $value
     * @param bool $url
     * @param null $default
     * @return string
     */
    public static function escAttr($attribute, $value, $url = false, $default = null)
    {
        if (!isset($attribute) || empty($attribute)) {
            return '';
        } else {

            if (!isset($value) || empty($value)) {
                if (!isset($default) || empty($default)) {
                    return '';
                } else {
                    if ($url == true) {
                        return $attribute . '=' . esc_attr(htmlspecialchars($default)) . '';
                    } else {
                        return $attribute . '=' . esc_attr($default) . '';
                    }


                }
            } else {
                if ($url == true) {
                    return $attribute . '=' . esc_attr(htmlspecialchars($value)) . '';
                } else {
                    return $attribute . '=' . esc_attr($value) . '';
                }

            }
        }

    }


    /**
     * @param array $atts
     * @return string
     */
    public static function escAttrs($atts = array())
    {

        if (!is_array($atts) && empty($atts)) {
            return '';
        } else {
            $counter = 0;
            $attsHtml = '';


            foreach ($atts as $key => $value) {
                if (!isset($value['attr']) || empty($value['attr'])) {
                    continue;
                } else {

                    $attribute = $value['attr'];
                }
                if (!isset($value['val']) || empty($value['val'])) {

                    if (!isset($value['default']) || empty($value['default'])) {

                        continue;
                    } else {
                        if (isset($value['url']) && $value['url'] == true) {
                            $default = esc_url($value['default']);
                        } else {
                            $default = esc_attr($value['default']);
                        }
                        $value = null;
                    }
                } else {
                    if (isset($value['url']) && $value['url'] == true) {
                        $value = esc_url($value['val']);
                    } else {
                        if ($value['attr'] == 'class') {
                            $value = self::sanitizeClass($value['val']);
                        }else{
                            $value = esc_attr($value['val']);
                        }

                    }
                }

                if (!isset($attribute) || empty($attribute)) {
                    return '';
                } else {
                    if (!isset($value) || empty($value)) {
                        if (!isset($default) || empty($default)) {
                            continue;
                        } else {

                            $attsHtml .= ($counter == 0 ? ' ' : '') . $attribute . '="' . $default . '"' . ($counter < count($atts) ? ' ' : '');
                            $counter++;
                        }
                    } else {

                        $attsHtml .= ($counter == 0 ? ' ' : '') . $attribute . '="' . $value . '"' . ($counter < count($atts) ? ' ' : '');
                        $counter++;
                    }
                }
            }

            return $attsHtml;
        }
    }


    /**
     *
     * @param string $src
     * @param string $alt
     * @param string $blankSrc
     * @param string $class
     * @return string
     */
    public static function getImage($src = '', $alt = '', $blankSrc = '', $class = '')
    {
        if (!(is_string($src) && !empty($src))) {
            if (!(is_string($blankSrc) && !empty($blankSrc))) {
                return '';
            } else {
                $src = $blankSrc;
            }
        }

        //image always needs alt
        if ($alt ==''){
            $alt = esc_html__('Image Alternative Text','ct_theme');
        }

        $attrs = array(
            array('attr' => 'src', 'val' => $src, 'url' => true),
            array('attr' => 'alt', 'val' => $alt),
            array('attr' => 'class', 'val' => self::sanitizeClass($class)),
        );

        return '<img ' . self::escAttrs($attrs) . '>';
    }


    /**
     *
     *
     * @param string $class
     * @return string
     */
    public static function sanitizeClass($class='')
    {
        if (!is_array($class)) {
            $classArr = explode(' ', $class);
        } else {
            $classArr = $class;
        }

        if (is_array($classArr) && !empty($classArr)) {
            $tmp = '';
            foreach ($classArr as $k => $v) {
                $tmp .= sanitize_html_class($v) . ' ';
            }
            $tmp = trim($tmp);
        } else {
            return '';
        }
        return $tmp;
    }

    /**
     *
     *
     * @param array $data
     * @return string
     *
     */
    public static function getImageLink($data = array())
    {
        $imgSrc = isset($data['img_src']) ? $data['img_src'] : '';
        $imgAlt = isset($data['img_alt']) ? $data['img_alt'] : '';
        $imgAltSrc = isset($data['img_alternative_src']) ? $data['img_alternative_src'] : '';
        $imgClass = isset($data['img_class']) ? $data['img_class'] : '';
        $linkURL = isset($data['link_url']) ? $data['link_url'] : '';
        $linkClass = isset($data['link_class']) ? $data['link_class'] : '';
        $linkCustomAttrs = isset($data['link_attrs']) ? $data['link_attrs'] : '';

        //image always needs alt
        if ($imgAlt ==''){
            $imgAlt = esc_html__('Image Alternative Text','ct_theme');
        }


        $outputImg = self::getImage($imgSrc, $imgAlt, $imgAltSrc, $imgClass);
        if ($outputImg === '') {
            return '';
        }


        if ($linkURL !== '') {


            $linkAttrs = array(
                array('attr' => 'href', 'val' => $linkURL, 'url' => true),
                array('attr' => 'class', 'val' => self::sanitizeClass($linkClass)),
            );


            if (is_array($linkCustomAttrs) && !empty($linkCustomAttrs)) {
                foreach ($linkCustomAttrs as $key) {
                    $linkAttrs[] = $key;
                }
            }


            $output = '<a ' . self::escAttrs($linkAttrs) . '>';
            $output .= $outputImg;
            $output .= '</a>';
        } else {

            return $outputImg;
        }
        return $output;
    }

}


////////////////////////////////////////////////////////////


if (!function_exists('ct_esc_attr')) {
    /**
     * @param $attribute
     * @param $value
     * @param bool $url
     * @param null $default
     * @return string
     */
    function ct_esc_attr($attribute, $value, $url = false, $default = null)
    {
        return ctSecurityPlugin::escAttr($attribute, $value, $url, $default);
    }
}


if (!function_exists('ct_esc_attrs')) {
    /**
     * @param array $atts
     * @return string
     */
    function ct_esc_attrs($data = array())
    {
        return ctSecurityPlugin::escAttrs($data);
    }
}

if (!function_exists('ct_sanitize_html_class')) {
    /**
     * @param null $class
     * @return string
     */
    function ct_sanitize_html_class($class = null)
    {
        return ctSecurityPlugin::sanitizeClass($class);
    }
}


if (!function_exists('ct_get_image')) {

    /**
     * @param string $src
     * @param string $alt
     * @param string $blankSrc
     * @param string $class
     * @return string
     */
    function ct_get_image($src = '', $alt = '', $blankSrc = '', $class = '')
    {
        return ctSecurityPlugin::getImage($src, $alt, $blankSrc, $class);
    }
}


if (!function_exists('ct_get_image_link')) {

    /**
     * @param array $data
     * @return string
     */
    function ct_get_image_link($data = array())
    {
        return ctSecurityPlugin::getImageLink($data);
    }
}


if (!function_exists('ct_sanitize_shortcode_content')) {
    /**
     * @param $content
     * @return mixed
     */
    function ct_sanitize_shortcode_content($content)
    {
        $content = str_replace('[', '&#91;', $content);
        return str_replace(']', '&#93;', $content);
    }
}



