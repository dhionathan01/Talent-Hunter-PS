<?php 

    namespace App\Controllers;

    // Recursos do Framework
    use DHF\Controller\Action;
    use DHF\Model\Container;

class IndexController extends Action{

            public function index() {
                $this->render('index');
            }

        }
?>