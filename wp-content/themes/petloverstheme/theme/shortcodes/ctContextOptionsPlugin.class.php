<?php

/**
 * Class ctGetOptionHelper
 */
define ('CUSTOMIZER_NAMESPACE','ct_customizer');
class ctContextOptionsPlugin
{


    /**
     *
     */
    public function __construct()
    {


    }


    /**
     * @var
     */
    protected static $uniqueId;

    /**
     * @var string
     */


    /**
     * @return string
     */
    public function getContext()
    {
        //is blog?
        if (get_the_id(get_option('page_for_posts')) == get_the_id() && !is_single() && !is_page()) {
            return 'posts_index_';
        }
        //is page?
        if (is_page()) {
            return 'pages_';
        }

        //is single blog?
        if (is_single() && get_post_type() == 'post') {
            return 'posts_';
        }

        //is single?
        if (is_single()) {
            return get_post_type() . '_';
        }

        return '';

    }


    /**
     * @param $key
     *
     * @return string
     */
    protected function get_shortcode_value($key, $shortcodeAtts = array())
    {
        if (!array_key_exists($key, $shortcodeAtts)) {
            return self::$uniqueId;
        }
        $value = $shortcodeAtts[$key];

        return $value;
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function get_meta_value($key)
    {
        $custom = get_post_custom(get_the_id());
        return isset($custom[$key][0]) ? $custom[$key][0] : self::$uniqueId;
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function get_global_value($key)
    {
        if (!ct_has_option($key)) {
            return self::$uniqueId;
        }
        $value = ct_get_option($key, '');

        return $value;
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function get_global_customizer_value($key)
    {

        $value = get_theme_mod(CUSTOMIZER_NAMESPACE.'_'.$key);

        if ($value) {
            return $value;
        }else{
            return self::$uniqueId;
        }

    }


    /**
     * @param $option_id
     * @param $shortcodeAtts
     * @param array $args
     * @param string $default
     *
     * @return mixed|string
     */
    public function ctGetOption($option_id, $default = '', $shortcodeAtts = array(), $args = array())
    {
        self::$uniqueId = uniqid();

        $defaults = array(
            'priority' => array('shortcode', 'meta', 'global_customizer','global' ),
            'without_namespace' => array('shortcode', 'meta', 'global', 'global_customizer'),
            'context' => 'auto',
            'global_detection' => true,//per field
            'global_detection_id' => 'global',//per field
        );
        $args = array_merge($defaults, $args);


        if (!isset($option_id) || !is_string($option_id)) {
            return '';
        }

        //set namespace (context)
        if ($args['context'] == 'auto' || $args['context'] == true) {
            $namespace = $this->getContext();
        } else {
            $namespace = strval($args['context']);
        }


        $value = '';
        //loop in priority array (data sources)
        foreach ($args['priority'] as $key) {

            $method = 'get_' . $key . '_value';//prepare method name by options type

            //if option method exist try to get option
            if (method_exists($this, $method)) {

                //create namespace if necessary
                if (is_array(($args['without_namespace'])) && in_array($key, $args['without_namespace'])) {
                    $value = call_user_func(array($this, 'get_' . $key . '_value'), $option_id, $shortcodeAtts);
                } else {
                    $value = call_user_func(array(
                        $this,
                        'get_' . $key . '_value'
                    ), $namespace . $option_id, $shortcodeAtts);
                }


                //check global depending
                if (($args['global_detection'] && $value == $args['global_detection_id'])

                ) {
                    //force global IF value = global id OR global mode for instance is enabled (check in contructor)
                    //try to get global value
                    if (is_array(($args['without_namespace'])) && in_array('global', $args['without_namespace'])) {
                        $value = $this->get_global_value($option_id, $shortcodeAtts);
                    } else {
                        $value = $this->get_global_value($namespace . $option_id, $shortcodeAtts);
                    }

                    // uniqueID = option does not exist
                    if ($value != self::$uniqueId && $value != '') {
                        return $value == null ? $default : $value;
                    }
                } else {
                    //no global force
                    if ($value != self::$uniqueId && $value != '') {
                        return $value == null ? $default : $value;
                    }
                }


            }
            continue;
        }

        if ($value == self::$uniqueId) {
            return $default;
        }

        return $value == null ? $default : $value;
    }
}

/**
 * Get option from context
 * @param $field
 * @param string $default
 * @param array $atts
 * @param array $args
 */
if (!function_exists('ct_get_context_option')) {
    function ct_get_context_option($field, $default = '', $atts = array(), $args = array())
    {
        //@todo nowa klasa etc.
        $obj = new ctContextOptionsPlugin();
        return $obj->ctGetOption($field, $default, $atts, $args);
    }
}
