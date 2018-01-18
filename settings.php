<?php   
include('header.php'); 
if(!isset($_SESSION["login"])) header("Location:login.php");
	$errors = '';$errorsc = '';$success = '';$successc = '';

$user_id = $_SESSION['member_id'];


$sett = mysqli_query($connection,"SELECT * FROM settings WHERE user_id='$user_id'");
$rsSettingsData = mysqli_fetch_array($sett);
echo "<br><br><br><br>";
if(isset($_REQUEST['SaveSettingsBtn'])){
 
		    $s1 = $_REQUEST['wallposts'];
		    $s2 = $_REQUEST['seeposts'];
		    $s3 = $_REQUEST['seeprofile'];
		    $s4 = $_REQUEST['sendmessage'];
		 
					   	
	

							$update = "UPDATE  settings SET 


									postwall = '$s1',
									seeposts = '$s2',
									seeprofile = '$s3',
									sendmessage = '$s4',
									date_added = NOW()
									
									WHERE user_id = '".$user_id."'
						";
						mysqli_query($connection,$update);
						$success .= "Saved";
						$successc = 1;
						echo "<meta http-equiv='refresh' content='1'>";


			}





		

?>

<?php  include("nav.php"); ?>



 
<div class="container col col-sm-6  col-sm-push-3  col-xs-10  col-xs-push-1" id="proform"  >
	
		 
		<form action="settings.php" class="form-group" method="post">

		<div class="form-group ">
        <label for="wallposts">Who can post on my wall</label><br>
        <select name="wallposts" class="form-control">

        	<option value="1" <?=(($rsSettingsData['postwall']==1)?'selected':'')?>>Public</option>
        	<option value="2" <?=(($rsSettingsData['postwall']==2)?'selected':'')?>>Friends</option>
        </select>
        </div>
        <div class="form-group ">

        <label for="seeprofile">Who can see  my posts</label><br>
        <select name="seeposts" class="form-control">
        	<option value="1" <?=(($rsSettingsData['seeposts']==1)?'selected':'')?>>Public</option>
        	<option value="2" <?=(($rsSettingsData['seeposts']==2)?'selected':'')?>>Friends</option>
        </select>
        </div>
        <div class="form-group ">

        <label for="seeprofile">Who can see my profile details</label><br>
        <select name="seeprofile" class="form-control">
        	<option value="1" <?=(($rsSettingsData['seeprofile']==1)?'selected':'')?>>Public</option>
        	<option value="2" <?=(($rsSettingsData['seeprofile']==2)?'selected':'')?>>Friends</option>
        </select>
        </div>
        <div class="form-group ">

        <label for="sendmessage">Who can send me private message</label><br>
        <select name="sendmessage" class="form-control">
        	<option value="1" <?=(($rsSettingsData['sendmessage']==1)?'selected':'')?>>Public</option>
        	<option value="2" <?=(($rsSettingsData['sendmessage']==2)?'selected':'')?>>Friends</option>
        </select>
        </div>
		 <div class="form-group ">
		 <input type="submit" value="save" class="form-control" class="btn btn-primary " style="background-color:#34495e;color:#fff;" name="SaveSettingsBtn" >
		 </div>
		</form>
		<?php if($errorsc == 1): ?>
<div class="alert  alert-success alert-dismissible" role="alert">
<button class="close" type="button" data-dismiss="alert" aria-label="close"><span aria-hiddin="true">&times;</span></button>
<?php echo $errors; ?>	
</div>
<?php elseif($successc == 1): ?>
<div class="alert  alert-danger alert-dismissible" role="alert">
<button class="close" type="button" data-dismiss="alert" aria-label="close"><span aria-hiddin="true">&times;</span></button>
<?php echo $success; ?>	
</div>
<?php endif;?>
</div>

</div>




<?php include('footer.php');?>






