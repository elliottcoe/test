<?php

// Use the same database connection library from question 3.
class database_connection_script_library
{
    private $conn;

    public function __construct()
    {
        // Modernize data connection method and set everything up in the constructor.
        $this->conn = new mysqli('external-domain-2.com', 'admin', 'admin', 'product');
    }

    public function check_product_exists($ean)
    {
        $query = "SELECT * FROM products WHERE ean == " . $ean;

        $this->conn->query($query);

        return mysqli_fetch_array($query);
    }

    public function create_product($product_id, $product_name, $product_price)
    {
        $sql = "INSERT INTO products (product_id, product_name, price, ean)
        VALUES ($product_id], $product_name, $product_price)";

        $this->conn->query($sql);
    }
}


function import_from_feeds() {

    // Get the feed
    $product_feed = fgetcsv("http://www.external-domain.com/product_feed.csv");

    $product_controller = new database_connection_script_library();

    foreach ($product_feed as $product) {
        if ($product_controller->check_product_exists($product['ean'])) {
            // Check if the supplier has marked the product as out of stock

            // check if current feed price is less than the current price

            // if it is, updated it.

            // Set the supplier of the product
        }

        else {
            // Product doesn't exist.
            $product_id = $product['id'];
            $product_name = $product['name'];
            $product_price = $product['product_price'];
            $product_ean = $product['ean'];

            $product_controller->create_product($product_id, $product_name, $product_price, $product_ean);
        }
    }
}