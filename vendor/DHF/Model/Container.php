<? 
    namespace DHF\Model;
    use App\Connection;
    
    class Container {
        // Métodos staticos permitem que vc os utilizem sem a necessidade de existitr um objeto
        public static function getModel($model){

            // Retorna o modelo solicitado já instanciado, inclusive com a conexão estabelecida
            $class = "\\App\\Models\\".ucfirst($model);

            $connection = Connection::getDb();

            return new $class($connection);

        }
    }
?>