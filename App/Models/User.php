<?php

namespace App\Models;

use App\Model;
//use App\Exceptions\Core;
use App\MultiException;
//use App\View;

class User extends Model
{
    const TABLE = 'users';

    //public $email;
    //protected  $userData;
    static protected $userId;
    public function __get($k)
    {

    }

    public function __isset($k)
    {
    }

    public function __construct($userId = null) {
//        if ($userId != null) {
//            if (!$this->getInfo($userId)) {
//                return false;
//            }
//        }
    }
    public function getInfo($userId) {
//        $this->userData = \App\Models\User::findById($userId);
    }

    public function fill($data = []) {
        $e = new MultiException();
        if(isset($data)){
            foreach ($data as $k => $v) {
                if(''!=($v)){
                    $this->$k = $v;
                }
                else{
                    $e[] = new \Exception('ключ '.$k.' не имеет значение');
                }
            }
        }else{
            $e[] = new \Exception('Неверные POST данные');
        }
        if(is_object($e->current())) throw $e;
        return;
    }

    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }
    public static function authenticate($password,$username) {
        try { 
            $passStatus = self::checkPassword($password,$username);
            //echo 'end';
            //die;
        } catch (MultiException $e) {
               throw $e;
        }

        //var_dump($passStatus);
//        die;
        if(TRUE == $passStatus){
            //var_dump(static::$userId);
            //var_dump(self::$userId);
            //$u = new User(self::$userId);
            $u = User::findById(self::$userId);
            //$user = 
            //
//            echo '<pre>';
//            var_dump($u->last_login);
//            echo '</pre>';
//            die;
            $u->last_login = date("Y-m-d H:i:s");
            $u->update();
            \App\Models\User::auth(self::$userId);
//            echo '<pre>';
//            //print_r($u->last_login);
//
//            var_dump($u->userData->last_login);//->userData[0]->last_login
//            echo '</pre>';
//            die;
            
//            $check = \MVC\Db::prepare('SELECT id, username, email, registered FROM users WHERE username = ? AND password = ? LIMIT 1');
//            $check->bind_param('ss', $username, $password);
//            $check->execute();
//            $check->store_result();
//            // Return false if no match found
//            if ($check->num_rows == 0) {
//                $check->close();
//                return false;
//            }
//            // Setup a new user instance
//            $user = new self;
//            $check->bind_result(
//                $userId,
//                $userUsername,
//                $userEmail,
//                $userRegistered
//            );
//            $check->fetch();
//            $check->close();
//            $user->id = $userId;
//            $user->username = $userUsername;
//            $user->email = $userEmail;
//            $user->registered = $userRegistered;
        }
        // Retrieve data from the database
        //return $user;
        
    }
    public static function checkPassword($password,$username) {
        $e = new MultiException();
        $sqlRezult = self::findOneBySQLField('login', $username);
            if(isset($sqlRezult)){
                if (md5(md5($password).$sqlRezult->salt) == $sqlRezult->password){
                    self::$userId = $sqlRezult->id;
                    return TRUE;
                }else{
                    $e[] = new \Exception('Не правильные данные для авторизации');
                }
            }else{
                $e[] = new \Exception('Пользователь с логином: '.$username.' не зарегистрирован');
            }
        if(is_object($e->current())) throw $e;
        return;   
    }
    
    public static function checkLogged()//$tmplError
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return FALSE;
        //header("Location: /moderate/$tmplError");
    }
}