<?php
include_once 'config/config.php';
include_once 'config/class/User.php';

$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);

if (!$customer->loggedIn()) {
    header("Location: login.php");
}
?>

<?php if (isset($_POST["add"])) {
    if(isset($_SESSION["cart"])) {
        $item_array_id = array_column($_SESSION["cart"],"product_id");
        if (!in_array($_GET["id"],$item_array_id)) {
            $count = count($_SESSION["cart"]);
            $item_array = array(
                'product_id'=>$_GET["id"],
                'item_name' => $_POST["item_name"],
                'item_price' => $_POST["item_price"],
                'item_id' => $_POST["item_id"],
                'item_quantity' => $_POST["quantity"]
            );
            $_SESSION["cart"][$count] = $item_array;
            echo '<script>window.location="cart.php"</script>';
        } else {
            echo '<script>window.location="cart.php"</script>';
        }
    } else {
        $item_array = array(
            'product_id'=>$_GET["id"],
            'item_name' => $_POST["item_name"],
            'item_price' => $_POST["item_price"],
            'item_id' => $_POST["item_id"],
            'item_quantity' => $_POST["quantity"]
        );
        $_SESSION["cart"][0] = $item_array;
    }
} ?>

<?php
//удаление товара по однму (напротив каждого товара)
if(isset($_GET["action"])) {
    if($_GET["action"] == "delete") {
        foreach($_SESSION["cart"] as $keys => $values) {
            if($values["product_id"] == $_GET["id"]) {
                unset($_SESSION["cart"][$keys]);
                echo '<script>window.location="cart.php"</script>';
            }
        }
    }
}
//удаление всех товаров из корзины разом
if(isset($_GET["action"])) {
    if($_GET["action"]=="empty") {
        foreach($_SESSION["cart"] as $keys => $values) {
            unset($_SESSION["cart"]);
            echo '<script>window.location="cart.php"</script>';
        }
    }
}
include ('config/components/header.php');?>

<?php if(!empty($_SESSION["cart"])) { ?>
    <h1>Корзина</h1>
    <!-- Блок: Основной код -->
    <table>
        <thead>
            <tr>
                <th width="50%">Имя</th><th width="10%">Количество</th><th width="20%">Цена</th><th width="15%">Итого</th><th width="5%">Действие</th>
            </tr>
        </thead>
    <?php
        $total = 0;
        foreach($_SESSION["cart"] as $keys => $values) { ?>
        <tr>
        <td><?php echo $values["item_name"];?></td>
        <td><?php echo $values["item_quantity"];?></td>
        <td><?php echo $values["item_price"]?>руб.</td>
        <td><?php echo number_format($values["item_quantity"] * $values["item_price"],2);?>руб.</td>
        <td class="center"><a href="cart.php?action=delete&id=<?php echo $values["product_id"];?>" class="deleteSmall">X</a></td>
        </tr>
        <?php $total = $total + ($values["item_quantity"] * $values["item_price"]); }?>
        <tr>
            <td colspan="3">Итого</td>
            <td> <?php echo number_format($total,2)?> руб.</td>
            <td></td></tr>  
        </table>
        <div class="buttons">
            <?php echo '
            <a href="cart.php?action=empty"><button class="btn delete">Удалить все товары</button></a>&nbsp;
            <a href="index.php"><button class="btn back">Назад в магазин</button></a>';?> 
        </div>
        <div>
            <?php echo '
            <a href="checkout.php"><button class="btn checkout">Оформить заказ</button></a>';?>
        </div>
<?php } elseif(empty($_SESSION["cart"])) { ?>
    <div class="container" style="text-align:center; min-height:calc(100vh - 260px);">
        <h3>Ваша корзина пуста. Ознакомьтесь с <a href="index.php">товарами</a>в нашем магазине.</h3>
    </div>
 <?php } ?>
 <?php include('config/components/footer.php');?>