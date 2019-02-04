<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Site Title and Description</h2>
        <div class="block sloginblock">               


<?php
    $query = "SELECT * FROM tbl_updatetitle WHERE id='1'";
    $post=$db->select($query);
   // $blog_title = $db->select($query);
    if ($post) {
       while ($result = $post->fetch_assoc()) {
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $fm->validation($_POST['title']) ; 
  $slogan = $fm->validation($_POST['slogan']) ; 

    $title = mysqli_real_escape_string($db->link, $title) ; 
    $slogan = mysqli_real_escape_string($db->link, $slogan) ; 



    $permited  = array('png');
    $file_name = $_FILES['logo']['name'];
    $file_size = $_FILES['logo']['size'];
    $file_temp = $_FILES['logo']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "upload/".$unique_image;

    if ($title == "" || $slogan == "") {
       echo "<span class='error'>Field Must Not Empty !</span>";
    }else{
      if (!empty($file_name)) {
        if ($file_size > 1048567) {
          echo "<span class='error'>Upload File too large !</span>";
          }elseif(in_array($file_ext, $permited) === false) {
     echo "<span class='error'>You can upload only:-"
     .implode(', ', $permited)."</span>";
           }else{
              move_uploaded_file($file_temp, $uploaded_image);
    $query = "UPDATE tbl_updatetitle 
                SET
                title = '$title',
                slogan = '$slogan',
                logo = '$uploaded_image'
                WHERE id ='1'"; 
    $updated_row = $db->update($query);
    if ($updated_row) {
        echo "<span class='success'>Updated !</span>";
        }else{
         echo "<span class='error'>Field Must Not Empty !</span>";
        }            
     }
  }else{
     $query = "UPDATE tbl_updatetitle 
                SET
                title = '$title',
                slogan = '$slogan'
                WHERE id ='1'"; 
    $updated_row = $db->update($query);
    if ($updated_row){
        echo "<span class='success'>Updated !</span>";
    }else{
       echo "<span class='error'>Field Must Not Empty !</span>"; 
      }
    }
  }
}
?>

         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">					
                <tr>
                    <td>
                        <label>Website Title</label>
                    </td>
                    <td>
                        <input type="text" value="<?php echo $result['title'];?>" placeholder="Enter Website Title..."  name="title" class="medium" />
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Website Slogan</label>
                    </td>
                    <td>
                        <input type="text" value="<?php echo $result['slogan'];?>"  placeholder="Enter Website Slogan..." name="slogan" class="medium" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Upload Logo</label>
                    </td>
                    <td>
                        <input type="file" value="<?php echo $result['logo'];?>" name="logo" />
                    </td>
                </tr>
				 
				
				 <tr>
                    <td>
                    </td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>

<?php } } ?>

        </div>
    </div>
</div>
<?php include 'inc/footer.php';?>