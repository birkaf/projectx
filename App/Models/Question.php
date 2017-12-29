<?php

namespace App\Models;

use App\Model;
use App\MultiException;

class Question
    extends Model
{

    const TABLE = 'questions';

    public $question_text;
    public $id_theme;
    public $approved;
    public $user_id;

    public function __get($k)
    {
        switch ($k) {
            case 'themes':
                return Theme::findById($this->id_theme);
                break;
            default:
                return null;
        }
    }

    public function __isset($k)
    {
        switch ($k) {
            case 'themes':
                return !empty($this->id_theme);
                break;
            default:
                return false;
        }
    }
    public static function findAllBySQLField($sqlField,$value)
    {
        $db = \App\Db::instance();
        return $db->query(
            'SELECT * FROM ' . static::TABLE . ' WHERE '.$sqlField.'=:'.$sqlField . ' AND deleted=0',
            [':'.$sqlField => $value],
            static::class
        );
    }
    public function fill($data = []) {
    }
    public static function updateQuestionStatusById($qId,$status)
    {
        $question = Question::findById($qId);
        $question->approved = $status;
        $question->update();
    }

}