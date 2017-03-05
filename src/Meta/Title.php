<?php

namespace Alpipego\PostMeta\Meta;

class Title {
	public function getTitle() {
		if ( is_author() ) {
			return $this->getProfile();
		}

		if ( is_archive() || is_home() ) {
			return $this->getArchive();
		}

		return $this->getSingle();
	}

	protected function getProfile() {
		$user = get_user_by( 'slug', \get_query_var( 'author_name' ) );

		return $user->data->display_name . ' - ' . get_bloginfo( 'title' );
	}

	protected function getArchive() {
		$page = get_page_by_path( $_SERVER['REQUEST_URI'] );
		if ( ! is_null( $page ) ) {

			return ! empty( $title = trim( get_post_meta( $page->ID, 'apm_meta_title', true ) ) ) ? $title : '';
		}
	}

	protected function getSingle() {
		return ! empty( $title = trim( get_post_meta( get_the_id(), 'apm_meta_title', true ) ) ) ? $title : get_the_title();
	}
}
