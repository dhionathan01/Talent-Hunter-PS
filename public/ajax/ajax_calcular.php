<?     
    include('../funcoes_centralizadas.php');
    header('Content-Type: application/json'); 


    function calcularNoturna(){

    }
    function calcularHoraTrabalhada($data_inicial, $data_final){
        $dateS1 = new DateTime($data_inicial);
        $dateS2 = new DateTime($data_final);
        
        $data_inicio_str = $dateS1->format('Y-m-d H:i:s');
        $data_fim_str = $dateS2->format('Y-m-d H:i:s');
        if(strtotime($data_fim_str) < strtotime($data_inicio_str)){
            return array('status' => 'fail');
        }

        $hora_inicio = explode(' ', $data_inicio_str);
        $data_ini = $hora_inicio[0];
        $hora_inicio = $hora_inicio[1];

        $hora_fim = explode(' ', $data_fim_str);
        $data_final = $hora_fim[0];
        $hora_fim = $hora_fim[1];

        $dateS1 = new DateTime($data_inicio_str);
        $dateS2 = new DateTime($data_fim_str);
        
        $dateDiff = $dateS1->diff($dateS2);

        $dia = str_pad($dateDiff->d, 1, "0", STR_PAD_LEFT);
        $hora = str_pad($dateDiff->h, 1, "0", STR_PAD_LEFT);
        $minuto =  str_pad($dateDiff->i, 1, "0", STR_PAD_LEFT);

        $tempoCorrido = array(
            'dia' => $dia,
            'hora' => $hora,
            'minuto'=> $minuto);
        $dia_hora = ($tempoCorrido['dia'] * 24) + $tempoCorrido['hora'];
        $hora_minuto = ($dia_hora * 60) + $tempoCorrido['minuto'];
        $tempoCalculado = array(
            'total_em_minutos'=> $hora_minuto,
            'total_em_horas' => $dia_hora
        );
        $cabecalho = array(
            'data_inicio' =>$data_inicio_str,
            'data_fim' =>$data_fim_str,
            'hora_inicio'=> $hora_inicio,
            'hora_fim'=> $hora_fim
        );


        
            $horario_noturno_inicio = new DateTime("$data_ini 23:00:00");
            $horario_noturno_fim = new DateTime("$data_final 05:00:00");
            $horario_noturno_fim_pos = new DateTime("$data_ini 05:00:00");
            $horario_noturno_fim_pos ->add(new DateInterval("P1D"));
            $minutos_noturnos = 0;
            $minutos_diurnos = 0;
        for($minInicial = 0; $minInicial < $hora_minuto; $minInicial+= 60){
            $test =  $minInicial+60;
            if(($hora_minuto - ($test)) < 60){
            $addMinuto =  $hora_minuto - $minInicial ;
            }else{
                $addMinuto =  60;
            }
            $data_initCalc = $dateS1->add(new DateInterval("PT{$addMinuto}M"));

            if(strtotime($data_initCalc->format('Y-m-d H:i:s')) < strtotime($horario_noturno_inicio->format('Y-m-d H:i:s'))){
                $ativarContadorDiurno = true;
                if($ativarContadorDiurno){
                    $minutos_diurnos += $addMinuto;
                    if(strtotime($data_initCalc->format('Y-m-d H:i:s')) <= strtotime($horario_noturno_fim->format('Y-m-d H:i:s'))){
                        $ativarContadorDiurno = false;
                    }
                }
            }
            if(strtotime($data_initCalc->format('Y-m-d H:i:s')) > strtotime($horario_noturno_inicio->format('Y-m-d H:i:s'))){
                $ativarContadorNoturno = true;
                if($ativarContadorNoturno){
                    $minutos_noturnos += $addMinuto;
                    if(strtotime($data_initCalc->format('Y-m-d H:i:s')) >strtotime($horario_noturno_fim_pos->format('Y-m-d H:i:s'))){
                        $ativarContadorNoturno = false;
                    }
                }
            }
            $data_print = $data_initCalc->format('Y-m-d H:i:s');

        }
       
        $horas_noturnas = round($minutos_noturnos / 60,2);
        $horas_diurnas = round($minutos_diurnos / 60,2);
        $conteudo = array(
            'status' => 'success',
            'cabecalho' => $cabecalho,
            'tempoCorrido' => $tempoCorrido,
            'tempoCalculado' => $tempoCalculado,
            'diurno' => $horas_diurnas,
            'noturno' => $horas_noturnas,
        );
        
        return $conteudo;
        
    }
    $dadosDeCalculo =  calcularHoraTrabalhada($_POST['horario_entrada'], $_POST['horario_saida']);

    echo json_encode($dadosDeCalculo);
?>