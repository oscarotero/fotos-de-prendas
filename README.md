Galeria
=======

Pequena web para crear galerias fotograficas. Non usa base de datos senon que funciona directamente con carpetas e arquivos.
Pensada para instalar en entornos privados (protexidos por contrasinal) onde todos os usuarios poden crear novas galerias e subir fotos directamente.
Por exemplo: un grupo de amigos que quere subir e intercambiar as suas fotos de xeito facil mantendo a privacidade.

* Feito co framework Fol (https://github.com/oscarotero/Fol/)
* As fotos súbense directamente mediante drag and drop
* Crea miniaturas automaticamente. Redimensiona as fotos subidas a un tamaño máximo de 1200px para aforrar espazo.
* Funciona ben en Chrome/Firefox/Opera (Safari non permite subir novas fotos e Internet Explorer non soporta CSS columns)

Instalacion (usando Composer)
-----------------------------

* Descargamos composer ```$ curl -s https://getcomposer.org/installer | php```
* Agora instalamos Fol ```$ php composer.phar create-project fol/fol galerias```
* Entramos no directorio e instalamos Galerias ```$ cd galerias``` ```$ php ../composer.phar require fol/galerias```
* Listo. Agora podes editar o arquivo index.php, para que en vez de instanciar Apps\Web\App, instanciar Apps\Galerias\App, e así cargar esa aplicación por defecto. Ou sexa: ```(new Apps\Galerias\App)->handle(Request::createFromGlobals())->send();```