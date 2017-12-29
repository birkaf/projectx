<?php

namespace App\Models;

use App\Model;
use App\MultiException;

class Approvement
    extends Model
{

    const TABLE = 'approvement';

    public $object;
    public $object_id;
    public $user_id;
    public $user_approved;
    public $date_time;
    public $comment;

    public function __get($k)
    {
    }

    public function __isset($k)
    {
    }
    public static function agreeQuestionById($qId)
    {
        $approve = new Approvement();
        $approve->user_id = User::checkLogged();
        $approve->object = 'question';
        $approve->object_id = $qId;
        $approve->user_approved = 1;
        $approve->date_time = date("Y-m-d H:i:s");
        //try
        $approve->insert();
        $approve->serverAnswer('success', 'Вопрос согласован');
    }
    public static function disAgreeQuestionById($qId,$comment)
    {
        $approve = new Approvement();
        $approve->user_id = User::checkLogged();
        $approve->object = 'question';
        $approve->object_id = $qId;
        $approve->comment = $comment;
        $approve->user_approved = 0;
        $approve->date_time = date("Y-m-d H:i:s");
        $approve->insert();
        $approve->serverAnswer('success', 'Вопрос не согласован');
    }
    public static function getApproveStatusByQId($qId,$userId)
    {
        $db = \App\Db::instance();
        return $db->query(
            'SELECT `user_approved` FROM ' . static::TABLE . ' WHERE object_id=:object_id AND user_id=:user_id',
            [':object_id' => $qId,
             ':user_id' =>  $userId],
            static::class
        )[0];
    }
    public function fill($data = []) {
    }

}