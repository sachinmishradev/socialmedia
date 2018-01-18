<?php  include('header.php');
	$error = '';
	$errorc = '';
	$successc = '';
	$success = '';
	$access = '';
	$accessc = '';
if (isset($_REQUEST['submit'])) 
{
	
	
$name = mysqli_real_escape_string($connection,$_REQUEST['name']);
$email = mysqli_real_escape_string($connection,$_REQUEST['email']);
$password = mysqli_real_escape_string($connection,$_REQUEST['password']);

$select  = mysqli_query($connection,"SELECT * FROM members WHERE email='$email'");
       

    if(mysqli_num_rows($select)>=1){

            $access = 'Sorry This mail already exists. please try another'; 
            $accessc = 1;
                                   }


    else {



		if (empty($name) || empty($email) || 	 empty($password)) 
			{
			$errorc = 1;
			$error = "plz fill out all fields";
			}
		else{
			$token = md5($name);
			$query = "INSERT INTO members SET id='',name='$name',email='$email',password='$password',token='$token',date_added=NOW()";
			
			$to = $email;
			$subject = "verification Email";
			$message = "please click on the below link in order to activate your account ";
			$message .= '<a href="http://sachinmishra.000webhostapp.com/social/activate.php?token='.$token.'">Click to activate</a>';

			$headers = "Form : sachinmishra199747@gmail.com\n";
			$headers .= "MIME-Version : 1.0\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1\n";

			mail($to, $subject, $message,$headers);

			if (mysqli_query($connection,$query)) {

					$user_id = mysqli_insert_id($connection);
					$settings = "INSERT INTO settings SET 


									id = '',
									user_id = '$user_id',
									postwall = '1',
									seeposts = '1',
									seeprofile = '1',
									sendmessage = '1',
									date_added = NOW()
									

						";
						mysqli_query($connection,$settings);



			$success = "you have regestered successfully";
			$successc = 1;
										echo "<META http-equiv='refresh' content='0;index.php'>";
												  }
			}

			$email = '';
			$name = '';
			$password = '';


    	 }

}



?>






<div class="container"> 
<div class="col col-sm-5  col-xs-10  col-sm-push-3 col-xs-push-2 " style="margin-top:20%;" id="form">
<div >
	<h2><span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span>signup</h2>
</div>
	<form  action="signup.php" class="form-group" name="form" method="post" enctype="multipart/form-data">
			<div class="form-group" > <input  class="form-control"type="text" value="<?=((isset($name))?$name:'')?>" name="name" placeholder="name" class="fields"></div>
			   <div class="form-group"> <input class="form-control"type="email" value="<?=((isset($email))?$email:'')?>" name="email" placeholder="Email" class="fields"></div>
			 	<div class="form-group"><input class="form-control"type="password"   name="password" placeholder="Password" class="fields"></div>
			 	<div class="form-group"><input class="form-control btn btn-primary" type="submit"    name="submit" value="signup" class="fields"></div>
			 <div class="form-group"><a class=" btn btn-success btn-sm" href="login.php">LOGIN <span class="glyphicon glyphicon-send" aria-hidden="true"></span></a></div>
<?php if($successc == 1 || $errorc == 1): ?>
<div class="alert  alert-success alert-dismissible" role="alert">
<button class="close" type="button" data-dismiss="alert" aria-label="close"><span aria-hiddin="true">&times;</span></button>
<?php echo $error; echo $success; ?>	
</div>

<?php elseif($accessc == 1): ?>
<div class="alert  alert-danger alert-dismissible" role="alert">
<button class="close" type="button" data-dismiss="alert" aria-label="close"><span aria-hiddin="true">&times;</span></button>
<?php echo $access; ?>	
</div>

<?php endif;?>


	</form>
</div>

</div>

<?php  include('footer.php');   ?>
