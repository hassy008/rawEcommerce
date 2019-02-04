<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath."/../lib/database.php");
include_once ($filepath."/../helpers/format.php");
?>
<?php
/**
 * summary
 */
class Cart{
	private $db;
	private $fm;
	
	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function addToCart($quantity, $id){
		$quantity  = $this->fm->validation($quantity);
		$quantity  = mysqli_real_escape_string($this->db->link, $quantity);
		$productId = mysqli_real_escape_string($this->db->link, $id);
		$sId       = session_id();

		$squery   = "SELECT * FROM tbl_product WHERE productId='$productId'";
		$result   = $this->db->select($squery)->fetch_assoc();
/*		
echo '<pre>';
print_r($result);
echo '</pre>';*/
		
		$productName = $result['productName'];
		$price       = $result['price'];
		$image       = $result['image'];

	//avoid ading same product to use CHECK query
		 $chkquery = "SELECT * FROM tbl_cart WHERE productId='$productId' AND sId = '$sId'";
		 $getPro   = $this->db->select($chkquery);
		 if ($getPro) {
		 	$msg   = "Product Already Added";
		 	return $msg;
		 }else {
	//now insert to [CART TABLE]	
		$query = "INSERT INTO tbl_cart(sId,productId,productName,price,quantity,image) VALUES('$sId','$productId','$productName','$price','$quantity','$image')";
		$inserted_row = $this->db->insert($query);
		if ($inserted_row) {
			header("Location:cart.php");
		}else{
			header("Location:404.php");
		}
	  }
	}

	public function getCartProduct(){
//here we compare session_id and get the product from tbl_cart

		$sId    = session_id();
		$query  = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->select($query);
		return $result;
	}
	
	public function updateCartquantity($cartId, $quantity){
		$cartId   = mysqli_real_escape_string($this->db->link, $cartId);
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);
		$query    = "UPDATE tbl_cart
					SET
					quantity = '$quantity'
					WHERE cartId = '$cartId'";
		$updated_row =$this->db->update($query);
		if ($updated_row) {
			header("Location:cart.php");			
		}else {
			$msg = "<span style='font-size: 20px; color: red;'>Quantity Not Updated !!!</span>";
			return $msg;
		}			

	}

	public function delProByCart($delid){
		$query = "DELETE FROM tbl_cart WHERE cartId='$delid'";
		$delData = $this->db->delete($query);
		if ($delData) {
			echo "<script>window.location = 'cart.php'</script>";
		}else{
			$msg = "<span class='error'>Not Deleted</span>";
		}
	}

	public function ChkCartTbl(){
//here session_id helps to define each browser product differently....
		$sId    = session_id();
		$query  = "SELECT * FROM tbl_cart WHERE sId='$sId'";
		$result = $this->db->select($query);
		return $result;
	}

	public function delCustomerCart(){
		$sId    = session_id();
		$query  = "DELETE FROM tbl_cart WHERE sId='$sId'";
		$result = $this->db->delete($query);
		return $result;

	}

	public function orderProduct($cmrId){
		$sId    = session_id();
		$query 	= "SELECT * FROM tbl_cart WHERE sId='$sId'";
		$getPro = $this->db->select($query);
		if ($getPro) {
			while($result 	= $getPro->fetch_assoc()){
			   $productId 	= $result['productId'];
			   $productName = $result['productName'];
			   $quantity 	= $result['quantity'];
			   $price		= $result['price'] * $quantity;
			   $image		= $result['image'];

//now we [INSERT DATA] from [tbl_cart]->[tbl_order]//

		$query  = "INSERT INTO tbl_order(cmrId, productId, productName, quantity, price, image) VALUES('$cmrId', '$productId', '$productName', '$quantity', '$price', '$image')";	 
		$inserted_order = $this->db->insert($query);  
			}
		}
	}

	public function payableAmount($cmrId){
		$query  = "SELECT price FROM tbl_order WHERE cmrId = '$cmrId' AND date=now() "; //AND date=now()
		$result = $this->db->select($query);
		return $result;
	}


	public function getOrderedProduct($cmrId){
		$query = "SELECT * FROM tbl_order WHERE cmrId='$cmrId' ORDER BY date DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function ChkOrder($cmrId){
		$query = "SELECT * FROM tbl_order WHERE cmrId='$cmrId'";
		$result = $this->db->select($query);
		return $result;
	}

	public function getAllOrderProduct(){
		$query  = "SELECT * FROM tbl_order ORDER BY date";
		$result = $this->db->select($query);
		return $result;
	}

	public function productShipped($id, $time, $price){
	   $id   = mysqli_real_escape_string($this->db->link, $id);
	   $time = mysqli_real_escape_string($this->db->link, $time);
	   $price = mysqli_real_escape_string($this->db->link, $price);

	   $query = "UPDATE tbl_order
	   			SET
	   			status = '1'
	   			WHERE cmrId = '$id' AND date='$time' AND price = '$price'"; 
	   $updated_row = $this->db->update($query);
	   if ($updated_row) {
	   		$msg = "<span class='success'>Shipped Successful</span>";
	   		return $msg;		
	   		} else{
	   			$msg = "<span class='error'>Shipped Not Successful</span>";
	   			return $msg;
	   		}			
		}

	public function delProductShipped($id, $time, $price){
	   $id   = mysqli_real_escape_string($this->db->link, $id);
	   $time = mysqli_real_escape_string($this->db->link, $time);
	   $price = mysqli_real_escape_string($this->db->link, $price);
	   
	   $query   = "DELETE FROM tbl_order WHERE cmrId = '$id' AND date='$time' AND price = '$price'";
	   $deldata = $this->db->delete($query);
	   if ($deldata) {
   	      $msg = "<span class='success'>Remove Successful</span>";
   		  return $msg;		
   		  } else{
   			$msg = "<span class='error'>Remove Not Successful</span>";
   			return $msg;
	   		}	
	}	

	public function productShippedConfirm($id, $time, $price){
	   $id   = mysqli_real_escape_string($this->db->link, $id);
	   $time = mysqli_real_escape_string($this->db->link, $time);
	   $price = mysqli_real_escape_string($this->db->link, $price);
	   $query = "UPDATE tbl_order
	   			SET
	   			status='2'
	   			WHERE cmrId = '$id' AND date = '$time' AND price = '$price'";
	  $updated_row = $this->db->update($query);
	  if ($updated_row) {
	  	$msg = "<span class='success'>Update Successful</span>";
   		return $msg;		
   		} else{
   			$msg = "<span class='error'>Update Not Successful</span>";
   			return $msg;
   		}						
	}
}    
?>