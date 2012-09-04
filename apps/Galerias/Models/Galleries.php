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

		foreach ($photos as &$photo) {
			$photo = substr($photo, $limit);
		}

		return $photos;
	}

	public function uploadPhoto ($gallery, $photo) {
		if ($this->exists($gallery)) {
			$file = $this->path.$gallery.'/'.strtolower($photo['name']);

			if (rename($photo['tmp_name'], $file) === false) {
				return false;
			}

			chmod($file, 0755);

			$Imagecow = \Imagecow\Image::create();
			$Imagecow->load($file)->resize(1200, 1200)->save();

			return true;
		}

		return false;
	}
}