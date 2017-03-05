<?php

namespace Alpipego\PostMeta\Meta;

class Description {

	function getDescription() {
		if ( is_author() ) {
			return $this->getProfile();
		}
		if ( is_archive() || is_home() ) {
			return $this->getArchive();
		}

		return $this->getSingle();
	}

	function getProfile() {
		$user = get_user_by( 'slug', get_query_var( 'author_name' ) );

		return ! empty( $description = trim( get_field( 'description', 'user_' . $user->ID ) ) ) ? $description : '';
	}

	function getArchive() {
		$page = get_page_by_path( $_SERVER['REQUEST_URI'] );

		if ( ! is_null( $page ) ) {
			return ! empty( $description = trim( get_post_meta( $page->ID, 'apm_meta_description', true ) ) ) ? $description : '';
		}

		return '';
	}

	function getSingle() {
		return ! empty( $description = trim( get_post_meta( get_the_id(), 'apm_meta_description', true ) ) ) ? $description : '';
	}
}
