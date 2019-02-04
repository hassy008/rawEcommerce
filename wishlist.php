<?php include "inc/header.php";?>
<?php
   $login = Session::get("cuslogin");
   if ($login == false) {
   	   header("Location:login.php");	
   	}	
?>

<?php
$cmrId = Session::get("cmrId");
	if (isset($_GET['delwlistid'])) {
		$productId = $_GET['delwlistid'];
		$delwlist = $pd->delWlistData($cmrId, $productId);
	}
?>

<style>
.cartpage h2{width:100%; text-align:center;} 	
table.tblone img {height:65px; width:80px;
}
</style>
<div class="main">
<div class="content">
<div class="cartoption">		
	<div class="cartpage">
	    	<h2>Your Wishlist</h2>
				<table class="tblone">
					<tr>
						<th >SN</th>
						<th >Product Name</th>
						<th >Image</th>
						<th >Price</th>
						<th >Action</th>
					</tr>

<?php
//get data using CUSTOMERID
  	$cmrId = Session::get("cmrId");
	$getPd = $pd->getWlistData($cmrId);
	if ($getPd) {
		$i=0;
		while ($result = $getPd->fetch_assoc()) {
		$i++; 
?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $result['productName'];?></td>
				<td><?php echo $result['price'];?></td>
				<td><img src="admin/<?php echo $result['image'] ;?>" height="30px" alt=""/></td>


<?php
	if (isset($delwlist)) {
		echo $delwlist;
	}
?>
				<td>
					<a href="details.php?proid=<?php echo $result['productId'];?>">Buy Now</a> || 
					<a onclick="return confirm('Are You Sure To Remove Product From Your Wishlist..');" href="?delwlistid=<?php echo $result['productId'];?>">Remove</a>
				</td>
				
			</tr>

	<?php } } ?>			
					
				</table>
			</div>
			<div class="shopping" >
				<div class="shopleft" style="width: 100%; text-align: center">
					<a href="index.php"> <img src="images/shop.png" alt="" /></a>
				</div>
				
<!-- 				<div class="shopright">
					<a href="payment.php"> <img src="images/check.png" alt="" /></a>
				</div> -->
			</div>
</div>  	
<div class="clear"></div>
</div>
</div>


<?php include "inc/footer.php";?>  
