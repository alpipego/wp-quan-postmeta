<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 05.03.2017
 * Time: 09:48
 */

namespace Alpipego\PostMeta\Meta;


class Languages {

	public function getAlternate() {
		add_action( 'init', function () {
			if ( have_rows( 'apm_meta_hreflang' ) ) {
				while ( have_rows( 'apm_meta_hreflang' ) ) {
					the_row();

					printf( '<link rel="alternate" href="%s" hreflang="%s" />', get_permalink( get_sub_field( 'apm_meta_hreflang_url' ) ), get_sub_field( 'apm_meta_hreflang_code' ) );
				}
			}
		} );
	}

	public function getLang( $doctype ) {
		$lang = explode( '_', get_option( 'WPLANG' ) );
		$lang = ! empty( $postLang = trim( get_post_meta( get_the_id(), 'apm_meta_language', true ) ) ) ? $postLang : $lang[0];

		return $doctype === 'xhtml' ? sprintf( ' xml:lang="%s"', $lang ) : sprintf( 'lang="%s"', $lang );
	}
}
