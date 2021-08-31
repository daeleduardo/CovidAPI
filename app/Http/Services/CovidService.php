<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;

class CovidService
{
    /**
     * ObterCasosConfirmados método que consome o covidService
     *
     * Método que recebe a solicitação, consome e formata os dados de covidService
     *
     * @return any
     * @throws Throwable
     **/
    public function obterCasosConfirmados()
    {
        try {
            $endpoint = 'https://api.covid19api.com/country/brazil/status/confirmed';
            return Http::get($endpoint)->json();
        } catch (\Throwable $th) {
            $headers = ["Content-Type" => "application/json"];
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $data = [
                'error' => $th->getMessage()
            ];
            return response()->json($data, $status, $headers);
        }
    }
}