<?php include "inc/header.php";?>

<?php
//when customer logged in then they can't redirect [LOGIN.PHP page] again
	$login = Session::get('cuslogin');
	if ($login) {
		header("Location:order.php");
	}
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $custLogin = $cmr->customerLogin($_POST);
    }
?>
 <div class="main">
    <div class="content">
    	 <div class="login_panel">
	
<?php
    if (isset($custLogin)) {
        echo $custLogin;
    }
?>

        	<h3>Existing Customers</h3>
        	<p>Sign in with the form below.</p>
        	<form action="" method="post">
                	<input type="text" name="email" placeholder="Email"/>
                    <input type="password" name="pass" placeholder="Password"/>
          
				<div class="buttons"><div><button class="grey" name="login">Sign In</button></div></div>
            </div>
            </form>
              <!--    <p class="note">If you forgot your passoword just enter your email and click <a href="#">here</a></p> -->
                   
    	

    	<div class="register_account">

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
        $customerReg = $cmr->customerRegistration($_POST);
    }
?>
<?php
    if (isset($customerReg)) {
        echo $customerReg;
    }
?>
	
    		<h3>Register New Account</h3>
    		
    		<form action="" method="post">
   			 <table>
   				<tbody>
				<tr>
				<td>
					<div>
					<input type="text" name="name" placeholder="Enter Your Name ">
					</div>
					<div>
					   <input type="text" name="city" placeholder="Enter Your City">
					</div>
					
					<div>
						<input type="text" name="zip" placeholder="Enter Your Zip-Code">
					</div>
					<div>
						<input type="text" name="email" placeholder="Enter Your E-mail">
					</div>
    			 </td>
    			<td>
				<div>
					<input type="text" name="address" placeholder="Enter Your Address">
				</div>
    		<div>
				<input type="text" name="country" placeholder="Enter Your Country">
			</div>		        

		        <div>
		     		 <input type="text" name="phone" placeholder="Enter Your Phone">
		        </div>
				  
				  <div>
					<input type="text" name="pass" placeholder="Enter Your Password">
				</div>
		    	</td>
		    </tr> 
		    </tbody>
		</table> 
		   <div class="search"><div><button class="grey" name="register">Create Account</button></div></div>
		    
		    <div class="clear"></div>
		    </form>
    	</div>  	
       
       <div class="clear"></div>
    </div>
 </div>
</div>
  
<?php include "inc/footer.php";?>  
