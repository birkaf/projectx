<?php
/*Попадет только если пользователь сотрет адрес до http://Host/moderate*/
namespace App\Controllers;

use App\Exceptions\Core;
use App\Exceptions\Db;
use App\MultiException;
use App\View;

class Site
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

    protected function actionIndex()
    {
        if(!\App\Models\User::checkLogged()){
            \App\Models\User::changeLocation('login');
        } else {
            $userId = \App\Models\User::checkLogged();

            $this->view->title = 'Модерация системы тестирования!';
            $this->view->questions = \App\Models\Question::findAll();
            $this->view->countNewQ = \App\Models\Question::countAllById('approved', 0);
            $this->view->countAgreeQ = \App\Models\Question::countAllById('approved', 1);
            $this->view->countDisAgreeQ = \App\Models\Question::countAllById('approved', 2);
            $this->view->users_approves = \App\Models\Approvement::findAllBySQLField('user_id', $userId);
            $this->view->display(__DIR__ . '/../templates/moderate.php');
        }
    }
    protected function actionAbout()
    {
        if(!\App\Models\User::checkLogged()){
            \App\Models\User::changeLocation('login');
        } else {
            $this->view->title = 'О проекте';
            $this->view->display(__DIR__ . '/../templates/about.php');
        }
    }
}
