<?php
use Fol\Http\Request;

include('bootstrap.php');

(new Apps\Galerias\App)->handle(Request::createFromGlobals())->send();