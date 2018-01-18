<?php include('header.php');if(!isset($_SESSION["login"])) header("Location:login.php");?>
<?php include("nav.php"); ?>
<br><br><br><br><br><br>
<div class="container" style="background-color:#ed3;padding-top:2%;">
<div class="row text-center">
<?php  

$memberQuery = mysqli_query($connection,"SELECT * FROM members WHERE id != '".$_SESSION['member_id']."' and activated = '1'");


while ($member = mysqli_fetch_array($memberQuery)) {
	
$profileQuery = mysqli_query($connection,"SELECT * FROM profile WHERE  user_id='".$member['id']."'");
$profile = mysqli_fetch_array($profileQuery);

$countryQuery = mysqli_query($connection,"SELECT * FROM countries WHERE  id='".$profile['country']."'");
$country = mysqli_fetch_array($countryQuery);
	$propicture = '<img src="images/defaultpic.jpg" height="200px" alt="...">';

?>



<div class="col-xs-6 col-md-3" style="color:#fff;">
 <a href="user.php?name=<?php echo $member['name']?>" class="thumbnail">
<?php if (!empty($profile['ppicture'])) { ?>
      <img src="images/<?php echo $profile['ppicture'];  ?> " height="200px" alt="...">

  <?php } 
  else { 
echo $propicture;

  }

echo "<br>".$member['name']." From ".$country['country_name']."<br>";  
?>

     </a>
</div>

<?php } ?>
</div>
</div>





<?php include('footer.php'); ?>

  
