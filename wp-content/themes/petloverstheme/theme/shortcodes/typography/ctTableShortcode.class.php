<?php

/**
 * Table shortcode
 */
class ctTableShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Table';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'table';
	}

	/**
	 * Returns shortcode type
	 * @return mixed|string
	 */

	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}


	/**
	 * Handles shortcode
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */

	public function handle( $atts, $content = null ) {
		extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );


		return do_shortcode( '' . $content . '' );
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(

			'content' => array(
				'label'   => __( 'Content', 'ct_theme' ),
				'default' => '',
				'type'    => 'textarea',
				'help'    => __( 'Please enter complete HTML Table markup with &lt;table&gt;..&lt;/table&gt;<br>Learn more: http://www.html5-tutorials.org/tables/basics-of-tables/', 'ct_theme' ),
				'example' => array( $this, 'getExampleContent' ),
			),
			'class'   => array( 'label' => __( 'Custom class', 'ct_theme' ), 'default' => '', 'type' => 'input' ),
		);
	}

	/**
	 * Returns example content
	 * @return string
	 */
	public function getExampleContent() {
		return ' <thead>
                    <tr>
                        <th>SPECS</th>
                        <th>XEON E5-2687W</th>
                        <th>CORE I7 990X</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>BRAND</td>
                        <td>Intel</td>
                        <td>Intel</td>
                    </tr>
                    <tr>
                        <td>SPEED</td>
                        <td>3.10GHz</td>
                        <td>3.47GHz</td>
                    </tr>
                    <tr>
                        <td>COST</td>
                        <td>$1800</td>
                        <td>$1100</td>
                    </tr>
                    <tr>
                        <td>CPU MARK</td>
                        <td>17,872</td>
                        <td>10,550</td>
                    </tr>
                    </tbody>
               ';

	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-table' ) );
	}
}

new ctTableShortcode();