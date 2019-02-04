<?php include "inc/header.php";?>
<?php
   $login = Session::get("cuslogin");
   if ($login == false) {
   	   header("Location:login.php");	
   	}	
?>
<style>
table.tblone img {height:85px; width:100px;}	
</style>
<div class="main">
<div class="content">
<div class="cartoption">		
	<div class="cartpage">
	    	<h2>Compare</h2>
				<table class="tblone">
					<tr>
						<th width="5%">SN</th>
						<th width="30%">Product Name</th>
						<th width="10%">Image</th>
						<th width="15%">Price</th>
						<th width="10%">Action</th>
					</tr>

<?php
//get data using CUSTOMERID
  	$cmrId = Session::get("cmrId");
	$getPd = $pd->getComparedData($cmrId);
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

				<td><a href="details.php?proid=<?php echo $result['productId'];?>">View</a></td>
				
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
