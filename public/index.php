<? 
    function exibirArray($array){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
    
    require_once"../vendor/autoload.php";
    $route = new \App\Route;
?>