<?php

$filepath = realpath(dirname(__FILE__));
include_once ($filepath."/../lib/database.php");
include_once ($filepath."/../helpers/format.php");

	//include_once "../lib/database.php";
	//include_once "../helpers/format.php";
?>
<?php
class Product{
	private $db;
	private $fm;
    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function productInsert($data, $file){
    	//$productName = $this->fm->validation($data['productName']);
    	$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
    	$catId = mysqli_real_escape_string($this->db->link, $data['catId']);
    	$brandId = mysqli_real_escape_string($this->db->link, $data['brandId']);
    	$body = mysqli_real_escape_string($this->db->link, $data['body']);
    	$price = mysqli_real_escape_string($this->db->link, $data['price']);
    	$type = mysqli_real_escape_string($this->db->link, $data['type']);

    	$permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
	    $file_size = $_FILES['image']['size'];
	    $file_temp = $_FILES['image']['tmp_name'];

	    $div = explode('.', $file_name);
	    $file_ext = strtolower(end($div));
	    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "upload/".$unique_image;

	    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $file_name == "" || $price == "" || $type == "" ) {
	    	$msg = "<span class='error'><b>Field Must NOT Empty !!</b></span>";
	    	return $msg;
	    }elseif ($file_size >1048567) {
			 echo "<span class='error'>Image Size should be less then 1MB!
			 </span>";
			} elseif (in_array($file_ext, $permited) === false) {
			 echo "<span class='error'>You can upload only:-"
			 .implode(', ', $permited)."</span>";
			}else{
		    move_uploaded_file($file_temp, $uploaded_image);
		    $query = "INSERT INTO tbl_product(productName,catId,brandId,body,price,image,type) VALUES ('$productName','$catId','$brandId','$body','$price','$uploaded_image','$type')";
		    $insertProduct = $this->db->insert($query);
	    		if ($insertProduct) {
	    			echo "<span class='success'>Product Inserted Successfully</span>";
	    		}else{
	    			echo "<span class='error'>Product Not Inserted Successfully</span>";
	    		}
	    }
	}


//here we're goin to JOIN 3tables to get all the data together
	public function getAllProduct(){
		$query = "SELECT p.*,c.catName,b.brandName
				FROM tbl_product AS p, tbl_category AS c, tbl_brand AS b
				WHERE p.catId = c.catId AND p.brandId = b.brandId
				ORDER BY p.productId DESC";

/* the regular away.....upper one using ALIAS		
		$query = "SELECT tbl_product.*,tbl_category.catName,tbl_brand.brandName
				FROM tbl_product
				INNER JOIN tbl_category
				ON tbl_product.catId = tbl_category.catId
				INNER JOIN tbl_brand
				ON tbl_product.brandId = tbl_brand.brandId

				ORDER BY tbl_product.productId DESC";*/
	

		$result = $this->db->select($query);
		return $result;

	}    

	public function getProById($id){
		$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
		$result = $this->db->select($query);
		return $result;
	}

	public function productUpdate($data, $file, $id){
		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
    	$catId = mysqli_real_escape_string($this->db->link, $data['catId']);
    	$brandId = mysqli_real_escape_string($this->db->link, $data['brandId']);
    	$body = mysqli_real_escape_string($this->db->link, $data['body']);
    	$price = mysqli_real_escape_string($this->db->link, $data['price']);
    	$type = mysqli_real_escape_string($this->db->link, $data['type']);

    	$permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
	    $file_size = $_FILES['image']['size'];
	    $file_temp = $_FILES['image']['tmp_name'];

	    $div = explode('.', $file_name);
	    $file_ext = strtolower(end($div));
	    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "upload/".$unique_image;

	    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "" ) {
	    	$msg = "<span class='error'><b>Field Must NOT Empty !!</b></span>";
	    	return $msg;
	    }else{
	    	if (!empty($file_name)) {

		  		if ($file_size >1048567) {
				 echo "<span class='error'>Image Size should be less then 1MB!
				 </span>";
				} elseif (in_array($file_ext, $permited) === false) {
				 echo "<span class='error'>You can upload only:-"
				 .implode(', ', $permited)."</span>";
			}else{
			    move_uploaded_file($file_temp, $uploaded_image);
			    $query = "UPDATE tbl_product
			    		SET
			    		productName = '$productName',
			    		catId = '$catId',
			    		brandId = '$brandId',
			    		body = '$body',
			    		price = '$price',
			    		image = '$uploaded_image',
			    		type = '$type'
			    		WHERE productId='$id'";
			    $updated_row = $this->db->update($query);
		    		if ($updated_row) {
		    			echo "<span class='success'>Product Updated Successfully</span>";
		    		}else{
		    			echo "<span class='error'>Product Not Updated Successfully</span>";
		    		}
				}    
	    }else{
	    	$query = "UPDATE tbl_product
			    		SET
			    		productName = '$productName',
			    		catId = '$catId',
			    		brandId = '$brandId',
			    		body = '$body',
			    		price = '$price',
			    		type = '$type'
			    		WHERE productId='$id'";
			    $updated_row = $this->db->update($query);
		    		if ($updated_row) {
		    			echo "<span class='success'>Product Updated Successfully</span>";
		    		}else{
		    			echo "<span class='error'>Product Not Updated Successfully</span>";
		    		}

	   		}
	  	}  
	}


