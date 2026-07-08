<?php
/**
 * WP-style fixture for the formatting-deadlock check.
 *
 * Tab indentation. Kept clean under WPTechnix for the indent sniff.
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
		$defaults = [
			'alpha' => 1,
			'beta'  => 2,
		];

		if ( empty( $input ) ) {
			return $defaults;
		}

		return $input;
	}
}
