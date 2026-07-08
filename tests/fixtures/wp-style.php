<?php
/**
 * WP-style fixture for the formatting-deadlock check.
 *
 * Tab indentation, long array syntax, and Yoda conditions. Kept clean under
 * WPTechnix for the array, indent, and Yoda sniffs.
 *
 * @package WPTechnix\Fixtures
 */

namespace WPTechnix\Fixtures;

/**
 * Merges caller values over the defaults, WordPress style.
 */
class Wp_Style_Fixture {

	/**
	 * Merge caller values over the defaults.
	 *
	 * @param array $input Caller values.
	 *
	 * @return array
	 */
	public function merge( $input ) {
		$defaults = array(
			'alpha' => 1,
			'beta'  => 2,
		);

		if ( true === empty( $input ) ) {
			return $defaults;
		}

		return $input;
	}
}
