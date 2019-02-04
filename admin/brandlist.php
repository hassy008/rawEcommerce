<?php 
    include 'inc/header.php';
    include 'inc/sidebar.php';
  //  include "../classes/brand.php";
?>

<?php
//	$brand = new Brand();

//for delete brand
	if (isset($_GET['delbrand'])) {
		$id = $_GET['delbrand'];
		$id = preg_replace('/[^-a-zA-Z0-9_]/','',$_GET['delbrand']);//this VALIDATION is optional 
		$delBrand = $brand->delBrandById($id);	
		}
?>

<div class="grid_10">
<div class="box round first grid">
    <h2>Brand List</h2>
    <div class="block">  
<?php 
//this code use to show inside our brandlist page that data deleted successfully
	if (isset($delBrand)) {
		echo $delBrand;
}
?>           
        <table class="data display datatable" id="example">
		<thead>
			<tr>
				<th>Serial No.</th>
				<th>Brand Name</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>

<?php
//get data from [DB->brandlist]...
	$getBrand = $brand->getAllBrand();
	if ($getBrand) {
		$i=0;
		while ($result = $getBrand->fetch_assoc()) {
		    $i++;
?>
			<tr class="odd gradeX">
				<td><?php echo $i;?></td>
				<td><?php echo $result['brandName'];?></td>
				<td><a href="brandedit.php?brandid=<?php echo $result['brandId'];?>">Edit</a> || <a onclick="return confirm('Are you sure to delete')" href="?delbrand=<?php echo $result['brandId'];?>">Delete</a></td>
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

