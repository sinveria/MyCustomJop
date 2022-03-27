<?php
class Product {
    private $productItemsTable = 'products';
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ItemsList() {
        $stmt = $this->conn->prepare("SELECT id, name, price, description,images,status FROM ".$this->productItemsTable);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>