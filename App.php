<?php
namespace Apps\Galerias;

use Fol\Http\Router;
use Fol\Http\Request;

class App extends \Fol\App {
	use \Fol\Utils\FileRouter;

	public function __construct () {
		$this->Config = new \Fol\Config($this->path.'config/');

		//Default settings
		$this->Config->set('settings', array(
			'title' => 'Galerias',
			'cache' => false
		));

		//Merge with the user settings
		$this->Config->merge('settings', $this->Config->read('settings'));
	}


	public function handle () {
		$Request = Request::createFromGlobals();

		return Router::handle($this, $Request, [$this, $Request], [$Request]);
	}
}
?>
