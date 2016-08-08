<?php

/**
 * Animate plugin
 * @author alex
 */
class ctUtilityClassPlugin
{


    /**
     * Is someone is using us on this page?
     * @var bool
     */

    protected $active = true;

    /**
     * Animations
     */
    public function __construct()
    {
        add_action('init', array($this, 'onInit'), 9);
    }

    /**
     * Register shortcodes
     */

    public function onInit()
    {

        //add listeners to our shortcodes
        foreach ($this->getCompatibleShortcodes() as $shortcode) {

            ctShortcode::connectInlineAttributeFilter($shortcode, array($this, 'addCustomAttributes'));
            ctShortcode::connectNormalizedAttributesFilter($shortcode, array(
                $this,
                'addCustomNormalizedAttributes'
            ));
        }
    }

    /**
     * Return compatible shortcodes
     * @return array
     */
    protected function getCompatibleShortcodes()
    {

        return apply_filters('ct.utility_class.compatible_shortcodes', array(
            'format',
            'section_header',
            'section',
            'icon'
        ));
    }


    /**
     * Add custom attributes
     *
     * @param array $content
     * @param array $attributes
     *
     * @internal param $css
     * @return string
     */

    public function addCustomAttributes($content, $attributes = array())
    {

        if (isset($attributes['shortcode'])) {
            $obj = $attributes['shortcode'];

            foreach ($this->getAttributesForShortcode($obj) as $k => $v) {
                if (isset($attributes[$k])) {
                    $content['class'][] = $attributes[$k];
                }
            }

            //allow to add additional content
            $content = apply_filters('ct.utility_class.add_custom_attributes.' . $obj->getShortcodeName(), $content, $obj);
            $content = apply_filters('ct.utility_class.add_custom_attributes', $content, $obj);
        }


        return $content;
    }


    /**
     * @param string $name - Shortcode name
     */

