<?php

namespace Src;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Copomex
{
    private const URL = 'https://api.copomex.com/query/';
    private string $method = '';
    private string $search = '';
    private array $variable = [];
    private string $token = '';
    private string $endpoint = '';
    private array|null $response = null;
    private array $error = [];
    private Logger $log;

    public function __construct(string $token)
    {
        $this->log = new Logger("copomex");
        $this->log->pushHandler(new StreamHandler(getcwd() . "/copomex.log",Level::Debug));
        $this->token = $token;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function request(string $search = '', array $variable = []): void
    {

        try {

            $this->search = $search;
            $this->variable = $variable;
            $this->endpoint = $this->buildUrl();
            $response = $this->sentRequest($this->endpoint);

            if (is_null($response)) {
                $this->log->warning(
                    "Se obtuvo una respuesta nula del API de {$this->endpoint}",
                    [date('Y-m-d H:i:s')]
                );
                throw new \Exception("No se identifica la búsqueda");
            }

            $this->response = $response;
        } catch (\Exception $e) {
            $this->error = [
                'error' => true,
                'error_message' => $e->getMessage()
            ];
        }
    }

    private function buildUrl(): string
    {

        if ($this->token == '') {
            $this->log->warning(
                "Se debe proporcionar un token en archivo .env",
                [date('Y-m-d H:i:s')]
            );
            throw new \Exception("Se requiere el token");
        }

        $token = "token={$this->token}";
        $prefix = self::URL . "{$this->method}/{$this->search}?";
        $endpoint =  $prefix  .  $token;

        if (!empty($this->variable)) {
            $variable = http_build_query($this->variable);
            $endpoint = "{$prefix}{$variable}&{$token}";
        }

        return $endpoint;
    }

    private function sentRequest($endpoint): array|null
    {

        $url = str_replace(" ", "%20", $endpoint);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $this->log->error(
                curl_error($ch),
                [date('Y-m-d H:i:s')]
            );
            throw new \Exception('No se pudo realizar la solicitud');
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    public function response(): array|null
    {
        return !empty($this->error) ? $this->error :  $this->response;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function error(): array
    {
        return $this->error;
    }
}
