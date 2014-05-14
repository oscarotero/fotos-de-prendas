<?php
namespace App\Controllers;

use Fol\App;
use Fol\Http\HttpException;
use Fol\Http\Request;
use Fol\Http\Response;
use Fol\Templates;

class Index {

	//Portada onde se listan todas as galerías
	public function index($request, $response, $app) {
		$app->templates->register('body', 'body-index.php', [
			'titulo' => $app->config->get('settings')['title'],
			'galerias' => $app->galleries->get()
		]);

		return $app->templates->render('html.php', [
			'titulo' => $app->config->get('settings')['title']
		]);
	}


	//Interior dunha galería
	public function galeria ($request, $response, $app) {
		$nome = $request->route['galeria'];

		if (!$app->galleries->exists($nome)) {
			throw new HttpException("Esta galería non existe", 404);
		}

		$app->templates->register('body', 'body-galeria.php', [
			'titulo' => $app->config->get('settings')['title'],
			'galeria' => array(
				'nome' => $nome
			),
			'fotos' => $app->galleries->getPhotos($nome),
			'videos' => $app->galleries->getVideos($nome)
		]);

		return $app->templates->render('html.php', [
			'titulo' => $app->config->get('settings')['title'].' » '.$nome
		]);
	}


	//Crear unha nova galería
	public function novaGaleria ($request, $response, $app) {
		$nome = $request->data->get('nome');

		$app->galleries->create($nome);

		$response->redirect($app->router->getUrl('galeria', ['galeria' => $nome]));
	}

	
	//Subir novas fotos
	public function subirFoto ($request, $response, $app) {
		$nome = $request->data['galeria'];

		$response->setFormat('json');

		if ($request->files->hasError('userfile')) {
			$response->setStatus(500);
			$response->setContent(json_encode(array(
				'error' => $request->files->getErrorMessage('userfile'),
				'errorCode' => $request->files->getErrorCode('userfile')
			)));

			return;
		}

		$foto = $request->files->get('userfile');

		if ($app->galleries->uploadPhoto($nome, $foto)) {
			$response->setContent(json_encode(array(
				'success' => 'Foto subida',
				'thumb' => $app->getPublicUrl('fotos/'.$nome.'/'.$foto['name'])
			)));

			return;
		}

		$response->setStatus(500);
		$response->setContent(json_encode(array(
			'error' => 'Non se subiu a foto '.$nome
		)));
	}

	//Xirar unha foto
	public function xirarFoto ($request, $response, $app) {
		$nome = $request->data['galeria'];
		$foto = $request->data['file'];

		$app->galleries->rotatePhoto($nome, $foto);
	}


	//Elimina unha foto
	public function eliminarFoto ($request, $response, $app) {
		$nome = $request->data['galeria'];
		$foto = $request->data['file'];

		$this->galleries->deletePhoto($nome, $foto);
	}

	//Erro
	public function error ($request, $response, $app) {
		$exception = $request->route->get('exception');

		$response->setStatus($exception->getCode());
		$response->setContent($exception->getMessage());
	}
}
