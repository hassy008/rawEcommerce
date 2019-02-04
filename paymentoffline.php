<?php include 'inc/header.php'; ?>
 <?php
//if login is not true
	$login = Session::get("cuslogin");
	if ($login == false) {
		header("Location:login.php");	
	}
 ?>

<?php
//order block ..here we get [customer ID/ cmrId]
if (isset($_GET['orderid']) && $_GET['orderid'] == 'order') {
	$cmrId       = Session::get("cmrId");
	$insertOrder = $ct->orderProduct($cmrId);
//when a customer ORDER their product then [CART option will be empty]
	$delData = $ct->delCustomerCart();
	header("Location:success.php");	
}
?>

<style>
.division{width: 50%; float: left;}
.tblone{width: 500px; margin:0 auto; border: 2px solid #ddd;}
.tblone tr td{text-align: justify;}
.ordernow{padding-bottom: 30px;}
.ordernow a{width:200px;margin:20px auto 0;text-align: center;padding: 5px; font-size: 30px; display: block;background: red; color: white;border-radius: 4px;}
</style>


<div class="main">
	<div class="content">
		<div class="section group">
			<div class="division">
			  <table class="tblone">		
				<tr>
						<th>SN</th>
						<th>Product</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total </th>
					</tr>

<?php
	$getPro = $ct->getCartProduct();
	if ($getPro) {
		$i=0;
		$sum = 0; //sum initiate from 0+add [TOTAL]
		$qty = 0;
		while ($result = $getPro->fetch_assoc()) {
		   $i++; 
?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $result['productName'];?></td>

					<td><?php echo $result['price'];?></td>
					<td><?php echo $result['quantity'];?></td>

					<td><?php 
	//creating total option when we click [UPDATE button]	
						$total = $result['price'] * $result['quantity'];
						echo $total;?>		
					</td>
				</tr>
	<?php
//here we creating SUB TOTAL..................		
		$sum = $sum + $total;
		$qty = $qty + $result['quantity'];	
	?>

<?php } } ?>			
				
			</table>	

			<table class="tbltwo">
				<tr>
					<td>Sub Total</td>
					<td> : </td>
					<td><?php echo $sum ;?></td>
				</tr>
				<tr>
					<td>VAT </td>
					<td> : </td>
					<td>10%(<?php echo $vat = $sum * 0.1 ;?>)</td>
				</tr>
				<tr>
					<td>Quantity </td>
					<td> : </td>
					<td><?php echo $qty;?></td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td> : </td>
					<td><?php
						$vat = $sum * 0.10;
						$grandTotal = $sum + $vat;
						echo $grandTotal;
					?></td>
				</tr>
			  </table>
			</div>	
			

					<!--Profile Details Table -->
			<div class="division">
			  <?php
				$id      = Session::get("cmrId");
				$getdata = $cmr->getCustomerData($id);
				if ($getdata) {
					while ($result = $getdata->fetch_assoc()) {

			  ?>
		<table class="tblone">
			<tr>
				<td colspan="3" style='text-align:center;font-size: 18px;'>Your Profile Details</td>
			</tr>
			<tr>
				<td width="20%">Name</td>
				<td width="5%">:</td>
				<td><?php echo $result['name'];?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td>:</td>
				<td><?php echo $result['email'];?></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td>:</td>
				<td><?php echo $result['phone'];?></td>
			</tr>
			<tr>
				<td>Address</td>
				<td>:</td>
				<td><?php echo $result['address'];?></td>
			</tr>
			<tr>
				<td>City</td>
				<td>:</td>
				<td><?php echo $result['city'];?></td>
			</tr>
			
			<tr>
				<td>Zipcode</td>
				<td>:</td>
				<td><?php echo $result['zip'];?></td>
			</tr>
			<tr>
				<td>Country</td>
				<td>:</td>
				<td><?php echo $result['country'];?></td>
			</tr>
			<tr>

				<td colspan="3" style='text-align:center;font-size: 18px;'><a href="editprofile.php">Update Profile</a></td>
			</tr>
		</table>
<?php } } ?>
			</div>	

		</div>
	</div>

<div class="ordernow"><a onclick="return confirm('Are you sure to Order!!')" href="?orderid=order">Order</a></div>

</div>

<?php include "inc/footer.php";?>  