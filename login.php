<?php
include_once 'config/config.php';
include_once 'config/class/User.php';

$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);
if ($customer->loggedIn()) {
    header("Location: index.php");
}
$loginMessage = '';
if (!empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
    $customer->email = $_POST["email"];
    $customer->password = $_POST["password"];
    $customer->loginType = $_POST["loginType"];
    if ($customer->login()) {
        header("Location: index.php");
    } else {
        $loginMessage = 'Неверные данные! Пожалуйста, попробуйте еще раз.';
    }
} else {
    $loginMessage = 'Заполните все поля';
}
include('config/components/header.php');?>

<style>
    header {
        display: none;
    }
    body {
        height:100vh;
        width:100%;
        display:flex;
        align-items:center;
    }
    .container {
        width:100%;
    }
</style>

<div class="login">
    <div class="bg_white">
        <h1>Вход для клиентов</h1>
            <?php if ($loginMessage != '') {?>
                <div id="login-alert" class="alert-danger"><?php echo $loginMessage?></div>
            <?php } ?>
            <form id="loginform" role="form" method="POST" action="">
                <input 
                    type="text"
                    id="email"
                    name="email"
                    value="<?php if(!empty($_POST["email"])) { echo $_POST["email"]; }?>"
                    placeholder="Электронный адрес"
                    required    
                >
                <input
                    type="password"
                    id="password"
                    name="password"
                    value="<?php if (!empty($_POST["password"])) { echo $_POST["password"]; }?>"
                    placeholder="Пароль"
                    required
                >
                <input type="submit" name="login" value="Войти" class="btn checkout">
            </form>
        </div>
    </div>
    <div class="img"></div>
</div>