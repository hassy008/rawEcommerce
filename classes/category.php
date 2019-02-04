<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath."/../lib/database.php");
include_once ($filepath."/../helpers/format.php");
?>

<?php

/**
 * summary
 */
class Category{
	private $db;
	private $fm;
   
    public function __construct(){
   		$this->db = new Database();
   		$this->fm = new Format();     
    }
   
    public function catInsert($catName){
    	$catName = $this->fm->validation($catName);
    	$catName = mysqli_real_escape_string($this->db->link, $catName);
    	if (empty($catName)) {
            echo "<span class='error'><b>Field Must NOT Empty !!</b></span>";
    	}else{
    		$query = "INSERT INTO tbl_category(catName) VALUES('$catName')";
    		$insertCat = $this->db->insert($query);
    		if ($insertCat) {
    			echo "<span class='success'>Category Inserted Successfully</span>";
    		}else{
    			echo "<span class='error'>Category Not Inserted Successfully</span>";
    		}
    	}
    }

//getAllCat() [for catlist.php]
    public function getAllCat(){
    	$query = "SELECT * FROM tbl_category ORDER BY catId DESC";
    	$result = $this->db->select($query);
    	return $result;
    }


//getCatById() [for catedit.php]
    public function getCatById($id){
    	$query = "SELECT * FROM tbl_category WHERE catId = '$id'";
    	$result = $this->db->select($query);
    	return $result;
    }

    public function catUpdate($catName, $id){
    	$catName = $this->fm->validation($catName);
    	$catName = mysqli_real_escape_string($this->db->link, $catName);
    	if (empty($catName)) {
            $msg = "<span class='error'><b>Field Must NOT Empty !!</b></span>";
            return $msg;
    	}else{
    		$query = "UPDATE tbl_category
    				SET
    				catName = '$catName'
    				WHERE catId = '$id'";
    		$updated_row = $this->db->update($query);
    		if ($updated_row) {
    			$msg = "<span class='success'>Category Updated Successfully</span>";
    			return $msg;
    		}else{
    			$msg = "<span class='error'>Category Not Updated Successfully</span>";
    			return $msg;
    		}
    	}
    }

    public function delCatById($id){
    	$query = "DELETE FROM tbl_category WHERE catId='$id'";
    	$deldata = $this->db->delete($query);
    	if ($deldata) {
    		$msg = "<span class='success'>Category Deleted Successfully</span>";
    			return $msg;
    	}else{
    			$msg = "<span class='error'>Category Not Deleted Successfully</span>";
    			return $msg;
    		}
    }
}	
?>