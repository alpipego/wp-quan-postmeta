<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 05.03.2017
 * Time: 09:48
 */

namespace Alpipego\PostMeta\Meta;


class Robots {
	public function getRobots() {
		if ( is_single() ) {
			$robots = get_post_meta( get_the_id(), 'apm_meta_robots', true );

			if ( ! empty( $robots ) ) {
				return implode( ',', $robots );
			}
		}

		return false;
	}
}
