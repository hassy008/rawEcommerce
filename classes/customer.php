<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath."/../lib/database.php");
include_once ($filepath."/../helpers/format.php");

?>
<?php
/**
 * summary
 */
class Customer{
	private $db;
	private $fm;
	
	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function customerRegistration($data){
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$city = mysqli_real_escape_string($this->db->link, $data['city']);
		$country = mysqli_real_escape_string($this->db->link, $data['country']);
		$zip = mysqli_real_escape_string($this->db->link, $data['zip']);
		$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$pass = mysqli_real_escape_string($this->db->link, $data['pass']);
		if ($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "" || $pass == "" ) {
			$msg ="<span class='error'>Field Must Not Empty !!!</span>";
			return $msg;
		}
		$mailquery = "SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
		$mailchk   = $this->db->select($mailquery);
		if ($mailchk) {
			$msg ="<span class='error'>SORRY,This Email Exist Already !!!</span>";
			return $msg;
		}else{
			$query = "INSERT INTO tbl_customer(name,address,city,country,zip,phone,email,pass) VALUES ('$name','$address','$city','$country','$zip','$phone','$email','$pass')";
		    $insert_row = $this->db->insert($query);
	    		if ($insert_row) {
	    			echo "<span class='success'>Register Successfully</span>";
	    		}else{
	    			echo "<span class='error'> Not  Successfully</span>";
	    		}
		}
	}

	public function customerLogin($data){
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$pass = mysqli_real_escape_string($this->db->link, $data['pass']);
		if (empty($email) || empty($pass)) {
			$msg ="<span class='error'>Field Must Not Empty !!!</span>";
			return $msg;
		}
		$query = "SELECT * FROM tbl_customer WHERE email='$email' AND pass='$pass'";
		$result = $this->db->select($query);
		if ($result != false) {
			$value = $result->fetch_assoc();
			Session::set("cuslogin", true);
			Session::set("cmrId", $value['id']);
			Session::set("cmrName", $value['name']);
			header("Location:index.php");
		}else{
			$msg ="<span class='error'>Field  Not Matched !!!</span>";
			return $msg;
		}
	}

	public function getCustomerData($id){
		
		$query  = "SELECT * FROM tbl_customer WHERE id='$id'";
		$result = $this->db->select($query);
		return $result; 
	}

	public function customerUpdate($data, $cmrId){
		$name    = mysqli_real_escape_string($this->db->link, $data['name']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$city    = mysqli_real_escape_string($this->db->link, $data['city']);
		$country = mysqli_real_escape_string($this->db->link, $data['country']);
		$zip     = mysqli_real_escape_string($this->db->link, $data['zip']);
		$phone   = mysqli_real_escape_string($this->db->link, $data['phone']);
		$email   = mysqli_real_escape_string($this->db->link, $data['email']);
		
		if ($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "" ) {
			$msg ="<span class='error'>Field Must Not Empty !!!</span>";
			return $msg;
		} else{
		  	$query       = "UPDATE tbl_customer
				   			SET
				   			name='$name',
				   			address='$address',
				   			city='$city',
				   			country='$country',
				   			zip='$zip',
				   			phone='$phone',
				   			email='$email'
				   			WHERE id = '$cmrId'"; //here [id=tbl_customer] & [$cmrId = which one we pick at function class]
		    $updated_row = $this->db->update($query);
	    		if ($updated_row) {
	    			echo "<span class='success'>Update Successful</span>";
	    		}else{
	    			echo "<span class='error'> Not  Successfully</span>";
	    		}
		}
	}



}    
?>