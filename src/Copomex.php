<?php

namespace Src;

class Copomex
{
    private const URL = 'https://api.copomex.com/query/';
    private string $method;
    private string $search;
    private array $variable;
    private string $token;
    private string $endpoint;
    private array|null $response;
    private array|null $error;

    public function __construct($method, $token)
    {
        $this->token = $token;
        $this->method = $method;
        $this->error = null;
    }

    public function request(string $search = '', array $variable = []): void
    {

        try {

            $this->search = $search;
            $this->variable = $variable;
            $this->endpoint = $this->buildUrl();
            $response = $this->sentRequest($this->endpoint);

            if(is_null($response)){
                $this->response = $response;
                throw new \Exception("Search not identified");
            }

            $this->response = $response;

        } catch (\Exception $e) {
            $this->error = [
                'error'=> true,
                'error_message'=> $e->getMessage()
            ];
        }
    }

    private function buildUrl()
    {

        $token = 'token=' . $this->token;
        $prefix = self::URL . $this->method . '/' . $this->search . '?';
        $endpoint =  $prefix  .  $token;

        if (!empty($this->variable)) {
            $variable = http_build_query($this->variable);
            $endpoint = $prefix .  $variable . '&' .  $token;
        }

        return $endpoint;
    }

    private function sentRequest($endpoint)
    {

        $url = str_replace(" ", "%20", $endpoint);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            throw new \Exception($error);
        }

        curl_close($ch);

        $result = json_decode($response, true);

        return $result;
    }

    public function response(): array|null
    {

        if (!empty($this->error)) {
            return $this->error;
        }
        
        return $this->response;
    }

    public function error(): array
    {
        return $this->error;
    }
}
