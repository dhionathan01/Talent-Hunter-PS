<? 
    function exibirArray($array){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

    function diffTime($horario_entrada, $horario_saida){

        $diff = (strtotime($horario_saida) - strtotime($horario_entrada));

        $horas =  floor($diff / 60 / 60);
        $minutos = round(($diff - ($horas * 60 *60)) / 60);

        $hora = str_pad($horas, 2, "0", STR_PAD_LEFT);
        $minuto = str_pad($minutos, 2, "0", STR_PAD_LEFT);
        
        $horas_trabalhadas = "$hora:$minuto";
        return $horas_trabalhadas;

    }
    
    require_once"../vendor/autoload.php";
    $route = new \App\Route;

    echo $horas_trabalhadas =  diffTime($_POST['horario_entrada'], $_POST['horario_saida']);
    
?>