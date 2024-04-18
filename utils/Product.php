<?php

class Product
{
    private $conn;

    public $p_id;
    public $brand_id;
    public $p_name;
    public $p_price;
    public $p_desc;
    public $p_rating;
    public $p_image;

    public function __construct($conn, $p_id = null, $brand_id = null, $p_name = null, $p_price = null, $p_desc = null, $p_rating = null, $p_image = null)
    {
        $this->conn = $conn;
        $this->p_id = $p_id;
        $this->brand_id = $brand_id;
        $this->p_name = $p_name;
        $this->p_price = $p_price;
        $this->p_desc = $p_desc;
        $this->p_rating = $p_rating;
        $this->p_image = $p_image;
    }

    public function getAllProducts()
    {
        $stmt = $this->conn->query("SELECT * FROM tbl_product");
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product(
                $this->conn,
                $row['p_id'],
                $row['brand_id'],
                $row['p_name'],
                $row['p_price'],
                $row['p_desc'],
                $row['p_rating'],
                $row['p_image']
            );
            $products[] = $product;
        }
        return $products;
    }

    public function getProductById($p_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_product WHERE p_id = :p_id");
        $stmt->bindParam(":p_id", $p_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Product(
                $this->conn,
                $row['p_id'],
                $row['brand_id'],
                $row['p_name'],
                $row['p_price'],
                $row['p_desc'],
                $row['p_rating'],
                $row['p_image']
            );
        } else {
            return null;
        }
    }

    public function updateProduct($p_id, $brand_id, $p_name, $p_price, $p_desc, $p_rating, $p_image)
    {
        $stmt = $this->conn->prepare("UPDATE tbl_product SET brand_id = :brand_id, p_name = :p_name, p_price = :p_price, p_desc = :p_desc, p_rating = :p_rating, p_image = :p_image WHERE p_id = :p_id");
        $stmt->bindParam(":p_id", $p_id);
        $stmt->bindParam(":brand_id", $brand_id);
        $stmt->bindParam(":p_name", $p_name);
        $stmt->bindParam(":p_price", $p_price);
        $stmt->bindParam(":p_desc", $p_desc);
        $stmt->bindParam(":p_rating", $p_rating);
        $stmt->bindParam(":p_image", $p_image);
        return $stmt->execute();
    }

    public function deleteProduct($p_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tbl_product WHERE p_id = :p_id");
        $stmt->bindParam(":p_id", $p_id);
        return $stmt->execute();
    }

    public function insertProduct($brand_id, $p_name, $p_price, $p_desc, $p_rating, $p_image)
    {
        $stmt = $this->conn->prepare("INSERT INTO tbl_product (brand_id, p_name, p_price, p_desc, p_rating, p_image) VALUES (:brand_id, :p_name, :p_price, :p_desc, :p_rating, :p_image)");
        $stmt->bindParam(":brand_id", $brand_id);
        $stmt->bindParam(":p_name", $p_name);
        $stmt->bindParam(":p_price", $p_price);
        $stmt->bindParam(":p_desc", $p_desc);
        $stmt->bindParam(":p_rating", $p_rating);
        $stmt->bindParam(":p_image", $p_image);
        return $stmt->execute();
    }
}
