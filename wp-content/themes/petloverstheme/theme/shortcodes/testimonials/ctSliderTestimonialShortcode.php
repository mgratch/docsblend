<?php

/**
 * Big Tabs shortcode
 */
class ctSliderTestimonialShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Slider Testimonial';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'slider_testimonial';
    }


    public function enqueueScripts()
    {
        wp_register_script('ct-tabs', CT_THEME_ASSETS . '/js/ct/tabs.js', array('jquery'), false, true);
        wp_enqueue_script('ct-tabs');


        wp_register_script('owl-carousel', CT_THEME_ASSETS . '/js/owl/init.js', array('jquery'), false, true);
        wp_enqueue_script('owl-carousel');

        wp_register_script('owl-carousel', CT_THEME_ASSETS . '/js/owl/owl.carousel.min.js', array('jquery'), false, true);
        wp_enqueue_script('owl-carousel');

        wp_register_script('ct-owl_init', CT_THEME_ASSETS . '/js/owl/init.js', array('jquery'), false, true);
        wp_enqueue_script('ct-owl_init');

        wp_register_script('ct-carousel_init', CT_THEME_ASSETS . '/js/owl/owl.carousel.min.js', array('jquery'), false, true);
        wp_enqueue_script('ct-carousel_init');

    }

    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public static $type;
    public function handle($atts, $content = null)
    {

        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
        extract($attributes);


        //parse shortcode before filters
    //    $itemsHtml = do_shortcode($content);


      if($type=='1') {
          self::$type='1';

          $tabs = '' . $this->callPreFilter($content) . ''; //reference




          return do_shortcode('<div class="ct-testimonialsSlider"> <div class="owl-carousel owl-carousel-testimonials">' . $tabs . '</div><div class="ct-owlContainer-nav"></div></div>');
      }
        else{
            self::$type='2';


            $tabs = '' . $this->callPreFilter($content) . ''; //reference

            return do_shortcode('  <div class="container">

    <div class="ct-accordionSlider ct-u-paddingBottom60">

        <div class="ct-accordionSlider-header">
            <h5 class="text-uppercase text-center">'.$title.'</h5>
            <div class="ct-owlContainer-nav2"></div>
        </div>

        <div class="owl-carousel owl-carousel-accordion">' . $tabs . '</div></div></div>');
        }







    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(

            'type' => array(
                'label'   => __( 'type', 'ct_theme' ),
                'default' => 1,
                'type'    => 'select',
                'choices' => array(
                    '1' => __( '1', 'ct_theme' ),
                    '2' => __( '2', 'ct_theme' ) ),
            ),

            'title' => array(
                'label' => __('Title', 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'dependency' => array(
                    'element'=> 'type',
                    'value' => array('2')
                )
            ),

            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );

    }

    /**
     * Child shortcode info
     * @return array
     */

    public function getChildShortcodeInfo()
    {
        return array('name' => 'item_testimonial', 'min' => 1, 'max' => 4, 'default_qty' => 4);
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-list-alt',
            'description' => __( "Add a child element of the tabs", 'ct_theme')
        ));
    }

}

new ctSliderTestimonialShortcode();

//#28144
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortcode_slider_testimonial extends WPBakeryShortCodesContainer{}
}