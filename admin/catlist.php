<?php 
    include 'inc/header.php';
    include 'inc/sidebar.php';
  //  include "../classes/category.php";
?>

<?php
//	$cat = new Category();

//for delete cat
	if (isset($_GET['delcat'])) {
		$id = $_GET['delcat'];
		//$id = preg_replace('/[^-a-zA-Z0-9_]/','',$_GET['delCat']);//this VALIDATION is optional 
		$delCat = $cat->delCatById($id);	
		}	
?>

<div class="grid_10">
<div class="box round first grid">
    <h2>Category List</h2>
    <div class="block">  
<?php 
//this code use to show inside our catlist page that data deleted successfully
	if (isset($delCat)) {
		echo $delCat;
}
?>	          
        <table class="data display datatable" id="example">
		<thead>
			<tr>
				<th>Serial No.</th>
				<th>Category Name</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>

<?php
//get data from [DB->catlist]...
	$getCat = $cat->getAllCat();
	if ($getCat) {
		$i=0;
		while ($result = $getCat->fetch_assoc()) {
		    $i++;
?>
			<tr class="odd gradeX">
				<td><?php echo $i;?></td>
				<td><?php echo $result['catName'];?></td>
				<td>
					<!-- <a href="catedit.php?catid=<?php echo $result['catId'];?>">Edit</a> || 
					<a onclick="return confirm('Are you sure to delete')" href="?delcat=<?php echo $result['catId'];?>">Delete</a> -->

					 <a href="catedit.php?catid=<?php echo $result['catId'];?>" class="btn btn-success">
                      <span class="glyphicon glyphicon-edit"></span>	
                    </a>
                    <a onclick="return confirm('Are you sure to delete')" href="?delcat=<?php echo $result['catId'];?>" class="btn btn-danger">
                    	<span class="glyphicon glyphicon-trash"></span>
                    </a>
				</td>
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

