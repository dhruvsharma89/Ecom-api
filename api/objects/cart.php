<?php
class Cart{
 
    // database connection and table name
    private $conn;
    private $table_name = "cart";
 
    // object properties
    public $quantity;
	public $user;
	public $pid;
	public $cart_id;
    
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	function create(){ }
	
	function read(){ 
	    // select all query
    $query = "SELECT c.cart_id,c.id ,c.quantity,c.user,p.name as name,p.description as description,p.price as price,p.discount as discount,p.meta as meta
            FROM " . $this->table_name . "  c 
                LEFT JOIN
                    products p
                        ON p.id = c.id
				WHERE user = 'ramesh' 		
             ORDER BY
                c.created DESC ";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 	
    // execute query
    $stmt->execute();
 	
    return $stmt;
	
	 }
	
	
	
	
	function add(){ 
	    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                user=:user, id=:pid, quantity=:quantity";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->user=htmlspecialchars(strip_tags($this->user));
    $this->pid=htmlspecialchars(strip_tags($this->pid));
    $this->quantity=htmlspecialchars(strip_tags($this->quantity));
    
	
 
    // bind values
    $stmt->bindParam(":user", $this->user);
    $stmt->bindParam(":pid", $this->pid);
    $stmt->bindParam(":quantity", $this->quantity);
    
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
	
	}
	
	
	
	
	
	
	function delete(){
		 	if($this->cart_id==null || $this->user==null){return false;}
    // delete query
	
    $query = "DELETE FROM " . $this->table_name . " WHERE cart_id =:cart_id AND user=:user "; //delete from categories too ~~~~~~~~~~~~
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->cart_id=htmlspecialchars(strip_tags($this->cart_id));
	$this->user=htmlspecialchars(strip_tags($this->user));
 
    // bind id of record to delete
    $stmt->bindParam(":cart_id", $this->cart_id);
	$stmt->bindParam(":user", $this->user);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
		
		
		
		
		
		  }
	
	
	

}
?>