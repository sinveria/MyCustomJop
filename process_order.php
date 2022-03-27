<?php 
include_once 'config/config.php';
include_once 'config/class/User.php';
include_once 'config/class/Order.php';

$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);
$order = new Order($db);

if(!$customer->loggedIn()) {	
	header("Location: login.php");	
}
include('config/components/header.php');
?>

<?php if(!empty($_GET['order'])) {			
$total = 0;
$orderDate = date('Y-m-d');
if(isset($_SESSION["cart"])) {
	foreach($_SESSION["cart"] as $keys => $values){					
		$order->item_id = $values["item_id"];
		$order->item_name = $values["item_name"];
		$order->item_price = $values["item_price"];
		$order->quantity = $values["item_quantity"];
		$order->order_date = $orderDate;
		$order->order_id = $_GET['order'];
		$order->insert();
	}
	unset($_SESSION["cart"]);	
} ?>

<div class="container" style="text-align: center; min-height:calc(100vh - 260px);">
	<h1>Вы успешно оформили заказ!</h1>
	<br><br>
	<h3 class="text-center"> Спасибо за заказ! На этом процесс заказа завершен.</h3>
	<br><br>
	<p class="text-center"> <strong>Ваш номер заказа: </strong> <span class="text_checout"><?php echo $_GET['order']; ?></span> </p>
	<p class="text-center">Наслаждайтесь нашим <a href="index.php">магазином!</a></p>
	<?php } else { ?>
	<p class="text-center">Наслаждайтесь нашим <a href="index.php">магазином!</a></p>
	<?php } ?>
</div>

<?php include('config/components/footer.php');?>