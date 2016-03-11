<?php

namespace App\Models;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\AbstractAdapter;

class Galleries
{
    private $fileSystem;

    public function __construct(AbstractAdapter $adapter)
    {
        $this->fileSystem = new FileSystem($adapter);
    }

    /**
     * Returns all galleries.
     */
    public function getAll()
    {
        return array_filter($this->fileSystem->listContents(), function ($value) {
            return $value['type'] === 'dir';
        });
    }

    /**
     * Checks whether a gallery exists.
     */
    public function exists($gallery)
    {
        return $this->fileSystem->has($gallery);
    }

    /**
     * Creates a new gallery.
     */
    public function create($gallery)
    {
        if (!$this->fileSystem->has($gallery)) {
            $this->fileSystem->createDir($gallery);
        }
    }

    /**
     * Returns all photos.
     */
    public function getPhotos($gallery)
    {
        return array_filter($this->fileSystem->listContents($gallery), function ($value) {
            return in_array(strtolower($value['extension']), ['jpg', 'jpeg', 'gif', 'png'], true);
        });
    }

    /**
     * Returns all videos.
     */
    public function getVideos($gallery)
    {
        return array_filter($this->fileSystem->listContents($gallery), function ($value) {
            return in_array(strtolower($value['extension']), ['mp4'], true);
        });
    }

    /**
     * Remove a photo.
     */
    public function deletePhoto($gallery, $photo)
    {
        $this->fileSystem->delete($gallery.'/'.$photo);
    }
}
