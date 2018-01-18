<?php   
include('header.php'); 
if(!isset($_SESSION["login"])) header("Location:login.php");
	$errors = '';
$errorsc = '';
$success = '';
$successc = '';

$user_id = $_SESSION['member_id'];

 $query = "SELECT * FROM profile where user_id ='$user_id'";
 $select = mysqli_query($connection,$query);


if (mysqli_num_rows($select) == 1) {
	

	        $result = mysqli_fetch_array($select);
		    $about = mysqli_real_escape_string($connection,$result['about']);
		    $gender = mysqli_real_escape_string($connection,$result['gender']);
		    $dob = mysqli_real_escape_string($connection,$result['dob']);
		    $education1 = mysqli_real_escape_string($connection,$result['edu1']);
		    $education2 = mysqli_real_escape_string($connection,$result['edu2']);
		    $education3 = mysqli_real_escape_string($connection,$result['edu3']);
		    $country = mysqli_real_escape_string($connection,$result['country']);
		    $ppicture = mysqli_real_escape_string($connection,$result['ppicture']);	






		    	if(isset($_REQUEST['SaveBtn'])){
   
 						


			
		   			 if (!empty($_REQUEST['about']) and !empty($_REQUEST['gender']) and !empty($_REQUEST['dob']) and !empty($_REQUEST['Education1']) and !empty($_REQUEST['country'])) {
						    
						$filename = $_FILES['ppicture']['name'];
						$tmpname = $_FILES['ppicture']['tmp_name'];
						$filename = uniqid().$filename;


					$move = 	move_uploaded_file($tmpname,"images/".$filename);
		   			 			




								$education2 = '';
								$education3 = '';
								$about = $_REQUEST['about'];
							    $gender = $_REQUEST['gender'];
							    $dob = $_REQUEST['dob'];
							    $education1 = $_REQUEST['Education1'];
							    $education2 = $_REQUEST['Education2'];
							    $education3 = $_REQUEST['Education3'];
							    $country = $_REQUEST['country'];
		    	    
								$update = "UPDATE  profile SET 


									
									about = '$about',
									gender = '$gender',
									dob = '$dob',
									ppicture = '$filename',
									edu1 = '$education1',
									edu2 = '$education2',
									edu3 = '$education3',
									country = '$country' 
									WHERE user_id = '$user_id'

						";
						mysqli_query($connection,$update);
						$success .= "Updated";

						$successc = 1;
						echo " <meta http-equiv='refresh' content='1' >";
						
						


						}


						else
						{	$errors .= "Plz fill any one of the field";
							$errorsc = 1;
							
						}
					
}	    
}                                               

else
{
 	if(isset($_REQUEST['SaveBtn'])){
   
 
			$education2 = '';
			$education3 = '';
			$about = $_REQUEST['about'];
		    $gender = $_REQUEST['gender'];
		    $dob = $_REQUEST['dob'];
		    $education1 = $_REQUEST['Education1'];
		    $education2 = $_REQUEST['Education2'];
		    $education3 = $_REQUEST['Education3'];
		    $country = $_REQUEST['country'];
		    
		    if (!empty($about) and !empty($gender) and !empty($dob) and !empty($education1) and !empty($country)) {
						    
						    $filename = $_FILES['ppicture']['name'];
							$tmpname = $_FILES['ppicture']['tmp_name'];

							if (empty($filename)) {
								$filename = "defaultpic.jpg";
								$move = 	move_uploaded_file($tmpname,"images/".$filename);
							}
							

						else {
							$filename = uniqid().$filename;
							$move = 	move_uploaded_file($tmpname,"images/".$filename);
		   			 		}	

							$insert = "INSERT INTO profile SET 


									id = '',
									user_id = '$user_id',
									about = '$about',
									gender = '$gender',
									dob = '$dob',
									ppicture = '$filename',
									edu1 = '$education1',
									edu2 = '$education2',
									edu3 = '$education3',
									country = '$country',
									date_added = NOW()
									

						";
						mysqli_query($connection,$insert);
						$success .= "Saved";
						$successc = 1;
						echo "<meta http-equiv='refresh' content='1' >";


						}


						else
						{	$errors .= "Plz fill any one of the field";
							$errorsc = 1;
							
						}
					
}

}





		


	$countries = mysqli_query($connection,"SELECT * FROM  countries");
			$options= '';

				while($rs = mysqli_fetch_array($countries)) {
					
						
					
					
						@$options .= "<option value='".$rs['id']."' ".(($country == $rs['id'])?'selected':'').">".$rs['country_name']."</option>";
					
					
 }

?>


<?php  include("nav.php"); ?>



 
<div class="container col col-sm-6  col-sm-push-3  col-xs-10  col-xs-push-1" id="proform"  >
	
		 
		<form action="profile.php" class="form-group" method="post" name="form" enctype="multipart/form-data">
		
			 <div class="container-fluid  text-center">
		<div class="form-group text-center ">
		<?php if(!isset($ppicture)){?><img src="images/defaultpic.jpg" class="img img-responsive img-thumbnail" height="250px" width="200px" alt="user image" /><br>
			<?php } ?>
			<img src="<?=((empty($filename))?'images/'.$ppicture:'images/defaultpic.jpg')?>" class="img img-responsive img-thumbnail" height="250px" width="200px"  />

		</div>
		<b>	<?php   echo $_SESSION['name'];?></b>	
		</div>


		<div class="container-fluid"  >
		<div class="form-group text-center ">
		<input type="file" name="ppicture" class="form-control"  placeholder="Browse picture" >
		</div>

		
		<label for="sel1">About </label>
		<div class="form-group">
		<TEXTAREA type="file" style="height:100px" name="about" class="form-control" ><?=((isset($about)?$about:'')) ?></TEXTAREA> 
		</div>


		<div class="form-group ">
		<input type="radio"  class="radiobutton" name="gender" class="form-control" value="M" <?=((isset($gender)  and $gender == 'M')?'checked':'')?> >
Male
		<input type="radio" class="radiobutton" name="gender" class="form-control" value="F" <?=((isset($gender)  and $gender == 'F')?'checked':'')?>>
Female
		</div>
		

		<div class="form-group ">
		Date of birth
		<input type="date"class="date" name="dob" class="form-control" value="<?=(( isset($dob)?$dob:'')) ?>" />
		</div>
<label for="sel1">Education</label>
		<div class="form-group ">
		
		
		<input type="text" name="Education1" class="form-control" placeholder="Education1" value="<?=(( isset($education1)?$education1:'')) ?>" />
</div>
<div  class="form-group ">
		<input type="text" name="Education2" class="form-control" placeholder="Education2"  value="<?=(( isset($education2)?$education2:'')) ?>" />
</div>
	
	<div>
		<input type="text" name="Education3" class="form-control" placeholder="Education3" value="<?=(( isset($education3)?$education3:'')) ?>"  />
		</div>
	<div class="form-group">
      <label for="sel1" >Select list:</label>
      <select class="form-control" id="sel1"  name="country">
      <?php
echo $options;

?>
  	  </select>
</div
		
		</div>

		<div class="form-group ">

		 <div class="form-group ">
		 <input type="submit" value="save" class="form-control" class="btn btn-primary " style="background-color:#e74c3c;color:#fff;" name="SaveBtn" >
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

<?php include('footer.php');?>






