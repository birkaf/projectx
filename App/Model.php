<?php

namespace App;

abstract class Model
{

    const TABLE = '';

    public $id;

    public static function findAll()
    {
        $db = Db::instance();
        return $db->query(
            'SELECT * FROM ' . static::TABLE,
            [],
            static::class
        );
    }

    public static function findById($id)
    {
        $db = Db::instance();
        return $db->query(
            'SELECT * FROM ' . static::TABLE . ' WHERE id=:id',
            [':id' => $id],
            static::class
        )[0];
    }
    public static function findOneBySQLField($sqlField,$value)
    {
        $db = \App\Db::instance();   
        return $db->query(
            'SELECT * FROM ' . static::TABLE . ' WHERE '.$sqlField.'=:'.$sqlField,
            [':'.$sqlField => $value],
            static::class
        )[0];
    }
    public static function findAllBySQLField($sqlField,$value)
    {
        $db = \App\Db::instance();
        return $db->query(
            'SELECT * FROM ' . static::TABLE . ' WHERE '.$sqlField.'=:'.$sqlField,
            [':'.$sqlField => $value],
            static::class
        );
    }
    public static function countAllById($sqlField,$value)
    {
        $db = \App\Db::instance();
        return $db->query(
            'SELECT COUNT(*) as c FROM ' . static::TABLE . ' WHERE '.$sqlField.'=:'.$sqlField,
            [':'.$sqlField => $value],
            static::class
        )[0];
    }
    public function isNew()
    {
        return empty($this->id);
    }

    public function insert()
    {
        if (!$this->isNew()) {
            return;
        }

        $columns = [];
        $values = [];
        foreach ($this as $k => $v) {
            if ('id' == $k) {
                continue;
            }
            $columns[] = $k;
            $values[':'.$k] = $v;
        }
        $sql = '
                INSERT INTO ' . static::TABLE . '
                (' . implode(',', $columns) . ')
                VALUES
                (' . implode(',', array_keys($values)) . ')
                        ';
        $db = Db::instance();
        $db->execute($sql, $values);
    }
    public function update()
    { 
        $columns=[]; 
        $values=[]; 
        foreach ($this as $k => $v ){ 
            $columns[]=$k.'=:'.$k; 
            $values[':'.$k]=$v; 
        } 
        $sql = 'UPDATE '.static::TABLE.' SET '. implode(',', $columns).' WHERE id=:id'; 
        $db = Db::instance(); 
        $db->execute($sql, $values); 
    }
    public function update2($update=[],$fieldBy=[])
    {
        //        $sql = '
        //                 ' . '
        //                SET
        //                ' . implode(',', $columns) . '
        //                VALUES
        //                (' . implode(',', array_keys($values)) . ')
        //                        ';
        //        $db = Db::instance();
        //$db->execute($sql, $values);
//        foreach ($this as $k => $v) {
//            if ('id' == $k) {
//                continue;
//            }
//            $columns[] = $k;
//            $values[':'.$k] = $v;
//        }
        $db = \App\Db::instance();
        $sql =  'UPDATE `'. static::TABLE .'` SET ' . $update['name'] .'=:' . $update['name'] . ' WHERE `'.static::TABLE.'.'.$fieldBy['name'].'`=:'.$fieldBy['name'];
        $values = [];
        foreach ($update as $k => $v){
            $values[':'.$k] = $v;
        }
        foreach ($fieldBy as $k => $v){
            $values[':'.$k] = $v;
        }
        print_r($sql);
        print_r($values);
//        echo $sql;
        die;
        $db->execute($sql, $values);
//        return $db->query(
//            'UPDATE `'. static::TABLE .'` SET ' . $update['name'] .'=:' . $update['name'] . ' WHERE `'.static::TABLE.'.'.$fieldBy['name'].'`=:'.$fieldBy['name'],
//            [   ':'.$update['name'] => $update['value'],
//                ':'.$fieldBy['name'] => $fieldBy['value']],
//            static::class
//        );
    }
    //INSERT INTO `approvement` (`id`, `object`, `object_id`, `user_id`, `user_approved`, `date_time`, `comment`) 
    //VALUES (NULL, 'question', '1', '14', '1', '2017-10-19 00:00:00', NULL);
    //UPDATE `questions` SET `approved` = '1' WHERE `questions`.`id` = 2;
    //UPDATE `approvement` SET `user_id` = '13', `user_approved` = '0' WHERE `approvement`.`id` = 20;
    public static function serverAnswer($status,$message){
        $jsonArr["status"] = $status;
        $jsonArr["message"] = $message;
        echo json_encode($jsonArr);
    }
    public static function changeLocation($tmplError){
        header("Location: /moderate/$tmplError");
    }
}