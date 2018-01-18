<?php   
include('header.php'); 
$errors = '';
$success = '';
$errorsc = '';
if(isset($_POST['loginbtn'])){
	$email = mysqli_real_escape_string($connection,$_REQUEST['email']);
	$password = mysqli_real_escape_string($connection,$_REQUEST['password']);

		$select = mysqli_query($connection,"SELECT * FROM members WHERE email='$email' and  password='$password' and activated='1'");
		if (mysqli_num_rows($select) == 1) {
		$result =	mysqli_fetch_array($select);
		$_SESSION['member_id'] = $result['id'];
		$_SESSION['login'] = '1';
	echo	$_SESSION['name'] = $result['name'];
		header("Location:index.php");
		}else
		{
			$errors .= "Email and password comnination does not match. or you will need to go through the mail";
			$errorsc = 1;
		}
	
}
?>





 
<div  class="col col-sm-5  col-xs-6  col-sm-push-3 col-xs-push-3 " id="form" >
	
		 
		<form action="login.php" class="form-group" method="post" name="form">
		<div class="form-group text-center ">
		<input type="email" name="email" class="form-control"  placeholder="Email" required/>
		</div>
		<div class="form-group">
		<input type="password" name="password" class="form-control"  placeholder="password" required/>
		</div><div class="form-group">
		<input type="submit" name="loginbtn" class="form-control btn btn-success" value="login" />
		</div>
			 <div class="form-group"><a class=" btn btn-danger btn-sm" href="signup.php">
			SIGNUP<span class="glyphicon glyphicon-send" aria-hidden="true"></span></a></div>
		</form>

<?php if($errorsc == 1): ?>
<div class="alert  alert-danger alert-dismissible" role="alert">
<button class="close" type="button" data-dismiss="alert" aria-label="close"><span aria-hiddin="true">&times;</span></button>
<?php echo $errors; ?>	
</div>

<?php endif;?>

</div>

<?php include('footer.php');?>
