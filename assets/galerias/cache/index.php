<?php
use Fol\Http\Request;

include('../../../bootstrap.php');

(new Apps\Galerias\App)->handleFile(Request::createFromGlobals())->send();