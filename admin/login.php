<?php 
	include "../classes/adminlogin.php";
?>
<?php
	$al= new Adminlogin();
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$adminUser = $_POST['adminUser'];
		$adminPass = md5($_POST['adminPass']);

//add this[adminLogin] method at [adminlogin.php]
		$loginChk = $al->adminLogin($adminUser, $adminPass);
	}
?>


<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>
<span style='color:red;font-size:18px;'>
	<?php
		if (isset($loginChk)) {
			echo $loginChk;
		}
	?>
</span>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
		<form action="" method="post">
			<h1>Admin Login</h1>
			<div>
				<input type="text" placeholder="Username" name="adminUser"/>
			</div>
			<div>
				<input type="password" placeholder="Password" name="adminPass"/>
			</div>
			<div>
				<input type="submit" value="Log in" />
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="#">Our Ecommerce </a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>