<?php
//Создаем сессию или если уже сессия была создана мы ее возобновляем
session_start();

class Database {
    private $host = 'localhost';
    private $user = 'root'; //Указываем своего пользователя
    private $password = ""; //Указываем пароль для указанного пользователя
    private $database = "phpCustomShop"; //ваша ранее созданная БД

    public function getConnection() {
        // mysqli это то же самое что и mysqli_connect
        // только этот вариант из ООП, а не из функционального программирования
        $conn = new mysqli($this->host,$this->user,$this->password,$this->database);
        mysqli_set_charset($conn,'utf8');
        
        if ($conn->connect_error) {
            die ("Ошибка подключения к БД:" . $conn->connect_error);
        } else {
            return $conn;
        }
    }
}

?>