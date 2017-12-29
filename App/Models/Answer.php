<?php

namespace App\Models;

use App\Model;
use App\MultiException;

class Answer
    extends Model
{

    const TABLE = 'answers';

    public $id_question;
    public $answer_text;
    public $correct;

    public function __get($k)
    {
    }

    public function __isset($k)
    {
    }
    public static function findByQuestionId($qId)
    {
        $db = \App\Db::instance();
        return $db->query(
            'SELECT * FROM ' . static::TABLE . ' WHERE id_question=:id_question',
            [':id_question' => $qId],
            static::class
        );
    }
    public function fill($data = []) 
    {
    }

}