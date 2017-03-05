<?php

namespace Alpipego\PostMeta\Convert;


class Headspace implements ConvertInterface {
	private $postId;

	public function setPostId( int $postId ) {
		return $this->postId = $postId;
	}

	public function convertTitle() {
		if ( empty( trim( \get_post_meta( $this->postId, 'apm_meta_title', true ) ) ) ) {
			\update_post_meta( $this->postId, 'apm_meta_title', \get_post_meta( $this->postId, '_headspace_page_title', true ) );
		}
	}

	public function convertDescription() {
		if ( empty( trim( \get_post_meta( $this->postId, 'apm_meta_description', true ) ) ) ) {
			$description = strlen( \get_post_meta( $this->postId, '_headspace_description', true ) ) > 1 ? \get_post_meta( $this->postId, '_headspace_description', true ) : \get_field( 'quan_excerpt' );
			\update_post_meta( $this->postId, 'apm_meta_description', $description );
		}
	}

	public function convertRobots() {
		if ( \get_post_meta( $this->postId, 'apm_meta_robots', true ) ) {
			$robots = [];
			foreach ( [ 'nofollow', 'noarchive', 'noindex', ] as $botDirective ) {
				$hsDirective = \get_post_meta( $this->postId, '_headspace_' . $botDirective, true );
				if ( $hsDirective === 'robots' ) {
					$robots[] = $botDirective;
				}
			}
			\update_post_meta( $this->postId, 'apm_meta_robots', $robots );
			unset( $robots );
		}
	}

	public function convertLang() {
		// TODO: Implement convertLang() method.
	}
}
