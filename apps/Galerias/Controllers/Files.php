<?php
namespace Apps\Galerias\Controllers;

use Fol\Http\Response;

class Files {
	private $cache = true;

	public function __construct ($App, $Request) {
		$this->App = $App;
		$this->Request = $Request;
	}

	public function css ($file) {
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

	public function jpg ($file) {
		return $this->image($file);
	}

	public function jpeg ($file) {
		return $this->image($file);
	}

	public function png ($file) {
		return $this->image($file);
	}

	private function image ($file) {
		$info = pathinfo($file);
		$filename = $this->App->assetsPath.'/'.$info['dirname'];
		$operations = $info['filename'];

		if (is_file($filename)) {
			$Image = \Imagecow\Image::create();
			$Image->load($filename)->transform($operations);

			if ($this->cache === true) {
				$Image->save($this->App->getCacheFilePath($file));
			}

			$Image->show();
		}
	}
}
?>