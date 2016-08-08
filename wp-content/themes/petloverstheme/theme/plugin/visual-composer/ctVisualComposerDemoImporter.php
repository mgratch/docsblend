<?php

/**
 * Help to import data
 * @author alex
 */
class ctVisualComposerDemoImporter {
	public function __construct() {
		add_action( 'ct_import.exporter_importer.import.post', array( $this, 'normalizePostShortcode' ) );
	}

	/**
	 * Mapped terms
	 *
	 * @param $terms
	 */

	public function normalizePostShortcode( $terms ) {
		return;
		var_dump($terms);exit;
	}
}

new ctVisualComposerDemoImporter();