<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/product.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Product($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 

// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) &&
    !empty($data->category_id)
){
 
    // set product property values
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');
 
 	if(!empty($data->meta)){
	$product->meta=imagesaver($data->meta,$data->name); //use full base64 data 
	}
	if(!empty($data->discount)){
	$product->discount=$data->discount ; 
	}
    // create the product
    if($product->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
$db=null;

function imagesaver($image_data,$name){

    list($type, $meta) = explode(';', $image_data); // exploding data for later checking and validating 

    if (preg_match('/^data:image\/(\w+);base64,/', $image_data, $type)) {
        $meta = substr($meta, strpos($meta, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, gif

        if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
            throw new \Exception('invalid image type');
        }

        $meta = base64_decode($meta);

        if ($meta === false) {
            throw new \Exception('base64_decode failed');
        }
    } else {
        throw new \Exception('did not match data URI with image data');
    }

    $fullname = "../upload/".$name.".".$type;

    if(file_put_contents($fullname, $meta)){
        $result = $fullname;
    }else{
        $result =  "error";
    }
    /* it will return image name if image is saved successfully 
    or it will return error on failing to save image. */
    return $result; 
}



?>