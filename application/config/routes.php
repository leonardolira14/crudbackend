<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'Users';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


# ruta para el login

$route['login']="api/Users/login";

# ruta para el crud

# getall

$route['client/getall'] = "api/Clientes/getAll";
$route['client/get'] = "api/Clientes/getbyID";
$route['client/save'] = "api/Clientes/add";
$route['client/update'] = "api/Clientes/update";
$route['client/delete'] = "api/Clientes/delete";
$route['client/search'] = "api/Clientes/buscar";