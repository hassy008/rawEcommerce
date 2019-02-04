<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../classes/cart.php');
	$ct = new Cart();
	$fm = new Format();
?>
<?php
//shipped.....[set->shipid]....AND [get $id=$_GET['shipid'] from ---status---- ]
  if (isset($_GET['shipid'])) {
  	$id    = $_GET['shipid'];
  	$time  = $_GET['time'];
  	$price = $_GET['price'];

  	$shipped = $ct->productShipped($id, $time, $price);
  }

 //remove
   if (isset($_GET['delproid'])) {
  	$id    = $_GET['delproid'];
  	$time  = $_GET['time'];
  	$price = $_GET['price'];

  	$delOrder = $ct->delProductShipped($id, $time, $price);
  }

?>

<div class="grid_10">
<div class="box round first grid">
    <h2>Order</h2>

<?php
	if (isset($shipped)) {
		echo $shipped;
	}
	
	if (isset($delOrder)) {
		echo $delOrder;
	}

?>

    <div class="block">        
        <table class="data display datatable" id="example">
		<thead>
			<tr>
				<th>ID</th>
				<th>Order Time</th>
				<th>Product</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Cust ID</th>
				<th>Address</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
<?php
	$getOrder = $ct->getAllOrderProduct(); 
	if ($getOrder) {
		while ($result = $getOrder->fetch_assoc()) {
?>

			<tr class="odd gradeX">
				<td><?php echo $result['id'];?></td>
				<td><?php echo $fm->formatDate($result['date']);?></td>
				<td><?php echo $result['productName'];?></td>
				<td><?php echo $result['quantity'];?></td>
				<td>$<?php echo $result['price'];?></td>
				<td><?php echo $result['cmrId'];?></td>
				<td><a href="customer.php?custId=<?php echo $result['cmrId'];?>">View Detials</a></td>
<?php
//this block for [STATUS]
	if ($result['status'] == '0') { ?>
		<td><a href="?shipid=<?php echo $result['cmrId'];?> & price=<?php echo $result['price'];?>&time=<?php echo $result['date'];?>">Shipped</a></td>
<?php	} elseif($result['status'] == '1') { ?>
			<td>Pending</td>
<?php }else { ?>
		<td><a href="?delproid=<?php echo $result['cmrId'];?> & price=<?php echo $result['price'];?> & time=<?php echo $result['date'];?>">Remove</a></td>

<?php }?>				
			</tr>



<?php } } ?>			
		</tbody>
	</table>
   </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
