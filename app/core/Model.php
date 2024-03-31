<?php
class Model{
    protected static $_connection = null;

    public function __construct(){
        if(self::$_connection == null){
            $host = 'localhost';
            $dbname = 'shopping';
            $user = 'shopping_user';
            $password = 'GX37kr/ywR_mkGwo';
            self::$_connection = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
        }
    }
}
?>