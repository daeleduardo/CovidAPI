<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Http\Services\CovidService;
use stdClass;

class CovidController extends Controller
{

    private $_covidService = "";
    /**
     * Cria uma instância de CovidService
     *
     * @return void
     */
    public function __construct()
    {
        $this->_covidService = new CovidService();
    }

    /**
     * Função que consome o serviço CovidService e retorna em formato JSON
     *
     * @return mixed
     * @throws Exception
     **/
    public function casosMensais()
    {
        $status = Response::HTTP_OK;
        $headers = [
            "Content-Type" => "application/json",
            "Access-Control-Allow-Origin" => "*"
        ];
        $return = [
            'data' => [],
        ];        
        try {
            $casosConfirmados = $this->_covidService->obterCasosConfirmados();
                

            if (!empty($casosConfirmados)) {
                $somas = [];
                foreach ($casosConfirmados as $caso) { 
                    $ano = substr($caso['Date'], 0, 4);
                    $mes = substr($caso['Date'], 5, 2);
                    $total = $somas[$ano.$mes] ?? 0 ;
                    $somas[$ano.$mes] = $total + ($caso['Cases'] ?? 0 );
                }

                foreach ($somas as $chave => $valor) {
                    $obj = new stdClass();
                    $ano = substr($chave, 0, 4);
                    $mes = substr($chave, 4, 2);

                    $obj->ano = $ano;
                    $obj->mes = $mes;
                    $obj->total = $valor;
                    $return['data'][] = $obj;
                }
            }
            

        } catch (\Throwable $th) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $return = [
                'error' => $th->getMessage()
            ];
        } finally {
            return response()->json($return, $status, $headers);
        }
    }
}
