Galerías
========

Pequena web para crear galerias fotograficas. Non usa base de datos senon que funciona directamente con carpetas e arquivos.
Pensada para instalar en entornos privados (protexidos por contrasinal) onde todos os usuarios poden crear novas galerias e subir fotos directamente.
Por exemplo: un grupo de amigos que quere subir e intercambiar as suas fotos de xeito facil mantendo a privacidade.

* Feito co framework Fol (https://github.com/oscarotero/Fol/) (PHP 5.4)
* As fotos súbense directamente mediante drag and drop
* Crea miniaturas automaticamente. Redimensiona as fotos subidas a un tamaño máximo de 1200px para aforrar espazo.

Instalacion (usando Composer)
-----------------------------

Precisas composer e bower para instalar as dependencias:

```
$ composer create-project fol/galerias galerias
$ cd galerias
$ bower update
```

Demo
----

Aqui podes ver unha demo da galería instalada: http://oscarotero.com/galerias-demo/