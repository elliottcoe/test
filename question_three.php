<?php
function export_products_to_file()
{
    $database = new database_connection_script_library;

    $product_details = $database->get_products(ALL);

    $number_of_products = sizeof($product_details);

    $product_data = array();
    for($counter=0; $counter < $number_of_products; $counter++)
    {
        $product_details = $database->get_products($counter);

        $product_id = $product_details["product_id"];
        $product_name = $product_details["product_name"];
        $product_price = $product_details["product_price"];

        $product_data[] = array($product_id, $product_name, $product_price);
    }

    $product_insert_count=0;
    foreach($product_data as $product)
    {
        $myfile = fopen("myfile.csv", "a+");

        $file_data = array();
        $file_data[0] = $product[0];
        $file_data[1] = $product[1];
        $file_data[2] = $product[2];

        fputcsv($myfile, $file_data);

        fclose($myfile);

        $product_insert_count++;
    }

    return $product_insert_count;
}

class database_connection_script_library
{
    function get_products($reference)
    {
        $query = "SELECT product_id, product_name, product_price "
            ."FROM product ";

        if($reference != ALL)
        {
            $query .= "WHERE product_id = {$reference} ";
        }

        mysql_connect("127.0.0.1", "admin", "admin");
        mysql_select_db("product_data");
        $result = mysql_query($query);


        return resultset_to_array($result);
    }
}

?>