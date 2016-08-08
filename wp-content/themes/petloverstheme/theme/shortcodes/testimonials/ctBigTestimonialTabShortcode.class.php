<?php
/**
 * Tab shortcode
 */
class  ctBigTestimonialTabShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{

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
		$this->connectPreFilter('big_testimonial_tabs', array($this, 'handlePreFilter'));
	}


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Big Testimonial Tab';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'big_testimonial_tab';
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


		$active = $active == 'active' ? 'active in' : '';
		$this->setData($counter, '


					<div role="tabpanel" class="tab-pane row ' . $active . '" id="tab-' . self::$counter . '">

<div class="col-sm-2 hidden-xs">
													<div class="ct-quoteIcons"><i class="fa fa-user"></i></div>
												</div>
												<div class="col-sm-10 ct-u-paddingBoth10 animated fadeIn">
													<p class="ct-fw-400 ct-u-marginBottom0">' . do_shortcode($content) . '</p>
													<span class="ct-u-size18 ct-fw-600">'.$author.'</span>
												</div>


												</div>



						');




		return '

			<li role="presentation" class="col-xs-3">
			<a href="#tab-'.$counter.'" role="tab" data-toggle="tab">

				<img class="img-responsive" draggable="false"  src="' . esc_url($src) . '" alt="">


            </a>
            </li>';
	    }


	/**
	 * Adds content before filters
	 * @param string $content
	 * @return string
	 */
	public function handlePreFilter($content) {
		//here - add all available content
        $tabContainers = '<div class="tab-content ct-u-paddingBottom50">';
		foreach ($this->getAllData() as $data) {
            $tabContainers.=$data;
		}
        $tabContainers.= '<div class="clearfix"></div> </div>';
		return $tabContainers;
	}

	/**
	 * Parent shortcode name
	 * @return null
	 */

	public function getParentShortcodeName() {
		return 'big_testimonial_tabs';
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		$items = array(

			'active' => array(
				'active' => __("is active", 'ct_theme'),
				'type' => 'checkbox',
				'default' => '',
				'value' => 'active',
			),

			'src' => array('label' => __("image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
			'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
			'author' => array('label' => __('Author', 'ct_theme'), 'default' => '', 'type' => 'input'),

            'widgetmode' => array('default' => 'false', 'type' => false),


			);
		return $items;
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array(
			'icon' => 'fa-list-alt',

			'description' => __( "Custom tabbed content", 'ct_theme')
			) );
	}

}

new ctBigTestimonialTabShortcode();