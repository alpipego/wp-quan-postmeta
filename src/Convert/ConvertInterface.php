<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 05.03.2017
 * Time: 09:23
 */

namespace Alpipego\PostMeta\Convert;


interface ConvertInterface {
	public function convertTitle();

	public function convertDescription();

	public function convertRobots();

	public function convertLang();

	public function setPostId( int $postId );
}
