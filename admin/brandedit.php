<?php 
    include 'inc/header.php';
    include 'inc/sidebar.php';
  //  include "../classes/brand.php";
?>


<div class="grid_10">
<div class="box round first grid">
    <h2>Update Brand</h2>
   <div class="block copyblock"> 
<?php
    if (!isset($_GET['brandid']) || $_GET['brandid']==NULL) {
        echo "<script>window.location='brandlist.php';</script>";
    }else{
       $id = $_GET['brandid'];
       // $id = preg_replace('/[^-a-zA-Z0-9_]/','',$_GET['brandid']);//this VALIDATION is optional 
    }

  //  $brand = new Brand();

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $brandName = $_POST['brandName'];
//which category we pick that's [$id] category.....so we need to pick both [$catName & $id]        
        $updateBrand = $brand->brandUpdate($brandName, $id);
    }
?>
<?php
    if (isset($updateBrand)) {
        echo $updateBrand;
    }
?>
<?php
   $getBrand = $brand->getBrandById($id);
   if($getBrand) {
       while ($result = $getBrand->fetch_assoc()) { 
?>
     <form action="" method="post">
        <table class="form">					
            <tr>
                <td>
                    <input type="text" name="brandName" value="<?php echo $result['brandName'];?>" class="medium" />
                </td>
            </tr>
			<tr> 
                <td>
                    <input type="submit" name="submit" Value="Save" />
                </td>
            </tr>
        </table>
        </form>
<?php  } } ?>

    </div>
</div>
</div>
<?php include 'inc/footer.php';?>