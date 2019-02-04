<?php 
	include "inc/header.php";
?>
<?php
   if (!isset($_GET['search']) || $_GET['search'] == NULL) {
   	header("Location:404.php");
   } else{
   	$search = $_GET['search'];
   }
?>


 <div class="main">
    <div class="content">
    	<div class="section group">
	<!--			<div class="cont-desc span_1_of_2">	-->


	<?php
		$query = "SELECT * FROM tbl_product WHERE productName LIKE '%$search%' OR body LIKE '%$search%'";
		$post=$db->select($query);
		if ($post) {
			while ($result = $post->fetch_assoc()) {

	?>						

			<div class="grid_1_of_4 images_1_of_4">
				 <a href="details.php?proid=<?php echo $result['productId'];?>"><img src="admin/<?php echo $result['image'];?>" alt="" /></a>
				 <h2><?php echo $result['productName'];?> </h2>
				 <p><?php echo $fm->textshorten($result['body'], 50);?></p>
				 <p><span class="price"><?php echo $result['price'];?></span></p>
			     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId'];?>" class="details">Details</a></span></div>
			</div>


	<?php } } else { ?>
		<p>Your Search Query !!!!</p>
	<?php } ?>			
	

<!--	</div>-->



 		</div>
 	</div>
	</div>
	
<?php include "inc/footer.php";?>  
