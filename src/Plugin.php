<?php

namespace Alpipego\PostMeta;

use Alpipego\PostMeta\Meta\Description;
use Alpipego\PostMeta\Meta\Languages;
use Alpipego\PostMeta\Meta\Robots;
use Alpipego\PostMeta\Meta\Title;
use Alpipego\WpLib\Plugin\AcfBoilerplate;

class Plugin extends AcfBoilerplate {
	private $c;

	public function __construct( string $file, $container ) {
		parent::__construct( $file );

		$this->c = $container;
	}

	public function outputMeta() {
		if ( ! current_theme_supports( 'title-tag' ) ) {
			printf( '<title>%s</title>', $this->getTitle() );
		}

		if ( $description = $this->getDescription() ) {
			printf( '<meta name="Description" content="%s">', $description );
		}

		if ( $robots = $this->getRobots() ) {
			printf( '<meta name="robots" content="%s">', $robots );
		}
		$this->getAlternateLanguages();
	}

	private function getTitle() {
		/** @var Title $title */
		$title = $this->c['meta_title'];

		return $title->getTitle();
	}

	private function getDescription() {
		/** @var Description $description */
		$description = $this->c['meta_description'];

		return $description->getDescription();
	}

	private function getRobots() {
		/** @var Robots $robots */
		$robots = $this->c['meta_robots'];

		return $robots->getRobots();
	}

	private function getAlternateLanguages() {
		/** @var Languages $languages */
		$languages = $this->c['meta_languages'];

		$languages->getAlternate();
	}

	public function getLanguage( $output, $doctype ) {
		/** @var Languages $languages */
		$languages = $this->c['meta_languages'];

		return $languages->getLang( $doctype );
	}

	public function run() {
		parent::run();
		add_action( 'wp_head', [ $this, 'outputMeta' ] );
		add_filter( 'language_attributes', [ $this, 'getLanguage' ], 20, 2 );
		if ( current_theme_supports( 'title-tag' ) ) {
			add_filter( 'pre_get_document_title', [ $this, 'getTitle' ] );
		}
	}

	public function addAcfJsonLoadPoint( $paths ) {
		$paths[] = __DIR__ . '/acf-json';

		return $paths;
	}
}
