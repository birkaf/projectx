<?php
namespace App\Controllers;

use App\Exceptions\Core;
use App\Exceptions\Db;
use App\MultiException;
use App\View;

class User
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function action($action)
    {
        $methodName = 'action' . $action;
        $this->beforeAction();
        return $this->$methodName();
    }

    protected function beforeAction()
    {
    }
    protected function actionLogin()
    {        
        $this->view->title = 'Система модерации | Авторизация';
        $this->view->display(__DIR__ . '/../templates/login.php');
    }
    protected function actionSessionError()
    {        
        $this->view->display(__DIR__ . '/../templates/sessionError.php');
    }
    protected function actionAuth()
    {
        /*
        function inverse($x) {
            if (!$x) {
                throw new \Exception('Деление на ноль.');
        }
            return 1/$x;
        }
        try {
            echo inverse(5) . "\n";
            echo inverse(0) . "\n";
        } catch (\Exception $e) {
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        }
        die('End');
        */
        $e = new MultiException();
        $user = new \App\Models\User();
        try {    
            $user->fill($_POST);
        } catch (MultiException $e) {
            $this->view->errors = $e;
            $this->view->display(__DIR__ . '/../templates/login.php');
            return;
        }
           
//            var_dump($user);
//            die;
        try { 
            \App\Models\User::authenticate($user->userPass, $user->userLogin);
            header("Location: /moderate/ajaxNewQ");
//            var_dump($user);
//            die('test');
            /*
            $sqlRezult = \App\Models\User::findOneBySQLField('login', $user->userLogin);
            if(isset($sqlRezult)){
                if (md5(md5($user->userPass).$sqlRezult->salt) == $sqlRezult->password){
                    \App\Models\User::auth($sqlRezult->id);
                    header("Location: /moderate/ajaxNewQ");
                }else{
                    $e[] = new \Exception('Не правильные данные для авторизации');
                    throw $e;   
                }
            }else{
                // Если данные не правильные, генерим исключение
                $e[] = new \Exception('Не правильные данные для авторизации');
                throw $e;   
            }
             * 
             */
            //var_dump($this->userLogin);
        
        } catch (MultiException $e) {
            //var_dump($e);
            //die;
            $this->view->errors = $e;
            $this->view->display(__DIR__ . '/../templates/login.php');
        }
    }
}
