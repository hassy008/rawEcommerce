<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>



<div class="grid_10">
<div class="box round first grid">
    <h2>Inbox</h2>

<!--Message Sent To Seen Box Began-->
<?php
	if (isset($_GET['seenid'])) {
		$seenid = $_GET['seenid'];

	$query = "UPDATE tbl_contact
			SET
			status = '1'
			WHERE id = '$seenid'";
	$updated_row = $db->update($query);
	if ($updated_row) {
		echo "<span class='success'>Message Sent to the Seen Box</span>";	
	}else {
		echo "<span class='success'>Message NOT Sent to the Seen Box</span>";
	}	
}
?>
<!--Message Sent To Seen Box END-->

    <div class="block">        
        <table class="data display datatable" id="example">
		<thead>
			<tr>
				<th>Serial No.</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Message</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
<?php
	$query = "SELECT * FROM tbl_contact WHERE status='0' ORDER BY id DESC ";
	$msg   = $db->select($query);
	if ($msg) {
		$i = 0;
		while ($result = $msg->fetch_assoc()) {
		    $i++;
?>
			<tr class="odd gradeX">
				<td><?php echo $i;?></td>
				<td><?php echo $result['name'];?></td>
				<td><?php echo $result['email'];?></td>
				<td><?php echo $result['phone'];?></td>
				<td><?php echo $fm->textShorten($result['body'],40);?></td>
				<td><?php echo $fm->formatDate($result['date']);?></td>
				<td><a href="viewmsg.php?msgid=<?php echo $result['id'];?>">View</a> || 
					<a href="replymsg.php?msgid=<?php echo $result['id'];?>">Reply</a>|| 
		<a onclick="return confirm('Are You Sure To Remove');" href="?seenid=<?php echo $result['id'];?>">Seen</a>
				</td>
			</tr>
<?php } } ?>			
		</tbody>
	</table>
   </div>
</div>

<div class="box round first grid">
    <h2>Seen Message</h2>
<!--Message Delete From Seen Box Began-->
<?php
if (isset($_GET['delid'])) {
	$delid = $_GET['delid'];
	$delquery = "DELETE FROM tbl_contact WHERE id='$delid'";
	$deldata  = $db->delete($delquery);
	if ($deldata) {
		echo "<span class='success'>Message Deleted</span>";
	}else{
		echo "<span class='error'>Message Not Deleted</span>";
	}
}
?>
<!--Message Delete From Seen Box End-->

<!--Message Sent To Inbox Began-->
<?php
	if (isset($_GET['unseen'])) {
		$unseen = $_GET['unseen'];

	$query = "UPDATE tbl_contact
			SET
			status = '0'
			WHERE id = '$unseen'";
	$updated_row = $db->update($query);
	if ($updated_row) {
		echo "<span class='success'>Message Sent to the Seen Box</span>";	
	}else {
		echo "<span class='success'>Message NOT Sent to the Seen Box</span>";
	}	
}
?>
<!--Message Sent ToInbox END-->

    <div class="block">        
        <table class="data display datatable" id="example">
		<thead>
			<tr>
				<th>Serial No.</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Message</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
<?php
	$query = "SELECT * FROM tbl_contact WHERE status='1' ORDER BY id DESC ";
	$msg   = $db->select($query);
	if ($msg) {
		$i = 0;
		while ($result = $msg->fetch_assoc()) {
		    $i++;
?>
			<tr class="odd gradeX">
				<td><?php echo $i;?></td>
				<td><?php echo $result['name'];?></td>
				<td><?php echo $result['email'];?></td>
				<td><?php echo $result['phone'];?></td>
				<td><?php echo $fm->textShorten($result['body'],40);?></td>
				<td><?php echo $fm->formatDate($result['date']);?></td>
				<td> 
		<a onclick="return confirm('Are You Sure To DELETE');" href="?delid=<?php echo $result['id'];?>">Delete</a> || 
		<a onclick="return confirm('Are You Confirm To Unseen Message');" href="?unseen=<?php echo $result['id'];?>">Unseen</a>
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
