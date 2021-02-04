<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            
            $editais = DB::table('editais')->where('id', '!=', 20)->where('deleted_at', NULL)->get();

            foreach ($editais as $edital) {
                switch ($edital->status_edital_id) {
                    case 1:
                        if( \Carbon\Carbon::now()->gte($edital->homologacoes_inscricoes) )
                            $id = 2;
                        break;
                    case 2:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_recurso_inscricao) )
                            $id = 3;
                        break;
                    case 3:
                        if( \Carbon\Carbon::now()->gte($edital->homologacao_final) )
                            $id = 4;
                        break;
                    case 4:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_proeficiencia) )
                            $id = 5;
                        break;
                     case 5:
                        if( \Carbon\Carbon::now()->gte($edital->aprovados_primeira_fase) )
                            $id = 6;
                        break;
                     case 6:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_recurso_primeira_fase) )
                            $id = 7;
                        break;
                     case 7:
                        if( \Carbon\Carbon::now()->gte($edital->resultado_final_primeira_fase) )
                            $id = 8;
                        break;
                     case 8:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_ccint) )
                            $id = 9;
                        break;
                     case 9:
                        if( \Carbon\Carbon::now()->gte($edital->resultado_segunda_fase) )
                            $id = 10;
                        break;
                     case 10:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_recurso_segunda_fase) )
                            $id = 11;
                        break;
                     case 11:
                        if( \Carbon\Carbon::now()->gte($edital->resultado_final_segunda_fase) )
                            $id = 12;
                        break;
                     case 12:
                        if( \Carbon\Carbon::now()->gte($edital->reuniao_esclarecimentos) )
                            $id = 13;
                        break;
                     case 13:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_entrega_documentos) )
                            $id = 14;
                        break;
                     case 14:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_avaliacao_documentos) )
                            $id = 15;
                        break;
                     case 15:
                        if( \Carbon\Carbon::now()->gte($edital->envio_candidaturas) )
                            $id = 16;
                        break;
                     case 16:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_recepcao_carta) )
                            $id = 17;
                        break;
                     case 17:
                        if( \Carbon\Carbon::now()->gte($edital->divulgacao_resultado_terceira_fase) )
                            $id = 18;
                        break;
                     case 18:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_aquisicoes) )
                            $id = 19;
                        break;
                     case 19:
                        if( \Carbon\Carbon::now()->gte($edital->inicio_mobilidade) )
                            $id = 20;
                        break;
                }

                DB::table('editais')->where('id', $edital->id)->update(['status_edital_id' => $id]);

            }

            //dd($editais);

        })->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
