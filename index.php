<?php
//получаем свойства для подключения к БД
include_once 'config/config.php';
//подключаем ранее сформированные классы
include_once 'config/class/User.php';
include_once 'config/class/Product.php';

//Создание экземпляра класса
$database = new Database();
//подключение к бд
$db = $database->getConnection();
$customer = new Customer($db);
$product = new Product($db);
//если сессия не сформирована и customer пустой, перенаправляем на авторизацию
if (!$customer->loggedIn()) {
    header("Location: login.php");
}
//подключаем шапку сайта
include('config/components/header.php'); ?>

<h1>Каталог товаров</h1>
<div class="items">
    <?php
    $result = $product->itemsList();
    while ($item = $result->fetch_assoc()) { ?>
        <div class="item">
            <form method="post" action="cart.php?action=add&id=<?php echo $item["id"];?>">
                <div class="images">
                    <img src="assets/images/<?php echo $item["images"];?>">
                </div>
                <h3><?php echo $item["name"];?></h3>
                <h5><?php echo $item["description"];?></h5>
                <b><?php echo $item["price"];?>руб.</b>
                <div class="carts">
                    <input type="number" min="1" mas="25" name="quantity" class="form-control" value="1">
                    <div>
                        <input type="hidden" name="item_name" value="<?php echo $item["name"];?>">
                        <input type="hidden" name="item_price" value="<?php echo $item["price"];?>">
                        <input type="hidden" name="item_id" value="<?php echo $item["id"];?>">
                    </div>
                    <input type="submit" name="add" class="btn cart" value="В корзину">
                </div>
            </form>
        </div>
    <?php }?>
</div>
<?php include('config/components/footer.php');?>