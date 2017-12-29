<?php

namespace App\Controllers;

use App\Model;
use App\Exceptions\Core;
use App\Exceptions\Db;
use App\MultiException;
use App\View;
/**
 * Класс контроллера который работает с вопросами
 */
class Question
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
    /**
     *@return View Представление для одного вопроса 
     */
    protected function actionOneQuestion()
    {
        $qId = (int)$_POST['qId'];
        if(!\App\Models\User::checkLogged()){
            //\App\Models\Question::serverAnswer('error', '');
            \App\Models\User::changeLocation('sessionError');
        } else {
            $userId = \App\Models\User::checkLogged();
            $this->view->question = \App\Models\Question::findById($qId);
            $this->view->answers = \App\Models\Answer::findByQuestionId($qId);
        
            $approve = \App\Models\Approvement::findOneBySQLField('object_id', $qId);
            $this->view->approve = $approve;
            $this->view->user = \App\Models\User::findById($approve->user_id);
        /* Для множественного согласования одного вопроса
            $this->view->approve = \App\Models\Approvement::getApproveStatusByQId($qId, $userId);
        */
            $this->view->display(__DIR__ . '/../templates/modalQuestion.php');
        }
        //!!!!!!!!!!!!!!!!!!!
        
    }
    protected function actionAgreeQuestion()
    {
        $qId = (int)$_POST['qId'];
        if(!\App\Models\User::checkLogged()){
           \App\Models\Question::serverAnswer('error', '');
            //\App\Models\Question::serverAnswer('error', 'Сессия истекла обновите страницу');
        }
        else{
            \App\Models\Approvement::agreeQuestionById($qId);
            \App\Models\Question::updateQuestionStatusById($qId, 1);
            return;
        }
        
        
    }
    protected function actionDisAgreeQuestion(){
        $qId = (int)$_POST['qId'];
        $comment = (string)$_POST['disComment'];
        if(!\App\Models\User::checkLogged()){
           \App\Models\Question::serverAnswer('error', '');
            //\App\Models\Question::serverAnswer('error', 'Сессия истекла обновите страницу');
        }
        else{
            \App\Models\Approvement::disAgreeQuestionById($qId, $comment);
            \App\Models\Question::updateQuestionStatusById($qId, 2);
            return;
        }
        
    }
    protected function actionAllNewQuestion(){
        //echo json_encode(\App\Models\Question::findAllById('approved', 0));       
        if(!\App\Models\User::checkLogged()){
            \App\Models\User::changeLocation('login');
        } else {
            $userId = \App\Models\User::checkLogged();
            $this->view->title = 'Модерация системы тестирования!';
            $this->view->questions = \App\Models\Question::findAllBySQLField('approved', 0);
            $this->view->themes = \App\Models\Theme::findAll();
                                        
            $this->view->countNewQ = \App\Models\Question::countAllById('approved', 0);
            $this->view->countAgreeQ = \App\Models\Question::countAllById('approved', 1);
            $this->view->countDisAgreeQ = \App\Models\Question::countAllById('approved', 2);

            $this->view->display(__DIR__ . '/../templates/moderate.php');
        
        }
    }
    protected function actionAllAgreeQuestion(){
        if(!\App\Models\User::checkLogged()){
            \App\Models\User::changeLocation('login');
        } else {
            $userId = \App\Models\User::checkLogged();
            $this->view->title = 'Модерация системы тестирования!';
            $this->view->questions = \App\Models\Question::findAllBySQLField('approved', 1);

            $this->view->countNewQ = \App\Models\Question::countAllById('approved', 0);
            $this->view->countAgreeQ = \App\Models\Question::countAllById('approved', 1);
            $this->view->countDisAgreeQ = \App\Models\Question::countAllById('approved', 2);
            $this->view->display(__DIR__ . '/../templates/moderate.php');
        }
        
        
    }
    protected function actionAllDisAgreeQuestion(){
        if(!\App\Models\User::checkLogged()){
            \App\Models\User::changeLocation('login');
        } else {
            $userId = \App\Models\User::checkLogged();
            $this->view->title = 'Модерация системы тестирования!';
            $this->view->questions = \App\Models\Question::findAllBySQLField('approved', 2);

            $this->view->countNewQ = \App\Models\Question::countAllById('approved', 0);
            $this->view->countAgreeQ = \App\Models\Question::countAllById('approved', 1);
            $this->view->countDisAgreeQ = \App\Models\Question::countAllById('approved', 2);
            $this->view->display(__DIR__ . '/../templates/moderate.php');
        }
    }
}
