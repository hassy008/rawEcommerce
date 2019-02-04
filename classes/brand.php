<?php 
	include_once  "../lib/database.php"; 
	include_once  "../helpers/format.php"; 
?>

<?php
	/**
	 * summary
	 */
class Brand{
	private $db;
	private $fm;

	public function __construct() {
   		$this->db = new Database();
   		$this->fm = new Format(); 
    }

    public function brandInsert($brandName){
 //validate our code
 		$brandName = $this->fm->validation($brandName);
 		$brandName = mysqli_real_escape_string($this->db->link, $brandName);
 		if (empty($brandName)) {
 		   		$msg = "<span class='error'>Field must NOT empty</span>";
 		   		return $msg;
 		   }else {
 		   		$query = "INSERT INTO tbl_brand(brandName) VALUES('$brandName')";
 		   		$brandInsert = $this->db->insert($query);
 		   		if ($brandInsert) {
 		   			$msg = "<span class='success'>Brand  Inserted Successfully</span>";
 		   			return $msg;
 		   		}else{
 		   			$msg = "<span class='error'>Brand NOT Inserted Successfully !!!</span>";
 		   			return $msg;
 		   		}
 		   }   	
    }

    public function getAllBrand(){
    	$query = "SELECT * FROM tbl_brand ORDER BY brandId DESC ";
    	$result = $this->db->select($query);
    	return $result;
    }

    public function getBrandById($id){
    	$query = "SELECT * FROM tbl_brand WHERE brandId ='$id'";
    	$result = $this->db->select($query);
    	return $result;
    }

    public function brandUpdate($brandName, $id){
    	$brandName = $this->fm->validation($brandName);
    	$brandName = mysqli_real_escape_string($this->db->link, $brandName);
    	if (empty($brandName)) {
            $msg = "<span class='error'><b>Field Must NOT Empty !!</b></span>";
            return $msg;
    	}else{
    		$query = "UPDATE tbl_brand
    				SET
    				brandName = '$brandName'
    				WHERE brandId = '$id'";
    		$updated_row = $this->db->update($query);
    		if ($updated_row) {
    			$msg = "<span class='success'>Brand Updated Successfully</span>";
    			return $msg;
    		}else{
    			$msg = "<span class='error'>Brand Not Updated Successfully</span>";
    			return $msg;
    		}
    	}
    }

    public function delBrandById($id){
    	$query = "DELETE FROM tbl_brand WHERE brandId='$id'";
    	$delbrand = $this->db->delete($query);
    	if ($delbrand) {
    		$msg = "<span class='success'>Brand Deleted Successfully.</span>";
    		return $msg;
    	}else{
    		$msg = "<span class='error'>Brand Not Deleted!!</span>";
    	}
    }
}
?>