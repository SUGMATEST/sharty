<?php
/*
 *  Copyright (c) 2010-2013 Tinyboard Development Group
 */

defined('TINYBOARD') or exit;

/**
 * Class for generating json API compatible with 4chan API
 */
#[\AllowDynamicProperties]
class Api {
	function __construct(){
		global $config;
		/**
		 * Translation from local fields to fields in 4chan-style API
		 */
		$this->config = $config;

		$this->postFields = array(
			'id' => 'no',
			'thread' => 'resto',
			'subject' => 'sub',
			'body' => 'com',
			'body_nomarkup' => '___body_nomarkup',
			'email' => 'email',
			'name' => 'name',
			'trip' => 'trip',
			'capcode' => 'capcode',
			'time' => 'time',
			'omitted' => 'omitted_posts',
			'omitted_images' => 'omitted_images',
			'replies' => 'replies',
			'images' => 'images',
			'sticky' => 'sticky',
			'locked' => 'locked',
			'cycle' => 'cyclical',
			'invincible' => 'looped',
			'images_only' => 'images_only',
			'bump' => 'last_modified',
			'embed' => 'embed',
		);

		$this->threadsPageFields = array(
			'id' => 'no',
			'bump' => 'last_modified'
		);

		$this->fileFields = array(
			'thumbheight' => 'tn_h',
			'thumbwidth' => 'tn_w',
			'height' => 'h',
			'width' => 'w',
			'size' => 'fsize',
			'thumb' => 'thumb',
			'filename' => 'filename',
		);

		if (isset($config['api']['extra_fields']) && gettype($config['api']['extra_fields']) == 'array'){
			$this->postFields = array_merge($this->postFields, $config['api']['extra_fields']);
		}
	}

	private static $ints = array(
		'no' => 1,
		'resto' => 1,
		'time' => 1,
		'tn_w' => 1,
		'tn_h' => 1,
		'w' => 1,
		'h' => 1,
		'fsize' => 1,
		'omitted_posts' => 1,
		'omitted_images' => 1,
		'replies' => 1,
		'images' => 1,
		'sticky' => 1,
		'locked' => 1,
		'looped' => 1,
		'images_only' => 1,
		'last_modified' => 1
	);

	private function translateFields($fields, $object, &$apiPost) {
		foreach ($fields as $local => $translated) {
			if (!isset($object->$local))
				continue;

			$toInt = isset(self::$ints[$translated]);
			$val = $object->$local;
			if (isset($this->config['hide_email']) && $this->config['hide_email'] && $local === 'email') {
				$val = '';
			}
			if ($val !== null && $val !== '') {
				$apiPost[$translated] = $toInt ? (int) $val : $val;
			}

		}
	}

	private function translateFile($file, $post, &$apiPost) {
		$this->translateFields($this->fileFields, $file, $apiPost);
		$dotPos = strrpos($file->file, '.');
		$apiPost['ext'] = substr($file->file, $dotPos);
		$apiPost['tim'] = substr($file->file, 0, $dotPos);
		if (isset($this->config['show_filename']) && $this->config['show_filename']) {
			$apiPost['filename'] = @substr($file->name, 0, strrpos($file->name, '.'));
		}
		else {
			$apiPost['filename'] = substr($file->file, 0, $dotPos);
		}

		if (isset ($file->hash_md5) && $file->hash_md5) {
			$apiPost['md5'] = base64_encode(hex2bin($file->hash_md5));
		}
		if (isset ($file->hash_pdq) && $file->hash_pdq) {
			$apiPost['pdq'] = base64_encode(hex2bin($file->hash_pdq));
		}
		else if (isset ($file->hash) && mb_strlen($file->hash) == 32) {
			$apiPost['md5'] = base64_encode(hex2bin($file->hash));
		}
		else if (isset ($file->hash) && $file->hash) {
			$apiPost['pdq'] = base64_encode(hex2bin($file->hash));
		}

		if (isset($file->nsfw_prob)) {
			$apiPost['nsfw_score'] = $file->nsfw_prob;
		}
		else {
			$apiPost['nsfw_score'] = 0;
		}

		if ($apiPost['ext'] == 'deleted') {
			$apiPost['filedeleted'] = 1;
		}
		else {
			$apiPost['filedeleted'] = 0;
		}

		if (isset($file->thumb) && $file->thumb == 'spoiler') {
			$apiPost['spoiler'] = 1;
		}
		else {
			$apiPost['spoiler'] = 0;
		}

		if (isset($file->is_approved) && $file->is_approved == 0) {
			$apiPost['pending_approval'] = 1;
		}
		else {
			$apiPost['pending_approval'] = 0;
		}
	}

