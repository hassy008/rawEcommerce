<?php include "inc/header.php";?>

<style>
a:link {text-decoration: none;}
a:hover {color:red;}
a {text-decoration: none; color: black;}
</style>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name  = $fm->validation($_POST['name']) ; 
  $email = $fm->validation($_POST['email']) ;
  $phone = $fm->validation($_POST['phone']) ;
  $body  = $fm->validation($_POST['body']) ; 

    $name  = mysqli_real_escape_string($db->link, $name) ;
    $email = mysqli_real_escape_string($db->link, $email); 
    $phone = mysqli_real_escape_string($db->link, $phone) ; 
    $body  = mysqli_real_escape_string($db->link, $body) ; 
 
 	$errorn = "";
 	$errore = "";
 	$errorp = "";
 	$errorb = "";
 	if (empty($name)) {
 	   $errorn = "Name Must Not Empty !";
 	}if (empty($email)) {
 	   $errore = "Email Must Not Empty !";
 	}if (empty($phone)) {
 	   $errorp = "Phone Must Not Empty !";
 	}if (empty($body)) {
 	   $errorb = "Message Must Not Empty !";
 	}

/* 	another way
if (empty($name)) {
 	  $error = "Name Must Not Empty !";
 	}elseif (empty($email)) {
 	   $error = "Email Must not Empty !";	
 	}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 	   $error = "Invaid Email !";
 	}elseif (empty($phone)) {
 	   $error = "Phone Must not Empty !";
 	}elseif (empty($body)) {
 	   $error = "Message Must not Empty !";
 	}*/
 	else{
 		$query = "INSERT INTO tbl_contact(name,	email, phone,	body) VALUES('$name', '$email', '$phone', '$body' )";
 		$inserted_rows = $db->insert($query);
 		if ($inserted_rows) {
 			$msg = "<span style='color:green'>Message Sent Successfully</span>";
 			echo $msg;
 		}else{
 			$error = "<span style='color:red'>Not Yet!!!</span>";
 		}
 	}
}
?>

<div class="main">
<div class="content">
<div class="support">
		<div class="support_desc">
			<h3>Live Support</h3>
			<p><span>24 hours | 7 days a week | 365 days a year &nbsp;&nbsp; Live Technical Support</span></p>
			<p> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
		</div>
			<img src="web/images/contact.png" alt="" />
		<div class="clear"></div>
	</div>
<div class="section group">
		<div class="col span_2_of_3">
		  <div class="contact-form">
		  	<h2>Contact Us</h2>

<!-- <?php
	if (isset($error)) {
		echo "<span style='color:red'>$error</span>";
	} if (isset($msg)) {
		echo "<span style='color:green'>$msg</span>";
	}
?> -->

		      <form action="" method="post">
		    	<div>
			    	<span><label>NAME</label></span>
		<?php 
if (isset($errorn)){
	 echo "<span style='color:red'>$errorn</span>"; 
	} ?>	 
  	
			    	<span><input type="text" name="name" value=""></span>
			    </div>
			    <div>
			    	<span><label>E-MAIL</label></span>
		<?php 
if (isset($errore)){
	echo "<span style='color:red'>$errore</span>"; 
} ?>	   
	
			    	<span><input type="text" name="email" value=""></span>
			    </div>
			    <div>
			     	<span><label>MOBILE.NO</label></span>
		<?php 
if (isset($errorp)){
	echo "<span style='color:red'>$errorp</span>"; 
} ?>	   
 	
			    	<span><input type="text" name="phone" value=""></span>
			    </div>
			    <div>
			    	<span><label>SUBJECT</label></span>
		<?php 
if (isset($errorb)){
	echo "<span style='color:red'>$errorb</span>"; 
} ?>	
    	
			    	<span><textarea name="body"> </textarea></span>
			    </div>
			   <div>
			   		<span><input type="submit" value="SUBMIT"></span>
			   </div>
		     </form>
		  </div>
			</div>
		<div class="col span_1_of_3">
			<div class="company_address">
		     	<h2>Company Information :</h2>
				    	<p>500 Lorem Ipsum Dolor Sit,</p>
				   		<p>22-56-2-9 Sit Amet, Lorem,</p>
				   		<p>USA</p>
		   		<p>Phone:(00) 222 666 444</p>
		   		<p>Fax: (000) 000 00 00 0</p>
		 	 	<p>Email: <span>info@mycompany.com</span></p>
<?php
    $query = "SELECT * FROM tbl_social WHERE id='1'";
    $post  = $db->select($query);
   // $blog_title = $db->select($query);
    if ($post) {
       while ($result = $post->fetch_assoc()) {
?>
		   		<p>Follow on: 
		   			<span><a href="<?php echo $result['fb'];?>">Facebook</a></span>, 
		   			<span><a href="<?php echo $result['tw'];?>">Twitter</a></span></p>
<?php  } } ?>		   
		   </div>
		 </div>
	  </div>    	
    </div>
 </div>
</div>

   <?php include "inc/footer.php";?>  
