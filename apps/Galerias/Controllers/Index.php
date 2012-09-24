<?php
namespace Apps\Galerias\Controllers;

use Fol\App;
use Fol\Http\HttpException;
use Fol\Http\Request;
use Fol\Http\Response;
use Fol\Templates;

class Index {

	public function __construct (App $App, Request $Request) {
		$this->App = $App;
		$this->Request = $Request;

		$this->Templates = new Templates($this->App->path.'templates');
		$this->Templates->App = $App;

		$this->Galleries = new \Apps\Galerias\Models\Galleries($this->App->assetsPath.'fotos/');
	}


	public function index () {
		$this->Templates->register('body', 'body-index.php');

		return $this->Templates->render('html.php', array(
			'titulo' => $this->App->Config->get('settings')['title'],
			'data' => array(
				'titulo' => $this->App->Config->get('settings')['title'],
				'galerias' => $this->Galleries->get()
			)
		));
	}


	public function galeria ($nome) {
		if (!$this->Galleries->exists($nome)) {
			throw new HttpException("Esta galería non existe", 404);
		}

		$this->Templates->register('body', 'body-galeria.php');

		return $this->Templates->render('html.php', array(
			'titulo' => $this->App->Config->get('settings')['title'].' » '.$nome,
			'data' => array(
				'titulo' => $this->App->Config->get('settings')['title'],
				'galeria' => array(
					'nome' => $nome
				),
				'fotos' => $this->Galleries->getPhotos($nome)
			)
		));
	}


	/**
	 * @router method post
	 */
	public function novaGaleria () {
		$nome = $this->Request->Post->get('nome');

		$this->Galleries->create($nome);

		$Response = new Response;
		$Response->redirect($this->App->url.'galeria/'.$nome);

		return $Response;
	}

	
	/**
	 * @router method post
	 */
	public function subirFotos ($nome) {
		$Response = new Response;
		$Response->setContentType('json');

		if ($this->Request->Files->hasError('userfile')) {
			$Response->setStatus(500);
			$Response->setContent(json_encode(array(
				'error' => $this->Request->Files->getErrorMessage('userfile'),
				'errorCode' => $this->Request->Files->getErrorCode('userfile')
			)));

			return $Response;
		}

		$foto = $this->Request->Files->get('userfile');

		if ($this->Galleries->uploadPhoto($nome, $foto)) {
			$Response->setContent(json_encode(array(
				'success' => 'Foto subida',
				'thumb' => $this->App->assetsUrl.'cache/fotos/'.$nome.'/'.$foto['name'].'/resize,300.jpg'
			)));

			return $Response;
		}

		$Response->setStatus(500);
		$Response->setContent(json_encode(array(
			'error' => 'Non se subiu a foto '.$nome
		)));

		return $Response;
	}


	/**
	 * @router method post
	 */
	public function xirarFotos ($nome) {
		$foto = $this->Request->Post->get('file');
		$this->Galleries->rotatePhoto($nome, $foto);
		$this->App->removeCache('fotos/'.$nome.'/'.$foto);
	}


	/**
	 * @router method post
	 */
	public function eliminarFotos ($nome) {
		$foto = $this->Request->Post->get('file');
		$this->Galleries->deletePhoto($nome, $foto);
		$this->App->removeCache('fotos/'.$nome.'/'.$foto);
	}

	public function error ($Exception) {
		return new Response($Exception->getMessage(), $Exception->getCode());
	}
}
?>