//REMOVE Product
	public function delProductById($id){
		$query = "SELECT * FROM tbl_product WHERE productId='$id'";
		$getData = $this->db->select($query);
		if ($getData) {
			while ($delImg = $getData->fetch_assoc()) {
				$delLink = $delImg['image'];
				unlink($delLink);
			}			
		}

		$delquery = "DELETE FROM tbl_product WHERE productId = '$id'";
		$delData = $this->db->delete($delquery);
		if ($delData) {
			$msg = "<span class='success'>Product Deleted Successfully</span>";
			return $msg;
		}else{
			$msg = "<span class='error'>Product Not Deleted </span>";
			return $msg;
		}
	}



	public function getFeatureProduct(){
		$query = "SELECT * FROM tbl_product WHERE type='0' ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
	}

	public function getNewProduct(){
		$query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
	}

	public function getSingleProduct($id){
		$query = "SELECT p.*, c.catName, b.brandName
				FROM tbl_product AS p, tbl_category AS c, tbl_brand AS b
				WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId = '$id'";
		$result = $this->db->select($query);
		return $result;		
	}


//getting products from [BRANFD]
	public function latestFromIphone(){
		$query = "SELECT * FROM tbl_product WHERE brandId='17' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}

	public function latestFromSamsung(){
		$query = "SELECT * FROM tbl_product WHERE brandId='8' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}

	public function latestFromAcer(){
		$query = "SELECT * FROM tbl_product WHERE brandId='5' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}

	public function latestFromCanon(){
		$query = "SELECT * FROM tbl_product WHERE brandId='7' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}


	public function productByCat($id){
		$id     = mysqli_real_escape_string($this->db->link, $id);
		$query  = "SELECT * FROM tbl_product WHERE catId='$id'";
		$result = $this->db->select($query);
		return $result;
	}


	public function insertCompareData($cmprid, $cmrId){
		$cmrId     = mysqli_real_escape_string($this->db->link, $cmrId);
		$productid     = mysqli_real_escape_string($this->db->link, $cmprid);

//check our product is already added or not		
		$chkquery = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrId' AND productid = '$productid'";
		$chkComp =$this->db->select($chkquery);
		if ($chkComp) {
			$msg = "<span class='error'> Already Added to Compare</span>";
			return $msg;
		}
//ending check section


		$query = "SELECT * FROM tbl_product WHERE productId = '$productid'";
		$result = $this->db->select($query)->fetch_assoc();
		if ($result) {
			$productId = $result['productId'];
			$productName = $result['productName'];
			$price  = $result['price'];
			$image  = $result['image'];
		$query = "INSERT INTO tbl_compare(cmrId, productId, productName, price, image) VALUES('$cmrId', '$productId', '$productName', '$price', '$image')";	
		$inserted_row = $this->db->insert($query);

		if ($inserted_row) {
			$msg = $msg = "<span class='success'>Added to Compare</span>";
			return $msg;
		}else{
			$msg = "<span class='error'> Not Added </span>";
			return $msg;
		}

		} 

	} 

	public function getComparedData($cmrId){
		$query = "SELECT * FROM tbl_compare WHERE cmrId= '$cmrId' ORDER BY id DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function delCompareData($cmrId){
		$query = "DELETE FROM tbl_compare WHERE cmrId = '$cmrId'";
		$result = $this->db->delete($query);
		return $result;
	}


	public function saveWishlistData($id, $cmrId){
////check our product is already added or not	
		$chkquery = "SELECT * FROM tbl_wishlist WHERE productId='$id' AND cmrId = '$cmrId'";
		$check = $this->db->select($chkquery);
		if ($check) {
			$msg = "<span class='error'> Already Added to Wishlist </span>";
			return $msg;
		}
//ending check section

		$proquery = "SELECT * FROM tbl_product WHERE productId = '$id'";
		$result = $this->db->select($proquery)->fetch_assoc();
		if ($result) {
			$productId = $result['productId'];
			$productName= $result['productName'];
			$price = $result['price'];
			$image = $result['image'];

		$query = "INSERT INTO tbl_wishlist(cmrId, productId, productName, price, image) VALUES('$cmrId', '$productId', '$productName', '$price', '$image') ";
		
		$inserted_row = $this->db->insert($query);
		  if ($inserted_row) {
			$msg = $msg = "<span class='success'>Added to Wishlist</span>";
			return $msg;
		}else{
			$msg = "<span class='error'> Not Added to Wishlist </span>";
			return $msg;
		  }	
	  }
   }


   public function getWlistData($cmrId){
   	$query = "SELECT * FROM tbl_wishlist WHERE cmrId='$cmrId'  ORDER BY id DESC";
   	$result = $this->db->select($query);
   	return $result;
   }

   public function delWlistData($cmrId, $productId){
   	$query = "DELETE FROM tbl_wishlist WHERE cmrId='$cmrId' AND productId = '$productId'";
   	$result = $this->db->delete($query);
   	return $result;
   }

}
 
?>