<?php

namespace App\Http\Controllers;

use App\Enums\CategoriaOperacaoEnum;
use App\Models\Categoria;
use App\Models\Chirp;
use App\Models\Lancamento;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

class DashboardController extends Controller
{

    public function index(): View
    {
        return view('dashboard', [
            'lancamentos' => $this->lancamentosMes(),
            'chirps' => Chirp::with('user')->get(),
        ]);
    }

    private function lancamentosMes()
    {
        //$lancamentos = DB::table('lancamentos')
        //    ->select(DB::raw('YEAR(data_referencia) ano, MONTH(data_referencia) mes, categoria_id, sum(valor) as valor_total'))
        //    ->groupBy('ano', 'mes', 'categoria_id')
        //    ->orderBy('ano', 'desc')
        //    ->orderBy('mes', 'asc')
        //    ->get();
        $lancamentos = DB::table('lancamentos')
            ->select(DB::raw('strftime("%Y", data_referencia) ano, strftime("%m", data_referencia) mes, strftime("%Y%m", data_referencia) mes_ano, categoria_id, sum(valor) as valor_total'))
            ->groupBy('ano', 'mes', 'categoria_id')
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'asc')
            ->get();

        $meses = [
            '01' => 'jan',
            '02' => 'fev',
            '03' => 'mar',
            '04' => 'abr',
            '05' => 'mai',
            '06' => 'jun',
            '07' => 'jul',
            '08' => 'ago',
            '09' => 'set',
            '10' => 'out',
            '11' => 'nov',
            '12' => 'dez'
        ];
        foreach ($lancamentos as $lancamento) {
            $categoria = Categoria::find($lancamento->categoria_id);
            $dados[$lancamento->categoria_id]['categoria_nome'] = $categoria->nome;
            $dados[$lancamento->categoria_id]['categoria_operacao'] = $categoria->operacao->value;
            $dados[$lancamento->categoria_id]['categoria_id']  = $lancamento->categoria_id;

            $multiplicador = -1;
            $cor = 'danger';
            if ($categoria->operacao->value === 'entrada') {
                $multiplicador = 1;
                $cor = 'primary';
            }
            $dados[$lancamento->categoria_id]['color']  = $cor;
            $dados[$lancamento->categoria_id][$meses[$lancamento->mes]] = $lancamento->valor_total * $multiplicador;
        }

        $dados = $this->arrayOrdenado($dados, 'categoria_operacao');

        foreach ($dados as $key => $infomensal) {

            $total = 0.0;
            foreach ($meses as $mes) {

                if (!array_key_exists($mes, $infomensal)) {
                    $infomensal[$mes] = 0.0;
                }
                $total += $infomensal[$mes];
            }

            $infomensal['valor_total'] = $total;
            $dados[$key] = (object)$infomensal;
        }

        return collect($dados);
    }

    private function arrayOrdenado(array $array, string $campo, int $ordem = SORT_ASC): array
    {
        $novo = array();
        $ordenado = array();

        if(count($array) > 0){
            foreach($array as $key => $value){
                if(is_array($value)){
                    foreach($value as $key2 => $value2){
                        if($key2 == $campo){
                            $ordenado[$key] = $value2;
                        }
                    }
                } else {
                    $ordenado[$key] = $value;
                }
            }

            switch($ordem){
                case SORT_ASC:
                    asort($ordenado);
                    break;
                case SORT_DESC:
                    arsort($ordenado);
                    break;
            }
            foreach($ordenado as $chave => $valor){
                $novo[$chave] = $array[$chave];
            }
        }
        return $novo;
    }
}
