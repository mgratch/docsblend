<?php
/**
 * 1/2 column shortcode
 */
class ctHalfColumnShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return '1/2 column';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'half_column';
	}

	/**
	 * Action
	 * @return string
	 */

	public function getGeneratorAction() {
		return self::GENERATOR_ACTION_INSERT;
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));
        $mainContainerAtts = array(
            'class' => array(
                'col-md-6',
                $xs? 'col-xs-'.$xs : '',
                $sm? 'col-sm-'.$sm : '',
                $lg? 'col-lg-'.$lg : '',
                $class,
                (is_numeric($offset))? 'col-md-offset-'.$offset : '',
                (is_numeric($push))? 'col-md-push-'.$push : '',
                ($center =='true' || $center=='yes')?'text-center' : ''
            )
        );


        return '<div '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>'.do_shortcode($content).'</div>';
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'class' => array('type' => false),
            'offset' => array('label' => __('Column offset', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'push' => array('label' => __('Column push', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'center' => array('label' => __('Center content inside?', 'ct_theme'), 'default' => 'false', 'type' => 'select', 'choices' => array("true" => __("true", "ct_theme"), "false" => __("false", "ct_theme"))),
            'xs' => array('label' => __('Column for extra small devices', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '' => '')),
            'sm' => array('label' => __('Column for small devices', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '' => '')),
            'lg' => array('label' => __('Column for large devices ', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '' => '')),
		);
	}
}

new ctHalfColumnShortcode();