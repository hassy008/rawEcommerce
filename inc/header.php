<?php 
    include "lib/session.php"; 
    Session::init();

    include "lib/database.php";
    include "helpers/format.php";

    //spl_autoload using all classes fetch together

    spl_autoload_register(function($class){
    	include_once "classes/".$class.".php";
    });

    $db = new Database();
    $fm = new Format();
    $pd = new Product();
    $cat= new Category();
    $ct = new Cart();
    $cmr= new Customer();
?>

<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache"); 
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  header("Cache-Control: max-age=2592000");
?> 

<!DOCTYPE HTML>
<head>
<title>Store Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>
<script src="js/jquerymain.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script> 
<script type="text/javascript" src="js/nav-hover.js"></script>
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
<script type="text/javascript">
  $(document).ready(function($){
    $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'fast',effect:'fade'});
  });
</script>
</head>
<body>
  <div class="wrap">
	<div class="header_top">
	
		<div class="logo">
<!--Dynamic TITLE Update Option Began-->				
	<?php
    $query = "SELECT * FROM tbl_updatetitle WHERE id='1'";
    $post=$db->select($query);
   // $blog_title = $db->select($query);
    if ($post) {
       while ($result = $post->fetch_assoc()) {
?>		
		<a href="index.php"><img src="admin/<?php echo $result['logo'];?>" alt="" /></a>
		<!--<h3><?php echo $result['title'];?></h3>
			<p><?php echo $result['slogan'];?></p>-->	
	<?php } } ?>		
		</div>
<!--Dynamic TITLE Update Option End-->		
		  
		  <div class="header_top_right">
	<!--Dynamic Search Option Began-->	    
		    <div class="search_box">
			    <form action="search.php" method="get">
			    	<input type="text" name="search" placeholder="Search for Products"/>
			    	<input type="submit" name="submit" value="Search">
			    </form>
		    </div>
	<!--Dynamic Search Option End-->			    

		    <div class="shopping_cart">
				<div class="cart">
					<a href="cart.php" title="View my shopping cart" rel="nofollow">
							<span class="cart_title">Cart</span>
							<span class="no_product">
		<?php
		$getData = $ct->ChkCartTbl();
		if ($getData) {
			$sum = Session::get("sum");
			$qty = Session::get("qty");
				//echo "$".$sum;
			echo "$".$sum."| Qty:".$qty;	
			}else{
				echo "(Empty)";
			}
		?>
							</span>
						</a>
					</div>
		    </div>
	   
<?php
	if (isset($_GET['cid'])) {
	$cmrId = Session::get("cmrId");//use to [$delComp]	
		$delData = $ct->delCustomerCart();//$delData used to DELETE data from your [tbl_cart] when you [logout]..and you should write this code before destroy your session..
		
		$delComp = $pd->delCompareData($cmrId);
		
		Session::destroy();//for logout
	}
?>
<!-- <?php
	
	
	//Session::destroy();//for logout
?> -->

		   <div class="login">
<?php
	$login = Session::get("cuslogin");
	if ($login == false) { ?>
		<a href="login.php">Login</a>	
<?php	}else { ?> 
		<a href="?cid=<?php Session::get('cmrId')?>">Logout</a>
<?php	} ?>

		   </div>
		 <div class="clear"></div>
	 </div>
	 <div class="clear"></div>
 </div>
<div class="menu">
	<ul id="dc_mega-menu-orange" class="dc_mm-orange">
	  <li><a href="index.php">Home</a></li>

	  <li><a href="topbrands.php">Top Brands</a></li>

<?php
//showing [CART & PAYMENT] when customer added some product to their [CART]
	$chkCart = $ct->ChkCartTbl();
	if ($chkCart) { ?>
		<li><a href="cart.php">Cart</a></li>
		<li><a href="payment.php">Payment</a></li>
<?php 	} ?>

<?php
	$cmrId = Session::get("cmrId");
	$chkOrder = $ct->ChkOrder($cmrId);
	if ($chkOrder) { ?>
		<li><a href="orderdetails.php">Order</a></li>
<?php	} ?>	
	  

<?php
//customer get [PROFILE option] when they're logged in
	$login = Session::get("cuslogin");
	if ($login == true) { ?>
		<li><a href="profile.php">Profile</a></li>
<?php 	} ?>
	  

<?php
	$cmrId = Session::get("cmrId");
	$getPd = $pd->getComparedData($cmrId);
	if ($getPd) {
?>  
	  <li><a href="compare.php">Compare</a> </li>
<?php } ?>  
<?php
	$cmrId = Session::get("cmrId");
	$chkwlist = $pd->getWlistData($cmrId);
	if ($chkwlist) {
?>  
	  <li><a href="wishlist.php">Wishlist</a> </li>
<?php } ?>  


	  <li><a href="contact.php">Contact</a> </li>
	  <div class="clear"></div>
	</ul>
</div>