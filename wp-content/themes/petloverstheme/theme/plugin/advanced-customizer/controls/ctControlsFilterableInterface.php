<?php

interface ctControlsFilterableInterface {

	/** Filter value from form, add validation, prefix, suffix ect.
	 *
	 * @param string $val value from form
	 * @param $options
	 *
	 * @return mixed filtred $val
	 */
	public function filter($val);
}