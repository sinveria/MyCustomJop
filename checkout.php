<?php 
include_once 'config/config.php';
include_once 'config/class/User.php';
$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);

if(!$customer->loggedIn()) {	
	header("Location: login.php");	
}

include('config/components/header.php');

$orderTotal = 0;

foreach($_SESSION["cart"] as $keys => $values){
	$total = ($values["item_quantity"] * $values["item_price"]);
	$orderTotal = $orderTotal + $total;
} ?>

<h1>Оформление заказа</h1><br><br>
<div class='checout'>
	<div class="item-checout">
		<h2>Данные клиента</h2>
		<?php 
			$addressResult = $customer->getAddress();
			$count=0;
			while ($address = $addressResult->fetch_assoc()) { 
		?>
		<p><strong>Адрес</strong>: <?php echo $address["address"]; ?></p>
		<p><strong>Телефон</strong>: <?php echo $address["phone"]; ?></p>
		<p><strong>Email</strong>: <?php echo $address["email"]; ?></p>
		<?php } ?>				
	</div>
	<?php 
		$randNumber1 = rand(100000,999999); 
		$randNumber2 = rand(100000,999999); 
		$randNumber3 = rand(100000,999999);
		$orderNumber = $randNumber1.$randNumber2.$randNumber3;
	?>
	<div class="item-checout">
		<h2>Ваш заказ</h2>
		<p><strong>Товары</strong>: <?php echo $orderTotal; ?> руб.</p>
		<p><strong>Доставка</strong>: 0  руб.</p>
		<p><strong>Итого</strong>: <?php echo $orderTotal; ?> руб.</p>
		<p><strong>Итого общее</strong>: <?php echo $orderTotal; ?> руб.</p>
		<br><br>
		<p><a href="process_order.php?order=<?php echo $orderNumber; ?>"><button class="btn checkout">Подтвердить</button></a></p>
	</div>
</div>    
<?php include('config/components/footer.php');?>
