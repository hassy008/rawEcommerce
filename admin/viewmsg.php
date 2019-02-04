<?php 
    include "inc/header.php";
    include "inc/sidebar.php";
?>

<div class="grid_10">
<div class="box round first grid">
    <h2>View Message</h2>
    <div class="block">    

<?php
    if (!isset($_GET['msgid']) || $_GET['msgid'] == NULL) {
        echo "<script>window.location = 'inbox.php'</script>";
    }else {
        $id = preg_replace('/[^-a-zA-Z0-9]/', '', $_GET['msgid']);
    }
?>
<?php
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		echo "<script>window.location = 'inbox.php'</script>";
	}
?>

     <form action="" method="post" enctype="multipart/form-data">
  
<?php
	$query = "SELECT * FROM tbl_contact WHERE id='$id'";
	$msg   = $db->select($query);
	if ($msg) {
		$i = 0;
		while ($result = $msg->fetch_assoc()) {
		    $i++;
?>     

        <table class="form">
           
            <tr>
                <td>
                    <label>Name</label>
                </td>
                <td>
                    <input type="text" readonly value="<?php echo $result['name'];?>" class="medium" />
                </td>
            </tr>
             <tr>
                <td>
                    <label>Email</label>
                </td>
                <td>
                    <input type="text" readonly value="<?php echo $result['email'];?>" class="medium" />
                </td>
            </tr>
             <tr>
                <td>
                    <label>Date</label>
                </td>
                <td>
                    <input type="text" readonly value="<?php echo $fm->formatDate($result['date']);?>" class="medium" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Phone</label>
                </td>
                <td>
                    <input type="text" readonly value="<?php echo $result['phone'];?>" class="medium" />
                </td>
            </tr>
			 <tr>
                <td>
                    <label>Message</label>
                </td>
                <td>
                    <textarea class="tinymce" readonly name="body" >
                        <?php echo $result['body'];?>
                    </textarea>
                </td>
            </tr>

			<tr>
                <td></td>
                <td>
                    <input type="submit" name="submit" Value="OK" />
                </td>
            </tr>
        </table>

<?php } } ?>        
        </form>
     
    </div>
</div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>