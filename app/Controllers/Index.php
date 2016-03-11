<?php
namespace App\Controllers;

use App\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Response\JsonResponse;
use Imagecow\Image;
use Uploader\Uploader;

class Index
{
	/**
	 * Portada da web
	 */
	public function index(Request $request, Response $response, App $app)
	{
		return $app['templates']->render('body-index');
	}


	/**
	 * Interior dunha galería
	 */
	public function galeria(Request $request, Response $response, App $app)
	{
		$name = $request->getAttribute('galeria');

		if (!$app['galleries']->exists($name)) {
			return $response->withStatus(404);
		}

		return $app['templates']->render('body-galeria', [
			'gallery' => $name
		]);
	}

	/**
	 * Crear unha nova galería
	 */
	public function novaGaleria(Request $request, Response $response, App $app)
	{
		$data = $request->getParsedBody();
		$name = $data['galeria'];
		$app['galleries']->create($name);

		return new RedirectResponse($app->getRoute('galeria', ['galeria' => $name]));
	}

	/**
	 * Subir novas fotos
	 */
	public function subirFoto(Request $request, Response $response, App $app)
	{
		$data = $request->getParsedBody();
		$name = $data['galeria'];

		$file = $request->getUploadedFiles()['userfile'];

		$upload = $app['uploader']->with($file)
			->setDirectory($name)
			->save();

		Image::fromFile($upload->getDestination(true))
			->resize(2000, 2000)
			->save();

		return new JsonResponse([
			'success' => 'Foto subida',
			'thumb' => $app->getUrl('images', $upload->getDestination())
		]);
	}

	/**
	 * Xirar unha foto 90º grados
	 */
	public function xirarFoto ($request, $response, $app)
	{
		$data = $request->getParsedBody();

		$file = $app->getPath('data/uploads/images', $data['galeria'], $data['file']);

		Image::fromFile($file)
			->rotate(-90)
			->save();
	}

	/**
	 * Eliminar unha foto
	 */
	public function eliminarFoto(Request $request, Response $response, App $app)
	{
		$data = $request->getParsedBody();

		$app['galleries']->deletePhoto($data['galeria'], $data['file']);
	}
}
