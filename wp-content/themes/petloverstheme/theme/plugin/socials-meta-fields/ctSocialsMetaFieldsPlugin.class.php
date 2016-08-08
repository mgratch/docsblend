<?php

/**
 * Class ctSocialsMetaFields
 */
class ctSocialsMetaFields
{

    /**
     * @return array
     */
    public static function getFieldsArray()
    {
        $socials = self::getSocials();
        $socFields = array();
        foreach ($socials as $key => $value) {
            if (!empty($key) && isset($_POST[$key])) {
                $socFields[] = $key;
            }
        }

        return $socFields;

    }

    /**
     * @return array
     */
    public static function getSocials()
    {
        return array(
            'bitbucket' => array(
                'class' => 'fa fa-bitbucket'
            ),
            'dribbble' => array(
                'class' => 'fa fa-dribbble'
            ),
            'dropbox' => array(
                'class' => 'fa fa-dropbox'
            ),
            'facebook' => array(
                'class' => 'fa fa-facebook'
            ),
            'flickr' => array(
                'class' => 'fa fa-flickr'
            ),
            'foursquare' => array(
                'class' => 'fa fa-foursquare'
            ),
            'github' => array(
                'class' => 'fa fa-github'
            ),
            'gittip' => array(
                'class' => 'fa fa-gittip'
            ),
            'google' => array(
                'class' => 'fa fa-google-plus'
            ),
            'instagram' => array(
                'class' => 'fa fa-instagram'
            ),
            'linkedin' => array(
                'class' => 'fa fa-linkedin'
            ),
            'pinterest' => array(
                'class' => 'fa fa-pinterest'
            ),
            'renren' => array(
                'class' => 'fa fa-renren'
            ),
            'rss' => array(
                'class' => 'fa fa-rss'
            ),
            'skype' => array(
                'class' => 'fa fa-skype'
            ),
            'stack_exchange' => array(
                'class' => 'fa fa-stack-exchange'
            ),
            'stack_overflow' => array(
                'class' => 'fa fa-stack-overflow'
            ),
            'tumblr' => array(
                'class' => 'fa fa-tumblr'
            ),
            'twitter' => array(
                'class' => 'fa fa-twitter'
            ),
            'vimeo' => array(
                'class' => 'fa fa-vimeo-square'
            ),
            'vkontakte' => array(
                'class' => 'fa fa-vk'
            ),
            'weibo' => array(
                'class' => 'fa fa-weibo'
            ),
            'xing' => array(
                'class' => 'fa fa-xing'
            ),
            'youtube' => array(
                'class' => 'fa fa-youtube-play'
            ),
            'email' => array(
                'class' => 'fa fa-envelope-o'
            )
        );
    }


    /**
     * @param $custom
     * @return string
     */
    public function getTheFields($custom)
    {
        $socials = self::getSocials();
        $socFields[] = array();
        //static params - no escaping required
        $html = '<table>';
        foreach ($socials as $key => $value) {
            $fieldValue = isset($custom[$key][0]) ? $custom[$key][0] : "";
            $html .= '
    <tr>
        <td>
            <i class="' . $value['class'] . '"></i> <label for="' . $key . '">' . $key . '</label>
        </td>
        <td>
            <input id="' . $key . '" class="regular-text" name="' . $key . '" value="' . $fieldValue . '"/>
        </td>
    </tr>
    ';
        }
        $html .= '</table>';
        return $html;
    }

    /**
     * @param $custom
     * @param string $namespace
     * @param array $additionalParams
     * @return string
     */
    public function getTheShortcodeParams($custom,$namespace='',$additionalParams = array())
    {
        if ($namespace){
            $namespace.='_';
        }

        $socials = self::getSocials();
        $socFields[] = array();
        $output='';
        foreach ($socials as $key => $value) {

            $fieldValue = isset($custom[$key][0]) ? $custom[$key][0] : '';
            if ($fieldValue!==''){
                $output.=$namespace.$key.'="'.$fieldValue.'" ';
            }
        }

        if (is_array($additionalParams)  && !empty($additionalParams)){
            foreach ($additionalParams as $key => $value) {
                if ($value!==''){
                    $output.=$namespace.$key.'="'.$value.'" ';
                }
            }
        }

        return rtrim($output);
    }

    /**
     * @param array $atts
     * @param null $post_id
     * @return string
     */
    public function getTheSocialsShortcode($atts = array(), $post_id = null)
    {

        if (empty($post_id_) && is_single()) {
            $post_id = get_the_id();
        }
        $custom = get_post_custom($post_id);
        $socials = self::getSocials();


        $shortcode = '[socials ';
        foreach ($socials as $key => $value) {
            if (isset($custom[$key][0]) && !empty($custom[$key][0])) {

                $socValue = $custom[$key][0];
            } else {
                continue;
            }
            $shortcode .= $key . '="' . $socValue . '" ';
        }

//generate shortcode attributes
        $attsStr = '';
        if (is_array($atts) && !empty($atts)) {
            foreach ($atts as $key => $value) {
                if (empty($value)) continue;
                $attsStr .= $key . '="' . $value . '" ';
            }
        }
        $shortcode .= $attsStr . ']';
        return $shortcode;
    }

    /**
     * @param array $atts
     * @param null $post_id
     * @return string
     */
    public function getTheSocialsHtml($atts = array(), $post_id = null)
    {

        return do_shortcode($this->getTheSocialsShortcode($atts, $post_id));
    }


}


/**
 * @param null $post_id
 * @param array $atts
 * @return string
 */
function ct_get_meta_socials($post_id = null, $atts = array()){
    $obj = new ctSocialsMetaFields();
    return $obj->getTheSocialsHtml($atts, $post_id);
}



/**
 * returns shortcode params from post custom.
 * You can use namespace parameter if you call releated socials shortcode
 *
 * @param $postCustom
 * @param $namespace
 * @return string
 */
function ct_get_socials_sh_params($postCustom, $namespace='',$additionalParams = array()){
    $obj = new ctSocialsMetaFields();
    return $obj->getTheShortcodeParams($postCustom, $namespace,$additionalParams);
}