    protected function getAttributesForShortcode($shortcode)
    {
        $group = apply_filters('ct.utility_class.group', esc_html__("Styles", 'ct_theme'), $shortcode);

        $attr['ct_u_color'] = array(
            'label' => esc_html__('Colors', 'ct_theme'),
            'default' => 'inherit',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "inherit" => esc_html__("inherit", "ct_theme"),
                    "ct-u-colorPrimary" => esc_html__("primary", "ct_theme"),
                    "ct-u-colorWhite" => esc_html__("white", "ct_theme"),
                    "ct-u-colorLightGray" => esc_html__("light gray", "ct_theme"),
                    "ct-u-colorDarkGray" => esc_html__("dark gray", "ct_theme"),
                    "ct-u-colorDark" => esc_html__("dark", "ct_theme"),
                    "ct-u-colorDarkerGray" => esc_html__("darker gray", "ct_theme"),
                    "ct-u-colorMotive" => esc_html__("motive", "ct_theme"),

                ),
            'help' => esc_html__('Select color for the text', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('icon', 'section_header'),
        );

        $attr['ct_u_size_20'] = array(
            'label' => esc_html__("Font Size 20", 'ct_theme'),
            'type' => 'checkbox',
            'default' => '',
            'value' => 'ct-u-size20',
            'group' => $group,
            'help' => esc_html__('Make the text 20px', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section', 'icon', 'section_header'),
        );

        $attr['ct_u_arapey'] = array(
            'label' => esc_html__("Font family Arapey", 'ct_theme'),
            'type' => 'checkbox',
            'default' => '',
            'value' => 'ct-u-arapey',
            'group' => $group,
            'help' => esc_html__('Use Arapey font for the element', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section', 'icon', 'section_header'),
        );

        $attr['ct_u_underline_hover'] = array(
            'label' => esc_html__("Underline hover", 'ct_theme'),
            'type' => 'checkbox',
            'default' => '',
            'value' => 'ct-u-underline',
            'group' => $group,
            'help' => esc_html__('Underline text on mouse over', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section', 'header', 'icon', 'section_header'),
        );

        $attr['ct_u_text_transform'] = array(
            'label' => esc_html__("Text transform", 'ct_theme'),
            'type' => 'select',
            'default' => '',
            'choices' => array(
                '' => esc_html__('none', 'ct_theme'),
                'text-uppercase' => esc_html__('uppercase', 'ct_theme'),
                'text-lowercase' => esc_html__('lowercase', 'ct_theme'),
            ),
            'group' => $group,
            'help' => esc_html__('Select text transformation type', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section', 'icon', 'section_header'),
        );


        $attr['ct_u_header'] = array(
            'label' => esc_html__('Header', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "h1" => esc_html__("1", "ct_theme"),
                    "h2" => esc_html__("2", "ct_theme"),
                    "h3" => esc_html__("3", "ct_theme"),
                    "h4" => esc_html__("4", "ct_theme"),
                    "h5" => esc_html__("5", "ct_theme"),
                    "h6" => esc_html__("6", "ct_theme"),
                ),
            'help' => esc_html__('Display text as header','ct_theme'),
            'supported_by' => array('format'),
            'not_supported_by' => array(),
        );


        $attr['ct_u_hr'] = array(
            'label' => esc_html__('Line', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-hrLeft" => esc_html__("Left", "ct_theme"),
                    "ct-u-hrRight" => esc_html__("Right", "ct_theme"),
                    "ct-u-hrMid" => esc_html__("Middle", "ct_theme"),
                ),
            'help' => esc_html__('Add a line to the element','ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section', 'icon', 'section_header'),
        );

        $attr['ct_u_padding'] = array(
            'label' => esc_html__('Padding', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-paddingBoth10" => esc_html__("both 10", "ct_theme"),
                    "ct-u-paddingTop10" => esc_html__("top 10", "ct_theme"),
                    "ct-u-paddingBottom10" => esc_html__("bottom 10", "ct_theme"),
                    "ct-u-paddingBoth20" => esc_html__("both 20", "ct_theme"),
                    "ct-u-paddingTop20" => esc_html__("top 20", "ct_theme"),
                    "ct-u-paddingBottom20" => esc_html__("bottom 20", "ct_theme"),
                    "ct-u-paddingBoth30" => esc_html__("both 30", "ct_theme"),
                    "ct-u-paddingTop30" => esc_html__("top 30", "ct_theme"),
                    "ct-u-paddingBottom30" => esc_html__("bottom 30", "ct_theme"),
                    "ct-u-paddingBoth40" => esc_html__("both 40", "ct_theme"),
                    "ct-u-paddingTop40" => esc_html__("top 40", "ct_theme"),
                    "ct-u-paddingBottom40" => esc_html__("bottom 40", "ct_theme"),
                    "ct-u-paddingBoth50" => esc_html__("both 50", "ct_theme"),
                    "ct-u-paddingTop50" => esc_html__("top 50", "ct_theme"),
                    "ct-u-paddingBottom50" => esc_html__("bottom 50", "ct_theme"),
                    "ct-u-paddingBoth60" => esc_html__("both 60", "ct_theme"),
                    "ct-u-paddingTop60" => esc_html__("top 60", "ct_theme"),
                    "ct-u-paddingBottom60" => esc_html__("bottom 60", "ct_theme"),
                    "ct-u-paddingBoth70" => esc_html__("both 70", "ct_theme"),
                    "ct-u-paddingTop70" => esc_html__("top 70", "ct_theme"),
                    "ct-u-paddingBottom70" => esc_html__("bottom 70", "ct_theme"),
                    "ct-u-paddingBoth80" => esc_html__("both 80", "ct_theme"),
                    "ct-u-paddingTop80" => esc_html__("top 80", "ct_theme"),
                    "ct-u-paddingBottom80" => esc_html__("bottom 80", "ct_theme"),
                    "ct-u-paddingBoth90" => esc_html__("both 90", "ct_theme"),
                    "ct-u-paddingTop90" => esc_html__("top 90", "ct_theme"),
                    "ct-u-paddingBottom90" => esc_html__("bottom 90", "ct_theme"),
                    "ct-u-paddingBoth100" => esc_html__("both 100", "ct_theme"),
                    "ct-u-paddingTop100" => esc_html__("top 100", "ct_theme"),
                    "ct-u-paddingBottom100" => esc_html__("bottom 100", "ct_theme"),
                    "ct-u-paddingBoth150" => esc_html__("both 150", "ct_theme"),
                    "ct-u-paddingTop150" => esc_html__("top 150", "ct_theme"),
                    "ct-u-paddingBottom150" => esc_html__("bottom 150", "ct_theme"),
                ),
            'help' => esc_html__('Add paddings to the element','ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('icon'),
        );

        $attr['ct_u_margin'] = array(
            'label' => esc_html__('Margin', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-marginBoth10" => esc_html__("both 10", "ct_theme"),
                    "ct-u-marginTop10" => esc_html__("top 10", "ct_theme"),
                    "ct-u-marginBottom10" => esc_html__("bottom 10", "ct_theme"),
                    "ct-u-marginBoth20" => esc_html__("both 20", "ct_theme"),
                    "ct-u-marginTop20" => esc_html__("top 20", "ct_theme"),
                    "ct-u-marginBottom20" => esc_html__("bottom 20", "ct_theme"),
                    "ct-u-marginBoth30" => esc_html__("both 30", "ct_theme"),
                    "ct-u-marginTop30" => esc_html__("top 30", "ct_theme"),
                    "ct-u-marginBottom30" => esc_html__("bottom 30", "ct_theme"),
                    "ct-u-marginBoth40" => esc_html__("both 40", "ct_theme"),
                    "ct-u-marginTop40" => esc_html__("top 40", "ct_theme"),
                    "ct-u-marginBottom40" => esc_html__("bottom 40", "ct_theme"),
                    "ct-u-paddingBoth50" => esc_html__("both 50", "ct_theme"),
                    "ct-u-marginTop50" => esc_html__("top 50", "ct_theme"),
                    "ct-u-marginBottom50" => esc_html__("bottom50", "ct_theme"),
                    "ct-u-marginTop60" => esc_html__("top 60", "ct_theme"),
                    "ct-u-marginBottom60" => esc_html__("bottom 60", "ct_theme"),
                    "ct-u-marginBoth70" => esc_html__("both 70", "ct_theme"),
                    "ct-u-marginTop70" => esc_html__("top 70", "ct_theme"),
                    "ct-u-marginBottom70" => esc_html__("bottom 70", "ct_theme"),
                    "ct-u-marginBoth80" => esc_html__("both 80", "ct_theme"),
                    "ct-u-marginTop80" => esc_html__("top 80", "ct_theme"),
                    "ct-u-marginBottom80" => esc_html__("bottom 80", "ct_theme"),
                    "ct-u-marginBoth90" => esc_html__("both 90", "ct_theme"),
                    "ct-u-marginTop90" => esc_html__("top 90", "ct_theme"),
                    "ct-u-marginBottom90" => esc_html__("bottom 90", "ct_theme"),
                    "ct-u-marginBoth100" => esc_html__("both 100", "ct_theme"),
                    "ct-u-marginTop100" => esc_html__("top 100", "ct_theme"),
                    "ct-u-marginBottom100" => esc_html__("bottom 100", "ct_theme"),
                    "ct-u-marginBoth150" => esc_html__("both 150", "ct_theme"),
                    "ct-u-marginTop150" => esc_html__("top 150", "ct_theme"),
                    "ct-u-marginBottom150" => esc_html__("bottom 150", "ct_theme"),
                ),
            'help' => esc_html__('Add margins to the element', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('icon'),
        );


        $attr['ct_u_font_weight'] = array(
            'label' => esc_html__('Font weight', 'ct_theme'),
            'default' => 'ct-fw-600',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("None", "ct_theme"),
                    "ct-fw-300" => esc_html__("weight 300", "ct_theme"),
                    "ct-fw-400" => esc_html__("weight 400", "ct_theme"),
                    "ct-fw-500" => esc_html__("weight 500", "ct_theme"),
                    "ct-fw-600" => esc_html__("weight 600", "ct_theme"),
                    "ct-fw-700" => esc_html__("weight 700", "ct_theme"),
                    "ct-fw-800" => esc_html__("weight 800", "ct_theme"),
                ),
            'help' => esc_html__('Choose font weight for the text','ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section', 'icon', 'section_header'),
        );


        $attr['ct_u_font_style'] = array(
            'label' => esc_html__('Font style', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("normal", "ct_theme"),
                    "ct-fs-i" => esc_html__("italic", "ct_theme"),
                ),
            'help' => esc_html__('Choose font style for the text','ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section', 'icon', 'section_header'),
        );

        $attr['ct_u_display'] = array(
            'label' => esc_html__('Display method', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-displayTable" => esc_html__("table", "ct_theme"),
                    "ct-u-displayTableVertical" => esc_html__("table vertical", "ct_theme"),
                    "ct-u-displayTableRow" => esc_html__("table row", "ct_theme"),
                    "ct-u-displayTableCell" => esc_html__("table cell", "ct_theme"),
                ),
            'help' => esc_html__('CSS <em>display</em> property', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section', 'icon', 'section_header'),
        );
// styles - nazwa zkaładki

        $attr['ct_u_bg_color'] = array(
            'label' => esc_html__('Background Colors', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-backgroundWhite" => esc_html__("white", "ct_theme"),
                    "ct-u-backgroundGray" => esc_html__("gray", "ct_theme"),
                    "ct-u-backgroundGray2" => esc_html__("gray 2", "ct_theme"),
                    "ct-u-backgroundDarkGray" => esc_html__("dark gray", "ct_theme"),
                    "ct-u-backgroundDarkGray2" => esc_html__("dark gray 2", "ct_theme"),
                    "ct-u-backgroundDarkGray3" => esc_html__("dark gray 3", "ct_theme"),
                    "ct-u-backgroundMotive" => esc_html__("motive", "ct_theme"),
                    "ct-u-backgroundDarkMotive" => esc_html__("dark motive", "ct_theme"),
                ),
            'help' => esc_html__('Select background color', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('icon', 'section_header'),
        );

        $attr['ct_u_border'] = array(
            'label' => esc_html__('Borders', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-borderAll" => esc_html__("border all", "ct_theme"),
                    "ct-u-borderBoth" => esc_html__("border both", "ct_theme"),
                    "ct-u-borderTop" => esc_html__("border top", "ct_theme"),
                    "ct-u-borderBottom" => esc_html__("border bottom", "ct_theme"),
                    "ct-u-borderMotiveBoth" => esc_html__("motive both", "ct_theme"),
                    "ct-u-borderMotiveTop" => esc_html__("motive top", "ct_theme"),
                    "ct-u-borderMotiveBottom" => esc_html__("motive bottom", "ct_theme"),
                ),
            'help' => esc_html__('Select border type', 'ct_theme'),
            'supported_by' => array('section'),
            'not_supported_by' => array('section_header'),
        );

        $attr['ct_u_triangle'] = array(
            'label' => esc_html__('Triangles', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-triangleTopLeft" => esc_html__("top left", "ct_theme"),
                    "ct-u-triangleTopRight" => esc_html__("top right", "ct_theme"),
                    "ct-u-triangleBottomLeft" => esc_html__("bottom left", "ct_theme"),
                    "ct-u-triangleBottomRight" => esc_html__("bottom right", "ct_theme"),
                ),
            'help' => esc_html__('Add highlight triangle element', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section', 'section_header'),
        );

        $attr['ct_u_diagonal1'] = array(
            'label' => esc_html__('Top Diagonal', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-diagonalTopLeft" => esc_html__("Left Side", "ct_theme"),
                    "ct-u-diagonalTopRight" => esc_html__("Right Side", "ct_theme"),
                ),
            'help' => esc_html__('Select top diagonal type', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section_header'),
        );

        $attr['ct_u_diagonal2'] = array(
            'label' => esc_html__('Bottom Diagonal', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-diagonalBottomLeft" => esc_html__("Left Side", "ct_theme"),
                    "ct-u-diagonalBottomRight" => esc_html__("Right Side", "ct_theme"),
                ),
            'help' => esc_html__('Select bottom diagonal type', 'ct_theme'),
            'supported_by' => array(),
            'not_supported_by' => array('section_header'),
        );

        $attr['ct_u_shadow'] = array(
            'label' => esc_html__('Shadows', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => esc_html__("none", "ct_theme"),
                    "ct-u-shadowBottom--type1" => esc_html__("bottom type 1", "ct_theme"),
                    "ct-u-shadowBottom--type2" => esc_html__("bottom type 2", "ct_theme"),
                    "ct-u-shadowBottom--type3" => esc_html__("bottom type 3", "ct_theme"),
                    "ct-u-shadowTop--type1" => esc_html__("top type 1", "ct_theme"),
                    "ct-u-shadowTop--type2" => esc_html__("top type 2", "ct_theme"),
                    "ct-u-shadowTop--type3" => esc_html__("top type 3", "ct_theme"),
                ),
            'help' => esc_html__('Select shadow type', 'ct_theme'),
            'supported_by' => array(), //jak to mamy to nie sprawdzamy innych
            'not_supported_by' => array('icon', 'section_header'), //jak oba puste to wszedzie
        );


        $attr = apply_filters('ct.utility_class.attr',  $attr, $group);



        return $this->filterAttributes($attr, $shortcode);

    }

    /**
     * @param array $attr
     * @param ctShortcode $shortcode
     *
     * @return array
     */


    protected function filterAttributes($attr = array(), $shortcode)
    {

        $shortcodeName = is_string($shortcode) ? $shortcode : $shortcode->getShortcodeName();
        $newAttr = array();

        foreach ($attr as $k => $v) {
            if (isset($v['supported_by']) && is_array($v['supported_by']) && !empty($v['supported_by'])) {
                foreach ($v['supported_by'] as $k2 => $v2) {
                    if ($v2 == $shortcodeName) {
                        $newAttr[$k] = $attr[$k];
                        continue(2);
                    } else {
                        continue;
                    }
                }

                continue;
            }
            if (isset($v['not_supported_by']) && is_array($v['not_supported_by'])) {

                foreach ($v['not_supported_by'] as $k2 => $v2) {
                    if ($v2 == $shortcodeName) {
                        continue(2);
                    }
                }
            }
            $newAttr[$k] = $attr[$k];
        }

        return $newAttr;
    }


    /**
     * Normalized attributes
     *
     * @param $attr
     * @param ctShortcode $shortcode
     * todo: dark motive checkbox yes/no jako pierwsza opcja
     */

    public function addCustomNormalizedAttributes($attr, $shortcode)
    {
        $utilityAttrs = $this->getAttributesForShortcode($shortcode);

        return array_merge($attr, $utilityAttrs);
    }


}

new ctUtilityClassPlugin();