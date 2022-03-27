<!-- Проверяем сформирована ли сессия или нет -->
<?php if (isset($_SESSION["name"])) { ?>
    <nav>
        <li><a href="index.php">Каталог</a></li>
        <!-- Формируем количество товаров добавленных в нашу корзину -->
        <li><a href="cart.php">Корзина ( <?php
            if (isset($_SESSION["cart"])) {
                



                $count = count($_SESSION["cart"]);
                echo "$count";
            } else {
                echo "0"; }  
        ?>)</a></li>
    </nav>
    <nav>
        <li>Добро пожаловать: <b><a href="#"><?php echo $_SESSION["name"];?></a></b></li>
        <li><a href="logout.php" class="btn white">Выйти</a></li>
    </nav>
    <?php } ?>