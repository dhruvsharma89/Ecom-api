<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
require('../config/database.php');
require('../objects/cart.php');
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$cart = new Cart($db);
 
// query products
$stmt = $cart->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $cart_arr=array();
    $cart_arr["products"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $cart_item=array(
            "pid" => $id,
			"quantity" => $quantity,
            "user" => $user,
            "price" => $price,
			"name" => $name,
			"description" => $description,
			"url" =>"upload/".$meta,
			"discount" => $discount,
			"cart_id"=>$cart_id
        );
 
        array_push($cart_arr["products"], $cart_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($cart_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
$db=null;
?>