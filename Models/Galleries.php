<?php
namespace Apps\Galerias\Models;

class Galleries {
	private $path;

	public function __construct ($path) {
		$this->path = $path;
	}

	public function get () {
		$galleries = glob($this->path.'*', GLOB_ONLYDIR);
		$limit = strlen($this->path);

		foreach ($galleries as &$gallery) {
			$gallery = substr($gallery, $limit);
		}

		return $galleries;
	}

	public function exists ($gallery) {
		return is_dir($this->path.$gallery);
	}

	public function create ($gallery) {
		if (!$this->exists($gallery)) {
			mkdir($this->path.$gallery, 0777);
		}
	}

	public function getPhotos ($gallery) {
		$photos = glob($this->path.$gallery.'/*.jpg');
		$limit = strlen($this->path.$gallery.'/');

		$list = array();

		foreach ($photos as $photo) {
			$list[] = array(
				'file' => substr($photo, $limit)
			);
		}

		return $list;
	}

	public function getVideos ($gallery) {
		$videos_mp4 = glob($this->path.$gallery.'/*.mp4');
		$videos_ogv = glob($this->path.$gallery.'/*.ogv');
		$videos_webm = glob($this->path.$gallery.'/*.webm');
		$limit = strlen($this->path.$gallery.'/');

		$list = array();

		foreach ($videos_mp4 as $video) {
			$file = substr($video, 0, -4);

			$item = [
				'mp4' => substr($file, $limit).'.mp4'
			];

			if (($key = array_search("$file.ogg", $videos_ogv)) !== false) {
				$item['ogg'] = substr($file, $limit).'.ogv';
			}

			if (($key = array_search("$file.webm", $videos_webm)) !== false) {
				$item['webm'] = substr($file, $limit).'.webm';
			}

			$list[] = $item;
		}

		return $list;
	}

	public function uploadPhoto ($gallery, $photo) {
		if ($this->exists($gallery)) {
			$file = $this->path.$gallery.'/'.strtolower($photo['name']);

			if ($photo['error'] !== 0 || rename($photo['tmp_name'], $file) === false) {
				return false;
			}

			chmod($file, 0755);

			$Imagecow = \Imagecow\Image::create();
			$Imagecow->load($file)->resize(1200, 1200)->save();

			return true;
		}

		return false;
	}

	public function rotatePhoto ($gallery, $photo) {
		if ($this->exists($gallery)) {
			$file = $this->path.$gallery.'/'.$photo;

			if (is_file($file)) {
				$Imagecow = \Imagecow\Image::create();
				$Imagecow->load($file)->rotate(-90)->save();

				return true;
			}
		}

		return false;
	}

	public function deletePhoto ($gallery, $photo) {
		if ($this->exists($gallery)) {
			$file = $this->path.$gallery.'/'.$photo;

			if (is_file($file)) {
				return unlink($file);
			}
		}

		return false;
	}
}