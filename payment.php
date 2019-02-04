<?php include 'inc/header.php'; ?>
 <?php
//if login is not true
	$login = Session::get("cuslogin");
	if ($login == false) {
		header("Location:login.php");	
	}
 ?>
<style>
</style>


<div class="main">
	<div class="content">
		<div class="section group">
			<div class="payment">
				<h2>Choose your Payment Method</h2>
				<a href="paymentoffline.php">Offline Payment</a>
				<a href="paymentonline.php">Online Payment</a>
			</div>	
		
			<div class="back">
				<a href="cart.php">Previous</a>
			</div>

		</div>
	</div>
</div>

<?php include "inc/footer.php";?>