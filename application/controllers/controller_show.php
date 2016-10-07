<?php

class Controller_Show extends Controller
{
    function __construct()
    {
        $this->model = new Model_Show();
        $this->view = new View();
    }    
    
    function action_index($id,$time)
    {		
        $data['id']=$id;
        $data['timestart']=$time;
        $data['file'] = $this->model->show_file($data['id']);
        if (!is_null($data['file'])){
            $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li>'
                    .$data['file']['meta']['title'].
                    '</li></ul>';        
            $this->view->generate('show_view.php', 'public_view.php', $data);
        }else{
            echo 'Лол файл не открыт для публичного доступа.';
        }
    }
}
