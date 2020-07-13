<?php
function export_products_to_file()
{
    // Import carbon for file name timestamping.
    $carbon = new Carbon();

    $database = new database_connection_script_library;

    // get_products method needs a string.
    $product_details = $database->get_products('all');


    // Instantiate an array with []
    $product_data = [];

    $count = 0;
    foreach ($product_details as $product) {
        // add the product to an array.
        $product_data[] = [
            'product_id' => $product['product_id'],
            'product_name' => $product['product_name'],
            'product_price' => $product['product_price'],
        ];
        $count++;
    }

    // Generate file name with current date/time stamp.
    $filename = 'export-' . $carbon->now()->toDateTimeString();

    // Open the new file
    $file = fopen($filename, 'a+');

    // add the array data to the csv file.
    fputcsv($file, $product_data);

    return $count;
}

class database_connection_script_library
{
    private $conn;

    public function __construct()
    {
        // Modernize data connection method and set everything up in the constructor.
        $this->conn = new mysqli('external-domain-2.com', 'admin', 'admin', 'product');
    }

    function get_products($reference)
    {
        $query = "SELECT product_id, product_name, product_price "
            ."FROM product ";

        if($reference != 'all')
        {
            $query .= "WHERE product_id = {$reference} ";
        }

        // mysqli syntax
        $result = $this->conn->query($query);

        return mysqli_fetch_array($result);
    }
}

?>