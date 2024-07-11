<?php

use Src\Copomex;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

header('Content-Type: application/json; charset=utf-8');

// Example 1

$copomex = new Copomex('info_cp', $_ENV['COPOMEX_TOKEN']);
$copomex->request('09810');

// Example 2

// $copomex = new Copomex('search_cp', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('09810');

// Example 3

// $copomex = new Copomex('get_estados', $_ENV['COPOMEX_TOKEN']);
// $copomex->request();

// Example 4

// $copomex = new Copomex('get_municipio_por_estado', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('Aguascalientes');

// Example 5

// $copomex = new Copomex('get_cp_por_municipio', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('Aguascalientes');

// Example 6

// $copomex = new Copomex('get_colonia_por_cp', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('09810');

// Example 7

// $copomex = new Copomex('get_cp_por_estado', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('Baja California Sur');

// Example 8

// $copomex = new Copomex('get_colonia_por_municipio', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('Valle de Bravo');

// Example 9

// $array_1 = [
//     'limit'=> '10'
// ];

// $copomex = new Copomex('search_cp_advanced', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('Ciudad de México',$array_1);

// Example 10

// $array_2 = [
//     'limit' => '10'
// ];

// $copomex = new Copomex('get_cp_advanced', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('Ciudad de México', $array_2);

// Example 11

// $array_3 = [
//     'estado' => 'Ciudad de México',
//     'municipio' => 'Iztapalapa'
// ];

// $copomex = new Copomex('get_colonia_por_estado_municipio', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('', $array_3);

// Example 12

// $array_4 = [
//     'type' => 'simplified'
// ];

// $copomex = new Copomex('info_cp_geocoding', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('09810',$array_4);

// Example 13

// $array_5 = [
//     'lat' => '19.42881',
//     'lng' => '-99.16225'
// ];

// $copomex = new Copomex('info_cp_geocoding_reverse', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('', $array_5);

// Example 14

// $copomex = new Copomex('get_estado_clave', $_ENV['COPOMEX_TOKEN']);
// $copomex->request();

// Example 15

// $copomex = new Copomex('get_municipio_clave_por_estado', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('Aguascalientes');

// Example 16

// $copomex = new Copomex('get_municipio_clave_por_clave_estado', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('01');

// Example 17

// $array_6 = [
//     'estado' => 'Aguascalientes',
//     'municipio' => 'Aguascalientes'
// ];

// $copomex = new Copomex('get_localidad_por_estado_municipio', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('',$array_6);

// Example 18

// $array_7 = [
//     'clave_estado' => '01',
//     'clave_municipio' => '001',
//     'clave_localidad' => '0001'
// ];

// $copomex = new Copomex('get_localidad_por_clave_estado_municipio', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('',$array_7);


// Example 19

// $array_8 = [
//     'clave_estado' => '01',
//     'clave_municipio' => '001',
//     'clave_localidad' => '0001'
// ];

// $copomex = new Copomex('info_localidad', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('',$array_8);

// Example 20

// $array_9 = [
//     'clave_estado' => '01',
//     'clave_municipio' => '001',
//     'clave_localidad' => '0001'
// ];

// $copomex = new Copomex('get_vialidad', $_ENV['COPOMEX_TOKEN']);
// $copomex->request('',$array_9);

// Example 21

// $copomex = new Copomex('get_tipo_vialidad', $_ENV['COPOMEX_TOKEN']);
// $copomex->request();

echo json_encode($copomex->response());
