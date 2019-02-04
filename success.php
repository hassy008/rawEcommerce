<?php include 'inc/header.php'; ?>
 <?php
//if login is not true
	$login = Session::get("cuslogin");
	if ($login == false) {
		header("Location:login.php");	
	}
 ?>
<style>
.paysuccess{width:500px;min-height: 200px;border: 1px solid black;text-align: center;margin:0 auto;padding: 20px;}
.paysuccess h2{border-bottom: 1px solid;margin-bottom: 25px;padding-bottom: 5px;color: green;}
.paysuccess p{text-align:left;font-family:serif;font-size:20px;}
</style>


<div class="main">
	<div class="content">
		<div class="section group">
			<div class="paysuccess">
				<h2>Success</h2>
<?php
	$cmrId  = Session::get("cmrId"); //we pick just a single customer
	$amount = $ct->payableAmount($cmrId);
//now we sum our amount 
	if ($amount) {
			$sum = 0;
			while ($result = $amount->fetch_assoc()) {
			    $price = $result['price'];
			    $sum   = $sum + $price; 
			}
		}

?>

				<p>Total Payable Amount(Including VAT 10%) : $
	<?php
		$vat = $sum*0.1;
		$total = $vat+$sum;
		echo $total;	
	?>			
				</p>
				<p>Thanks for purchase.Receive your order successfully. We will contact with you ASAP with delivery details. Here is your order details...<a href="orderdetails.php">Visit Here...</a></p>
			</div>	

		</div>
	</div>
</div>

<?php include "inc/footer.php";?>