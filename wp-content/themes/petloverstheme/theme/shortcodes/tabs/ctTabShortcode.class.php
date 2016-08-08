<?php
/**
 * Tab shortcode
 */
class  ctTabShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{

    /**
     * Tabs counter
     * @var int
     */

    protected static $counter = 0;

    /**
     * @inheritdoc
     */
    public function __construct() {
        parent::__construct();

        //connect for additional code
        //remember - method must be PUBLIC!
        $this->connectPreFilter('tabs', array($this, 'handlePreFilter'));
    }


    /**
     * Returns name
     * @return string|void
     */
    public function getName() {
        return 'Tab';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName() {
        return 'tab';
    }

    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null) {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));
        $counter = ++self::$counter;

        $start='';
        $endd='';

        if(ctTabsShortcode::$full=='yes'){
            $start =' class="container"';
            $endd='</div>';

        }

        $mainContainerAtts = array(
            'class' => array(
                'tab-pane',
                ($active=='yes') ? ' in active' : '',
                $class
            ),
            'id' => 'tab'.self::$counter
        );


        //add for pre filter data. Adds any data to this shortcode type
        $this->setData($counter, '<li role="presentation"' . ($active == 'yes' ? ' class="active"' : '') . '><div class="ct-tabBorder"><a href="#tab' . $counter . '" data-toggle="tab">' . $title . '</a><div class="mini-triangle"></div></div></li>');

        return '<div role="tabpanel" '.$this->buildContainerAttributes($mainContainerAtts, $atts).'>' . do_shortcode($content) . '</div>';
    }


    /**
     * Adds content before filters
     * @param string $content
     * @return string
     */
    public function handlePreFilter($content) {
        //here - add all available content
        foreach ($this->getAllData() as $data) {
            $content .= $data;
        }
        return $content;
    }

    /**
     * Parent shortcode name
     * @return null
     */

    public function getParentShortcodeName() {
        return 'tabs';
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes() {
        return array(
            'widgetmode' => array('default' => 'false', 'type' => false),
            'title' => array('label' => __('tab name', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'active' => array('label' => __('is active', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')),),
            'class' => array('label' => __('Custom class', 'ct_theme'),'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo() {
        return new ctVisualComposerInfo( $this, array(
            'icon' => 'fa-list-alt',
            'container'=>true,
            'description' => __( "Add a child element of the tabs", 'ct_theme')
        ) );
    }

}

new ctTabShortcode();