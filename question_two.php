<?php

// Original Code

$number_of_products = 50;

$product_feed = fgetcsv("http://www.external-domain.com/product_feed.csv");

$product_price_feed = new price_feed_web_service;
$product_price_feed->get_prices();

$product_data = array();
for($counter=0; $counter < 50; $counter++)
{
    $product_data[] = array($product_feed[$counter][0], $product_feed[$counter][1], $product_price_feed[$counter][1]);
}

$query = "INSERT INTO product_price_data (product_id, product_name, price)
					VALUES ";
$first = true;
for($counter=0; $counter < 50; $counter++)
{
    if(!$first) { $query .= ","; }
    $query .= " ({$product_data[$counter][0]}, {$product_data[$counter][1]}, {$product_data[$counter][2]}) ";
    $first = false;
}

mysql_connect("external-domain-2.com", "admin", "admin");
mysql_select_db("product");
mysql_query($query);


?>


<?php

$conn = new mysqli('external-domain-2.com', 'admin', 'admin', 'product');

$number_of_products = 50;

$handle = fgetcsv('http://www.external-domain.com/product_feed.csv', 'r');

$product_feed = fgetcsv($handle);

$product_price_feed = new price_feed_web_service;
$product_price_feed->get_prices();

$product_data = [];

$count = 0;
foreach ($product_feed as $product) {
    // Check product limit
    if (!$count < 50) {
        // Do insert
        if ($product['Product Id'] && $product['Product Name']) {
            $product_id = $product['Product Id'];
            $product_price = $product_price_feed[$product_id];
            $product_name = $product['Product Name'];


            $sql = "INSERT INTO product_price_data (product_id, product_name, price)
        VALUES ($product_id, $product_name, $product_price)";

            // Doing a query per row to insert every product, means products are still added if one of the products in the feed is wrong.
            if ($conn->query($sql) === TRUE) {
                echo 'added new row';
            } else {
                error_log('failed to add row for ' . $product_name . ', ' . $product_id);
            }
        }
        else {
            error_log('failed to add row, parameter missing');
        }
    }
    else {
        break;
    }
}



?>