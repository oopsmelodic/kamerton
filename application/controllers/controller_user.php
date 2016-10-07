<?php

class Controller_User extends Controller
{
    
        function __construct()
        {
            $this->model = new Model_User();
            $this->view = new View();
            $this->controller = new Controller();
        }    
	
        function action_getName(){
            return "work";
        }
        
	function action_index()
	{
		session_start();
                if($this->controller->check_session()){
                    $data['user_name'] = '';
                    $data['breadcrumb'] = '<ul class="breadcrumb"><li>Главная</li></ul>';
                    $data['user_name'] = $_SESSION['user']['login'];
                    $this->view->generate('userMain_view.php', 'user_view.php',$data);
		}
		else
		{
			session_destroy();
			Route::loop();
		}

	}
	
        function action_files(){
            session_start();
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li>Список Записей</li></ul>';
                $this->view->generate('userFileList_view.php', 'user_view.php',$data);
            }
        }
        
        function action_settings(){
            session_start();     
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];    
                $data['user'] =  $this->model->getSettings($_SESSION['user']['id']);
                //$data['file'] = $this->model->show_file($_SESSION['user']['id'],$data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li>Настройки</li></ul>'; 
                $this->view->generate('settings_view.php', 'user_view.php',$data);
            }
        }
        function action_upload(){
            session_start();     
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];    
                $data['user'] =  $this->model->getSettings($_SESSION['user']['id']);
                //$data['file'] = $this->model->show_file($_SESSION['user']['id'],$data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li>Загрузка</li></ul>'; 
                $this->view->generate('upload_view.php', 'user_view.php',$data);
            }
        }
        
        function action_ftp(){
            session_start();     
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];    
                $data['user'] =  $this->model->getSettings($_SESSION['user']['id']);
                //$data['file'] = $this->model->show_file($_SESSION['user']['id'],$data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li>Настройки FTP</li></ul>'; 
                $this->view->generate('ftp_view.php', 'user_view.php',$data);
            }
        }
        
        function action_shedule(){
            session_start();     
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];    
                $data['user'] =  $this->model->getSettings($_SESSION['user']['id']);
                //$data['file'] = $this->model->show_file($_SESSION['user']['id'],$data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li>Расписание</li></ul>'; 
                $this->view->generate('shedule_view.php', 'full_view.php',$data);
            }
        }
        
        function action_profile(){
            session_start();     
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];    
                $data['user'] =  $this->model->getSettings($_SESSION['user']['id']);
                //$data['file'] = $this->model->show_file($_SESSION['user']['id'],$data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li>Профиль</li></ul>'; 
                $this->view->generate('profile_view.php', 'user_view.php',$data);
            }
        }
        
        function action_alerts(){
            session_start();     
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];    
                $data['user'] =  $this->model->getSettings($_SESSION['user']['id']);
                //$data['file'] = $this->model->show_file($_SESSION['user']['id'],$data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li>Уведомления</li></ul>'; 
                $this->view->generate('alerts_view.php', 'user_view.php',$data);
            }
        }
        
        function action_tasks(){
            session_start();           
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];    
                $data['user'] =  $this->model->getSettings($_SESSION['user']['id']);
                //$data['file'] = $this->model->show_file($_SESSION['user']['id'],$data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li>Задачи</li></ul>'; 
                $this->view->generate('tasks_view.php', 'user_view.php',$data);
            }
        }
        
        function action_settingsUpdate(){
            session_start();
            $this->model->saveSettings($_SESSION['user']['id'],$_POST);
            header('Location:/user');
            //$this->view->generate('userMain_view.php', 'user_view.php',$data);
        }
        
        function action_show($id,$time){
            session_start();     
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];            
                $data['id']=$id;
                $data['timestart']=$time;
                $data['file'] = $this->model->show_file($data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li><a href="/user/files/">Список Записей</a></li><li>'
                        .$data['file']['meta']['title'].
                        '</li></ul>';
                $this->view->generate('show_view.php', 'full_view.php',$data);
            }
        }
        
        function action_showold($id,$time){
            session_start();     
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];            
                $data['id']=$id;
                $data['timestart']=$time;
                $data['file'] = $this->model->show_file($data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li><a href="/user/files/">Список Записей</a></li><li>'
                        .$data['file']['meta']['title'].
                        '</li></ul>';
                $this->view->generate('show_view_1.php', 'full_view.php',$data);
            }
        }
        
        function action_showNew($id,$time){
            session_start();     
            if($this->controller->check_session()){
                $data['user_name'] = $_SESSION['user']['login'];            
                $data['id']=$id;
                $data['timestart']=$time;
                $data['file'] = $this->model->show_file($data['id']);
                $data['breadcrumb'] = '<ul class="breadcrumb"><li class="active"><a href="/user/">Главная</a></li><li><a href="/user/files/">Список Записей</a></li><li>'
                        .$data['file']['meta']['title'].
                        '</li></ul>';        
                $this->view->generate('showtest_view.php', 'full_view.php',$data);
            }
        }
        
	// Действие для разлогинивания администратора
	function action_logout()
	{
            session_start();
            session_destroy();
            header('Location:/');
	}

}
