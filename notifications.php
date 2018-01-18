<?php include('header.php');if(!isset($_SESSION["login"])) header("Location:login.php");?>
<?php include("nav.php"); ?>


<div class="container">


				<div  class="col col-sm-5 col-xs-12" id="not">
<?php 

$user_id  = $_SESSION['member_id'];
$notifications = mysqli_query($connection,"SELECT * FROM notifications WHERE noti_to='$user_id'");
while($results = mysqli_fetch_array($notifications)){
			$friends = mysqli_query($connection,"SELECT * FROM friends WHERE user1='".$results['noti_from']."' and  user2='".$results['noti_to']."' 
       
OR      user1='".$results['noti_to']."' and  user2='".$results['noti_from']."'
				");
			 mysqli_num_rows($friends);
			if(mysqli_num_rows($friends) < 1 ) { ?>
				<div id="noti"><br>
				
				<?=$results['message']?> ----
				<?=$results['date_added']?>
				
				<hr>
				</div>
			<?php }
				?>
				
				<?php 
		}
		  ?>
		  </div>
<div class="friendslist col col-sm-7 col-xs-12 " id="friendlist">
<br><br><br><br><h1>friend list</h1>
<?php

	$friends = mysqli_query($connection,"SELECT * FROM friends WHERE user1='".$_SESSION['member_id']."' or  user2='".$_SESSION['member_id']."'");

$totalFriends = mysqli_num_rows($friends);
while ($results = mysqli_fetch_array($friends)) {
	?>
<div ><br>
				
				
				<?php 

					if ($results['user1'] != $_SESSION['member_id']) {
						$userInfo = mysqli_query($connection,"SELECT name FROM members WHERE id='".$results['user1']."'") ;
						$rsuserInfo = mysqli_fetch_array($userInfo);
						

						$userInfo1 = mysqli_query($connection,"SELECT ppicture FROM profile WHERE user_id='".$results['user1']."'") ;
						$rsuserInfo1 = mysqli_fetch_array($userInfo1);
						if ($rsuserInfo1['ppicture'] == '') {
						echo "<img src='images/defaultpic.jpg' class='img img-responsive img-thumbnail' width='100px' height='60px'><br>";	
						}
						echo "<img src='images/".$rsuserInfo1['ppicture']."' class='img img-responsive img-thumbnail' width='100px' height='60px'><br>";		
						echo $rsuserInfo['name'];				
					}

					if ($results['user2'] != $_SESSION['member_id']) {
						$userInfo = mysqli_query($connection,"SELECT name FROM members WHERE id='".$results['user2']."'") ;
						$rsuserInfo = mysqli_fetch_array($userInfo);
						

						$userInfo1 = mysqli_query($connection,"SELECT ppicture FROM profile WHERE user_id='".$results['user2']."'") ;
						$rsuserInfo1 = mysqli_fetch_array($userInfo1);
						if(!empty($rsuserInfo1['ppicture'])){
							$img = " <img src='images/".$rsuserInfo1['ppicture']."' class='img img-responsive img-thumbnail
						' width='100px' height='60px'  ><br>";

						}

						else{
								$img = " <img src='images/defaultpic.jpg' class='img img-responsive img-thumbnail
						' width='100px' height='60px'  ><br>";
						}
						
							echo $img;					
						echo "<b>".$rsuserInfo['name']."</b>";
					}
					
			echo   " <br> (".date("d-m-y h:i a",strtotime($results['date_added'])).")"; ?> 
				<hr>
				</div>
	<?php 
}

						
?>

</div>
<?php include('footer.php'); ?>

		<script type="text/javascript">
			/*
		function ActionRequest(type,from){
			
		}*/

		$('.actionBtn').click(function(){
			CurrentBtn =  $(this);
			var  type  =  CurrentBtn.attr('data-type');

			var  user  =  CurrentBtn.attr('data-user');
		//	alert(type+ "" +user);
			$.post('handler/actions.php?action=RequestHandling&type='+type+'&from='+user,function(response){
				
				var  l = '';
				if(response == 1){
					CurrentBtn.parent().html("<meta http-equiv='refresh' content='2'><h1>you guys are now friends</h1>");

				}	
				if(response == 2){

					CurrentBtn.parent().html("<meta http-equiv='refresh' content='2'><h1>you are reject the friend request</h1>");
					
				}
			});
		});

		</script>


<?php
		include('footer.php');
	

?></div>

</div>
