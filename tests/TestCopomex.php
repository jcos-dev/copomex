<?php

declare(strict_types=1);

namespace Test;

date_default_timezone_set('Etc/GMT+6');

use Src\Copomex;
use Dotenv\Dotenv;

use PHPUnit\Framework\TestCase;

class TestCopomex extends TestCase
{

    private ?Copomex $copomex;

    protected function setUp(): void
    {
        parent::setUp();

        try {
            $dotenv = Dotenv::createImmutable(getcwd());
            $dotenv->load();
            $this->copomex = new Copomex($_ENV['COPOMEX_TOKEN']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function testTokenProporcionado()
    {
        $this->assertNotEquals('', $this->copomex->getToken());
    }

    public function testManejarErrorBusqueda()
    {
        $this->copomex->setMethod('');
        $this->copomex->request();
        $this->assertTrue($this->copomex->response()['error']);
    }

    public function testInformacionCP()
    {
        $this->copomex->setMethod('info_cp');
        $this->copomex->request('09810');
        $this->assertGreaterThan(0, count($this->copomex->response()));
    }

    public function testBuscarCoincidenciaCP()
    {
        $this->copomex->setMethod('search_cp');
        $this->copomex->request('0981');
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerEstados()
    {
        $this->copomex->setMethod('get_estados');
        $this->copomex->request();
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerMunicipioPorEstado()
    {
        $this->copomex->setMethod('get_municipio_por_estado');
        $this->copomex->request('Aguascalientes');
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerCPPorMunicipio()
    {
        $this->copomex->setMethod('get_cp_por_municipio');
        $this->copomex->request('Aguascalientes');
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerColoniaPorCP()
    {
        $this->copomex->setMethod('get_colonia_por_cp');
        $this->copomex->request('09810');
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerCPPorEstado()
    {
        $this->copomex->setMethod('get_cp_por_estado');
        $this->copomex->request('Baja California Sur');
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerColoniaPorMunicipio()
    {
        $this->copomex->setMethod('get_colonia_por_municipio');
        $this->copomex->request('Valle de Bravo');
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testBusquedaCPAvanzada()
    {
        $array = [
            'limit' => '10'
        ];

        $this->copomex->setMethod('search_cp_advanced');
        $this->copomex->request('Ciudad de México', $array);
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerCPAvanzado()
    {
        $array = [
            'limit' => '10'
        ];

        $this->copomex->setMethod('get_cp_advanced');
        $this->copomex->request('Ciudad de México', $array);
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerColoniaPorEstadoYMunicipio()
    {
        $array = [
            'estado' => 'Ciudad de México',
            'municipio' => 'Iztapalapa'
        ];

        $this->copomex->setMethod('get_colonia_por_estado_municipio');
        $this->copomex->request('', $array);
        $this->assertNotTrue($this->copomex->response()['error']);
    }


    public function testObtenerCiudadesPorClaveEstado()
    {
        $this->copomex->setMethod('getCitiesByStateCode');
        $this->copomex->request('15');
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerInformacionPorDireccionYCP()
    {
        $array = [
            'type' => 'simplified',
            'calle' => 'reforma',
            'numero' => '222'
        ];

        $this->copomex->setMethod('info_cp_geocoding');
        $this->copomex->request('09810', $array);
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerCPPorGeolocalizacion()
    {

        $array = [
            'lat' => '19.42881',
            'lng' => '-99.16225'
        ];

        $this->copomex->setMethod('info_cp_geocoding_reverse');
        $this->copomex->request('', $array);
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerEstadosYClave()
    {
        $this->copomex->setMethod('get_estado_clave');
        $this->copomex->request();
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerMunicipioYClavePorEstado()
    {
        $this->copomex->setMethod('get_municipio_clave_por_clave_estado');
        $this->copomex->request('01');
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerClaveMinicipioPorEstado()
    {
        $this->copomex->setMethod('get_municipio_clave_por_estado');
        $this->copomex->request('Aguascalientes');
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerLocalidadYClavePorEstadoYMunicipio()
    {
        $array = [
            'estado' => 'Aguascalientes',
            'municipio' => 'Aguascalientes'
        ];

        $this->copomex->setMethod('get_localidad_por_estado_municipio');
        $this->copomex->request('', $array);
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerLocalidadYClavePorClaveEstadoYClaveMunicipio()
    {
        $array = [
            'clave_estado' => '01',
            'clave_municipio' => '001'
        ];

        $this->copomex->setMethod('get_localidad_por_clave_estado_municipio');
        $this->copomex->request('', $array);
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerInformacionDeLocalidad()
    {
        $array = [
            'clave_estado' => '01',
            'clave_municipio' => '001',
            'clave_localidad' => '0001'
        ];

        $this->copomex->setMethod('info_localidad');
        $this->copomex->request('', $array);
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerVialidadPorMunicipio()
    {
        $array = [
            'clave_estado' => '01',
            'clave_municipio' => '001'
        ];

        $this->copomex->setMethod('get_vialidad');
        $this->copomex->request('', $array);
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    public function testObtenerTiposVialidad()
    {
        $this->copomex->setMethod('get_tipo_vialidad');
        $this->copomex->request();
        $this->assertNotTrue($this->copomex->response()['error']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->copomex = null;
    }
}
