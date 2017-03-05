<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 05.03.2017
 * Time: 09:31
 */

namespace Alpipego\PostMeta\Convert;


use Alpipego\WpLib\DIContainer;
use WP_Query;

class Converter {
	private $convert = [
		'Headspace',
		'Version1to2',
	];
	private $container;


	public function __construct( DIContainer $container ) {
		$this->container = $container;
	}

	public function convert() {
		add_action( 'init', function () {
			$query = new WP_Query( [
				'post_type'      => 'any',
				'posts_per_page' => - 1,
			] );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$this->getConverter( $query->post->ID );
				}
			}
		} );
	}

	private function getConverter( int $postId ) {
		foreach ( $this->convert as $converter ) {
			if ( $this->container->offsetGet( ( 'convert_' . strtolower( $converter ) ) ) ) {
				/** @var ConvertInterface $converterObj */
				$converterObj = $this->container[ 'convert_' . strtolower( $converter ) ];
				$converterObj->setPostId( $postId );
				$converterObj->convertTitle();
				$converterObj->convertDescription();
				$converterObj->convertLang();
				$converterObj->convertRobots();
			}
		}
	}
}
