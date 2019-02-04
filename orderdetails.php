<?php include 'inc/header.php'; ?>
 
<?php
//if login is not true
	$login = Session::get("cuslogin");
	if ($login == false) {
		header("Location:login.php");	
	}
?>

<?php
//shipped.....[set->shipid]....AND [get $id=$_GET['shipid'] from ---status---- ]
  if (isset($_GET['customerid'])) {
  	$id    = $_GET['customerid'];
  	$time  = $_GET['time'];
  	$price = $_GET['price'];

  	$confirm = $ct->productShippedConfirm($id, $time, $price);
  }
?>
<div class="main">
	<div class="content">
		<div class="section group">
			<div class="order">
				<h2>Your Order Details</h2>
				<table class="tblone">
					<tr>
						<th>SN</th>
						<th>Product Name</th>
						<th>Image</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>

<?php
	$cmrId  = Session::get("cmrId"); //we pick just a single customer
	$getOrder = $ct->getOrderedProduct($cmrId);
	if ($getOrder) {
		$i=0;
		//$sum = 0; //sum initiate from 0+add [TOTAL]
		$qty = 0;
		while ($result = $getOrder->fetch_assoc()) {
		   $i++; 
?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $result['productName'];?></td>
						<td><img src="admin/<?php echo $result['image'] ;?>" height="60px" alt=""/></td>
						<td><?php echo $result['quantity'];?></td>
						<td><?php 
		//creating total option when we click [UPDATE button]
							echo "$".$result['price'];?>		
						</td>
						<td><?php echo $fm->formatDate($result['date']);?></td>
					

						<td>
				<?php 
				   if ($result['status'] == '0'){
				   	 echo 'Pending';
				   }elseif ($result['status'] == '1'){ 
				   		echo "Shipped";
				  }else{
				   	echo "Done";
				   }
				?>	
						</td>
				<?php 
					if ($result['status'] == '1') { ?>
					  <td>	<a onclick="return confirm('Do you get your purchase already!!! Thank you Dear, See you again');" href="?customerid=<?php echo $result['cmrId'];?> & price=<?php echo $result['price'];?>&time=<?php echo $result['date'];?>">Confirm</a>
					  </td>	
				<?php	} elseif($result['status'] == '2'){ ?>
					<td>OK</td>
				<?php }elseif($result['status'] == '0'){ ?>
					<td>N/A</td>
				<?php } ?>



<!-- just same result avobe [status & action] 
<?php 
	   if ($result['status'] == '0'){
	   	 echo 'Pending';
	   }elseif ($result['status'] == '1'){ ?>
	   	<a href="?customerid=<?php echo $result['cmrId'];?> & price=<?php echo $result['price'];?>&time=<?php echo $result['date'];?>">Shipped</a>
	<?php   }else{
	   	echo "Confirm";
	   }
	?>	
			</td>
	<?php 
		if ($result['status'] == '1') { ?>
		  <td><a onclick="return confirm('Are You Sure To Delete!');" href="">X</a>
		  </td>	
	<?php	} else{ ?>
		<td>N/A</td>
<?php } ?> -->
	
					</tr>
	<?php } } ?>			
					
				</table>

			</div>	
		</div>
		<div class="clear"></div>
	</div>
</div>

<?php include "inc/footer.php";?>