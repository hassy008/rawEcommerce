<?php include "inc/header.php";?>
<?php 
	if (isset($_GET['delpro'])) {
		$delid = $_GET['delpro'];
		$delProduct = $ct->delProByCart($delid);
	}
?>

<?php
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$cartId     = $_POST['cartId'];
		$quantity   = $_POST['quantity'];
		$updateCart = $ct->updateCartquantity($cartId, $quantity);
	}
?>
<?php
//solve session prblm and auto load cart price & quantity
	if (!isset($_GET['value'])) {
		echo "<meta http-equiv='refresh' content='0; URL=?value=live'/>";
	}
?>
<div class="main">
<div class="content">
<div class="cartoption">		
	<div class="cartpage">
	    	<h2>Your Cart</h2>

<?php
//update CART
	if (isset($updateCart)) {
		echo $updateCart;
	}

	if (isset($delProduct)) {
		echo $delProduct;
	}
?>
				<table class="tblone">
					<tr>
						<th width="5%">SN</th>
						<th width="30%">Product Name</th>
						<th width="10%">Image</th>
						<th width="15%">Price</th>
						<th width="15%">Quantity</th>
						<th width="15%">Total Price</th>
						<th width="10%">Action</th>
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
						<td><img src="admin/<?php echo $result['image'] ;?>" height="30px" alt=""/></td>
						<td><?php echo $result['price'];?></td>
			<td>
				<form action="" method="post">
					<input type="hidden" name="cartId" value="<?php echo $result['cartId'];?>"/>
					<input type="number" name="quantity" min="1" value="<?php echo $result['quantity'];?>"/>
					<input type="submit" name="submit" value="Update"/>
				</form>
			</td>
						<td><?php 
		//creating total option when we click [UPDATE button]
							$total = $result['price'] * $result['quantity'];
							echo $total;?>		
						</td>
						<td><a onclick="return confirm('Are You Sure To Delete!');" href="?delpro=<?php echo $result['cartId'];?>">X</a></td>
					</tr>
<?php
		//this block for HEADER OPTION
//here we creating SUB TOTAL..................		
	$sum = $sum + $total;
	Session::set("sum", $sum);
//adding qty at header [CART OPTION]
	$qty = $qty + $result['quantity'];
	Session::set("qty", $qty);			
?>

	<?php } } ?>			
					
				</table>
				
<?php
	$getData = $ct->ChkCartTbl();
			if ($getData) {
?>
				<table style="float:right;text-align:left;" width="40%">
					<tr>
						<th>Sub Total : </th>

						<td><?php echo $sum ;?></td>
					</tr>
					<tr>
						<th>VAT : </th>
						<td>10%</td>
					</tr>
					<tr>
						<th>Grand Total :</th>
						<td><?php
							$vat = $sum * 0.10;
							$grandTotal = $sum + $vat;
							echo $grandTotal;
						?></td>
					</tr>
			   </table>
<?php }else{
			header("Location:index.php");	
			}
?>			

			</div>
			<div class="shopping">
				<div class="shopleft">
					<a href="index.php"> <img src="images/shop.png" alt="" /></a>
				</div>
				<div class="shopright">
					<a href="payment.php"> <img src="images/check.png" alt="" /></a>
				</div>
			</div>
</div>  	
<div class="clear"></div>
</div>
</div>


<?php include "inc/footer.php";?>  
