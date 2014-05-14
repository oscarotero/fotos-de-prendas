<?php
namespace App\Models;

use Fol\FileSystem;

class Galleries {
	private $fs;

	public function __construct (FileSystem $fs) {
		$this->fs = $fs;
	}

	public function get () {
		$galleries = [];

		foreach ($this->fs->getIterator() as $item) {
			if ($item->isDir()) {
				$galleries[] = $item;
			}
		}

		return $galleries;
	}

	public function exists ($gallery) {
		return $gallery && $this->fs->getInfo($gallery)->isDir();
	}

	public function create ($gallery) {
		if (!$this->exists($gallery)) {
			$this->fs->mkdir($gallery);
		}
	}

	public function getPhotos ($gallery) {
		$photos = [];

		foreach ($this->fs->getGlobIterator("{$gallery}/*.jpg") as $item) {
			$photos[] = $item;
		}

		return $photos;
	}

	public function getVideos ($gallery) {
		$videos = [];

		foreach ($this->fs->getGlobIterator($gallery.'/*.mp4') as $video) {
			$k = $video->getBaseName('.mp4');
	
			$videos[$k] = ['mp4' => $video];
		}

		foreach ($this->fs->getGlobIterator($gallery.'/*.ogv') as $video) {
			$k = $video->getBaseName('.ogv');
			
			if (!isset($videos[$k])) {
				$videos[$k] = ['ogv' => $video];
			} else {
				$videos[$k]['ogv'] = $video;
			}
		}

		foreach ($this->fs->getGlobIterator($gallery.'/*.webm') as $video) {
			$k = $video->getBaseName('.webm');
			
			if (!isset($videos[$k])) {
				$videos[$k] = ['webm' => $video];
			} else {
				$videos[$k]['webm'] = $video;
			}
		}

		return $videos;
	}

	public function uploadPhoto ($gallery, $photo) {
		if (!$this->exists($gallery)) {
			return false;
		}

		$name = $this->fs->copy($photo, $gallery);

		$image = \Imagecow\Image::create($name);
		$image->resize(1200, 1200)->save();

		return true;
	}

	public function rotatePhoto ($gallery, $photo) {
		if ($this->exists($gallery)) {
			$file = $this->fs->getPath($gallery.'/'.$photo);

			if (is_file($file)) {
				$image = \Imagecow\Image::create($file);
				$image->rotate(-90)->save();

				return true;
			}
		}

		return false;
	}

	public function deletePhoto ($gallery, $photo) {
		if ($this->exists($gallery) && $photo) {
			$this->fs->remove($gallery.'/'.$photo);
		}

		return false;
	}
}