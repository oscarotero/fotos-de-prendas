<?php
namespace App;

use Fol\App;
use Fol\Http\Request;
use Fol\Http\Response;

class Files {
	private $cache = true;

	public function __construct (App $App) {
		$this->App = $App;
		$this->cache = $App->Config->get('settings')['cache'];
	}

	public function css ($Request, $file) {
		$Stylecow = \Stylecow\Parser::parseFile($this->App->assetsPath.$file);
		$Stylecow->applyPlugins(array(
			'VendorPrefixes',
			'Variables',
			'Color',
			'NestedRules'
		));

		if ($this->cache === true) {
			file_put_contents($this->App->getCacheFilePath($file), $Stylecow->toString());
		}

		$Response = new Response($Stylecow->toString());
		$Response->setContentType('css');

		return $Response;
	}

	public function jpg ($Request, $file) {
		return $this->image($Request, $file);
	}

	public function jpeg ($Request, $file) {
		return $this->image($Request, $file);
	}

	public function png ($Request, $file) {
		return $this->image($Request, $file);
	}

	private function image ($Request, $file) {
		$info = pathinfo($file);
		$filename = $this->App->assetsPath.'/'.$info['dirname'];
		$operations = $info['filename'];

		if (is_file($filename)) {
			$Image = \Imagecow\Image::create();
			$Image->load($filename)->transform($operations)->format($info['extension']);

			if ($this->cache === true) {
				$Image->save($this->App->getCacheFilePath($file));
			}

			$Image->show();
		}
	}
}
?>