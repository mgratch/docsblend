<?php
/**
 * Tab shortcode
 */
class  ctTeTabShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{

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
		$this->connectPreFilter('te_tabs', array($this, 'handlePreFilter'));
	}


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Media Tab';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'te_tab';
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


		if($icon=='yes'){
			$i='<i class="fa fa-quote-left"></i>';
		}else{
			$i='';
		}



		$active = $active == 'active' ? 'active in' : '';
		$this->setData($counter, '

					<div role="tabpanel" class="tab-pane fade ' . $active . '" id="tab-' . self::$counter . '">
							 '.$i.' '.$content.'
                        <p class="ct-u-paddingTop10"><span>- '.$name.'</span></p>
					</div>
			');




		return '
			<li role="presentation" class=""><a href="#tab-'.$counter.'" role="tab" data-toggle="tab">
				<img src="' . esc_url($src) . '" alt="sd">

			</a>
            </a></li>';
	    }


	/**
	 * Adds content before filters
	 * @param string $content
	 * @return string
	 */
	public function handlePreFilter($content) {
		//here - add all available content
        $tabContainers = '<div class="tab-content ct-mediaTabs-content">';
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
		return 'te_tabs';
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
			'name' => array('label' => __('Name', 'ct_theme'), 'default' => '', 'type' => 'input'),
			'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea',
			),

			'icon' => array('label' => __('Add quote icon', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' => array('no' => __('no', 'ct_theme'), 'yes' => __('yes', 'ct_theme')),),


			'widgetmode' => array('default' => 'false', 'type' => false),

            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
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

new ctTeTabShortcode();