<?php
/**
 * Tab shortcode
 */
class  ctTeTabSimpleShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{

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
		$this->connectPreFilter('simple_te_tabs', array($this, 'handlePreFilter'));
	}


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Simple Tab';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'simple_te_tab';
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

					<div role="tabpanel" class="tab-pane fade ' . $active . '" id="tab-' . self::$counter . '">
							<h4 class="ct-u-size28 ct-u-paddingBottom10 ct-u-marginTop0"><span>'.$title.'</span></h4>
							<p>'.$content.'<p>

					</div>
			');


		return '
			<li role="presentation" class=""><a href="#tab-'.$counter.'" role="tab" data-toggle="tab">
		<i class="fa '.$name.'"></i><span>  '.$title.'</span></a></li>
		';
	    }


	/**
	 * Adds content before filters
	 * @param string $content
	 * @return string
	 */
	public function handlePreFilter($content) {
		//here - add all available content
        $tabContainers = '<div class="tab-content">';
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
		return 'simple_te_tabs';
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
			'name'            => array(
				'label'   => __( 'Icon', 'ct_theme' ),
				'type'    => "icon",
				'font_types'=>array('awesome','etline'),
				'default' => '',
				'link'    => CT_THEME_ASSETS . '/shortcode/awesome/index.html'
			),

			'title' => array('label' => __('title', 'ct_theme'), 'default' => '', 'type' => 'input',
			),



			'widgetmode' => array('default' => 'false', 'type' => false),

            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
			);
		return $this->mergeShortcodeAttributes($items, 'icon', 'icon_rel', __('Icon', 'ct_theme'));
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

new ctTeTabSimpleShortcode();