<?php

/**
 * Tab shortcode
 */
class  ctPricingTableItemShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Pricing Table Item';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'pricing_table_item';
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



		$items = do_shortcode( $content );


		return '

<div class="col-md-3 col-sm-6 ct-table ct-u-paddingBottom60">
<table class="table '.$type.'">
<thead>
                <tr>
                    <th>' . $title . '</th>
                </tr>
                </thead>
<tbody>

</tbody>

' . $items . '

<tfoot>
                <tr>
                    <th>'.$currency.' '.$price.'<a class="btn btn-motive priceTable" href="'.$link.'"><span>'.$btn_label.'<i class="fa fa-location-arrow"></i></span></a></th>
                </tr>
                </tfoot>
</table>
</div>
        ';
	}


	/**
	 * Parent shortcode name
	 * @return null
	 */

	public function getParentShortcodeName() {
		return 'pricing_table';
	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array( 'name' => 'pricing_table_cell', 'min' => 2, 'max' => 50, 'default_qty' => 1 );
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(

			'type' => array(
				'label'   => __( 'type', 'ct_theme' ),
				'default' => '',
				'type'    => 'select',
				'choices' => array(
					'' => __( 'normal', 'ct_theme' ),
					'ct-table-danger' => __( 'danger', 'ct_theme' ),
					'ct-table-warning' => __( 'warning', 'ct_theme' ) ),
			),


			'title'    => array( 'label' => __( 'title', 'ct_theme' ), 'default' => '', 'type' => 'input' ),
			'price'             => array( 'label' => __( 'Price', 'ct_theme' ), 'default' => '', 'type' => 'input' ),
			'currency'          => array( 'label' => __( 'Currency', 'ct_theme' ), 'default' => '', 'type' => 'input' ),
			'btn_label'          => array( 'label' => __( 'Label button', 'ct_theme' ), 'default' => '', 'type' => 'input' ),
			'link'          => array( 'label' => __( 'Link button', 'ct_theme' ), 'default' => '', 'type' => 'input' ),


			'content'  => array( 'label' => __( 'Content', 'ct_theme' ), 'default' => '', 'type' => "textarea" ),

		);
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-table' ) );
	}
}


new ctPricingTableItemShortcode();