	private function translatePost($post, $threadsPage = false) {
		global $config, $board;
		$apiPost = array();
		$fields = $threadsPage ? $this->threadsPageFields : $this->postFields;
		$this->translateFields($fields, $post, $apiPost);

		if (isset($apiPost['___body_nomarkup']) && !empty($post->decryption_key))
			$apiPost['___body_nomarkup'] = "";

		if (isset($post->post_flags) && $post->post_flags & (1 << 9)) {
			$apiPost['desktop_only'] = 1;
		}
		else {
			$apiPost['desktop_only'] = 0;
		}

		if (isset($config['poster_ids']) && $config['poster_ids']) $apiPost['id'] = poster_id($post->ip, $post->thread);
		$hasCapcode = isset($post->capcode) && $post->capcode;

		if (((isset($config['show_ids']) && $config['show_ids']) || $post->show_ids) && !$hasCapcode){
			$extra = 0;
			if (isset($config['show_ids_unique_thread']) && $config['show_ids_unique_thread']) $extra = $post->thread;
			if ($post->email != "anonymous") {
				$apiPost['id'] = new_poster_id($post->ip, $extra);
			}
			else {
				$apiPost['id'] = "ANONYMOUS";
			}
		}
		if ($threadsPage) return $apiPost;

		// Handle country field
		if (isset($post->body_nomarkup) && ($this->config['country_flags'] || $post->geo_flags)) {
			$modifiers = extract_modifiers($post->body_nomarkup);
			if (isset($modifiers['flag']) && isset($modifiers['flag alt']) && preg_match('/^[a-z]{2}$/', $modifiers['flag'])) {
				$country = strtoupper($modifiers['flag']);
				if ($country) {
					$apiPost['country'] = $country;
					$apiPost['country_name'] = $modifiers['flag alt'];
				}
			}
		}

		if ($config['slugify'] && !$post->thread) {
			$apiPost['semantic_url'] = $post->slug;
		}

		// Handle files
		// Note: 4chan only supports one file, so only the first file is taken into account for 4chan-compatible API.
		if (isset($post->files) && $post->files && !$threadsPage) {
			$file = $post->files[0];
			$this->translateFile($file, $post, $apiPost);
			if (sizeof($post->files) > 1) {
				$extra_files = array();
				foreach ($post->files as $i => $f) {
					if ($i == 0) continue;
				
					$extra_file = array();
					$this->translateFile($f, $post, $extra_file);

					$extra_files[] = $extra_file;
				}
				$apiPost['extra_files'] = $extra_files;
			}
		}

		return $apiPost;
	}

	function translateThread(Thread $thread, $threadsPage = false) {
		$apiPosts = array();
		$op = $this->translatePost($thread, $threadsPage);
		if (!$threadsPage) $op['resto'] = 0;
		$apiPosts['posts'][] = $op;

		foreach ($thread->posts as $p) {
			$apiPosts['posts'][] = $this->translatePost($p, $threadsPage);
		}

		return $apiPosts;
	}

	function translatePage(array $threads) {
		$apiPage = array();
		foreach ($threads as $thread) {
			$apiPage['threads'][] = $this->translateThread($thread);
		}
		return $apiPage;
	}

	function translateCatalogPage(array $threads, $threadsPage = false) {
		$apiPage = array();
		foreach ($threads as $thread) {
			$ts = $this->translateThread($thread, $threadsPage);
			$apiPage['threads'][] = current($ts['posts']);
		}
		return $apiPage;
	}

	function translateCatalog($catalog, $threadsPage = false) {
		$apiCatalog = array();
		foreach ($catalog as $page => $threads) {
			$apiPage = $this->translateCatalogPage($threads, $threadsPage);
			$apiPage['page'] = $page;
			$apiCatalog[] = $apiPage;
		}

		return $apiCatalog;
	}
}
