<?php
class Customer {
    private $customerTable = 'users'; // имя таблицы с пользователями
    private $conn; //переменная для работы с БД

    public function __construct($db) { //Конструктор с 1 перменной
        //передаем значение для подключения к БД (переменную $db -
        // получаем при создании экземпляра класса)
        $this->conn = $db;
    }

    public function login() {
        if ($this->email && $this->password) { //если мы получили данные
            $sqlQuery = "
                SELECT * FROM ".$this->customerTable."
                WHERE email = ? AND password = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            //Когда мы передаем запрос в prepare(), на место подставляемых данных
            //подставляем специальные маркеры. А сами данные передаем после, в execute()
            // спец символы мы видим "?"
            $password = md5($this->password);
            //возвращает md5-хэш строки, мы данную функцию использовали ранее и она была расписана
            $stmt->bind_param("ss",$this->email,$password);
            // осуществляем привязку переменных к параметрам подготавливаемого запроса
            $stmt->execute();
            // передаем данные
            $result = $stmt->get_result();
            // get_result() - получаем результат из подготовленного запроса
            if ($result->num_rows > 0) { //если данные есть, то проверяем их с данными в бд
                $user =  $result->fetch_assoc();
                $_SESSION["userid"] = $user['id'];
                $_SESSION["name"] = $user['name'];
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function loggedIn() {
        if (!empty($_SESSION["userid"])) {
            return 1;
        } else {
            return 0;
        }
    }

    function getAddress() {
        if($_SESSION["userid"]) {
            $stmt = $this->conn->prepare("
                SELECT email, phone, address
                FROM ".$this->customerTable."
                WHERE id='".$_SESSION["userid"]."'");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }
    }
}
?>