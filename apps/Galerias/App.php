<?php
namespace Apps\Galerias;

class App extends \Fol\App {
	use \Fol\AppsTraits\SimpleRouter;
	use \Fol\AppsTraits\PreprocessedFileRouter;

	public function __construct () {
		$this->Config = new \Fol\Data($this->path.'config/');

		//Default settings
		$this->Config->set('settings', array(
			'title' => 'Galerias',
			'cache' => false
		));

		//Merge with the user settings
		$this->Config->merge('settings');
	}
}
?>
