<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 05.03.2017
 * Time: 09:24
 */

namespace Alpipego\PostMeta\Convert;


class Version1to2 implements ConvertInterface {

	private $postId;

	public function convertTitle() {
		$this->updateSimpleField( 'apm_meta_title', 'quan_meta_title' );
	}

	private function updateSimpleField( string $fieldKey, string $oldFieldKey ) {
		if ( empty( trim( get_post_meta( $this->postId, $fieldKey, true ) ) ) ) {
			update_post_meta( $this->postId, $fieldKey, get_post_meta( $this->postId, $oldFieldKey, true ) );
			delete_post_meta( $this->postId, $oldFieldKey );
			update_post_meta( $this->postId, '_' . $fieldKey, get_post_meta( $this->postId, '_' . $oldFieldKey, true ) );
			delete_post_meta( $this->postId, '_' . $oldFieldKey );
		}
	}

	public function convertDescription() {
		$this->updateSimpleField( 'apm_meta_description', 'quan_meta_description' );
	}

	public function convertRobots() {
		$this->updateSimpleField( 'apm_meta_robots', 'quan_meta_robots' );
	}

	public function convertLang() {
		$this->updateSimpleField( 'apm_meta_language', 'quan_meta_language' );
		$this->updateSimpleField( 'apm_meta_hreflang', 'quan_meta_hreflang' );

		$rows = (int) get_post_meta( $this->postId, 'apm_meta_hreflang' );
		while ( $rows ) {
			$num = --$rows;
			$this->updateSimpleField( 'apm_meta_hreflang_' . $num . '_code', 'quan_meta_hreflang_' . $num . '_quan_meta_hreflang_code' );
			$this->updateSimpleField( 'apm_meta_hreflang_' . $num . '_url', 'quan_meta_hreflang_' . $num . '_quan_meta_hreflang_url' );
		}
	}

	public function setPostId( int $postId ) {
		return $this->postId = $postId;
	}
}
