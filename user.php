<?php include('header.php'); if(!isset($_SESSION["login"])) header("Location:login.php");?>
<?php include("nav.php"); ?>
<?php 
	$name = mysqli_real_escape_string($connection,$_REQUEST['name']);
	$userInfo = mysqli_query($connection,"SELECT * FROM members where name='$name'");
	$rsuserInfo = mysqli_fetch_array($userInfo);
	$w = mysqli_num_rows($userInfo);
	if ($w <= 0) 
	{
	echo '<br><br><br><br><div class="alert  alert-danger alert-dismissible" role="alert">
	<button class="close" type="button" data-dismiss="alert" aria-label="close"><span aria-hiddin="true">&times;</span></button>
	There is no user of this name!
	</div>';
	}
	else
	{

	$userPInfo = mysqli_query($connection,"SELECT * FROM profile where user_id='".$rsuserInfo['id']."'");
	 $rsuserPInfo = mysqli_fetch_array($userPInfo);




	 $userSettings = mysqli_query($connection,"SELECT * FROM settings where user_id='".$rsuserInfo['id']."'");
	 $rsuserSettings= mysqli_fetch_array($userSettings);




	 $friends =  mysqli_query($connection,"SELECT * FROM friends where user1='".$rsuserInfo['id']."' or user2='".$rsuserInfo['id']."'");
	 $friendsArray =array();
	 while ($results = mysqli_fetch_array($friends)) {
	 	if($results['user1'] == $rsuserInfo['id']){
	 		array_push($friendsArray,$results['user2']);
	 	}
	 	if($results['user2'] == $rsuserInfo['id']){
	 		array_push($friendsArray,$results['user1']);
	 	}

	 }
	 if (in_array($_SESSION['member_id'], $friendsArray)) {
	 		$friend = 1;
	 }
	 else
	 {
	 	$friend = 0;
	 }
?>


<h2>Timeline</h2>
<div class="container" id="userdetailtop" style="padding-top:60px; ">
	<div class="row">
		<div class="col col-sm-4" style="background-color:#fff;"><div style="" id="pp">
		<?php 

		if (empty($rsuserPInfo["ppicture"])) { ?>
			
<h4><img src="images/defaultpic.jpg" class="img img-responsive img-thumbnail" height="300px" width="200px" style=""></h4>

			<?php
		}
		else{
			?>
<h4><img src="images/<?php echo $rsuserPInfo["ppicture"]; ?>" class="img img-responsive img-thumbnail" height="300px" width="200px" style=""></h4>

			<?php
		}

		?>
</div>
<div>

<div>

<h4> <label > Name :   </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;<?php  echo   $rsuserInfo['name']; ?></h4>
</div>

<?php 
$canseemyprofile = '';
if ($rsuserSettings['seeprofile'] == 2) {
	if ($friend) {
		$canseemyprofile = 1;
	}
}
elseif ($rsuserSettings['seeprofile'] == 1) {
		$canseemyprofile = 1;
}
if ($_SESSION['member_id'] == $rsuserInfo['id']) {
	$canseemyprofile = 1;
}



 if($canseemyprofile == 1){?>
<div>
	<h4> <label > Email :   </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<?php  echo $rsuserInfo['email']; ?></h4>
</div>
<div>

<?php 
		$count = mysqli_query($connection,"SELECT * FROM countries where id='".$rsuserPInfo['country']."'");
		$countInfo = mysqli_fetch_array($count);
?>

<h4> <label > Country : </label>	&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $countInfo['country_name']; ?></h4>
</div>
<div>
	<h4> <label > Gender : </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<?php  echo $rsuserPInfo['gender']; ?></h4>
</div>
<div>
<h4>	<label > About : </label> </h4> <p id="about">&nbsp;&nbsp;&nbsp;&nbsp;	*<?php  echo $rsuserPInfo['about']; ?></p>
</div>
<div>
	<h4><label > D.O.B : </label>&nbsp;&nbsp;&nbsp;&nbsp;	 <?php  echo $rsuserPInfo['dob']; ?></h4>
</div>
<?php  }  else {?>


<h1> make friend
<p>no profile to show</p></h1>

<?php }?>

<div>
<?php 
$requested = mysqli_query($connection,"SELECT * FROM requests WHERE (sendingto = '".$rsuserInfo['id']."'  and  sendingfrom='".$_SESSION['member_id']."' and accepted = '1')  OR 
	(sendingto='".$_SESSION['member_id']."'  and  sendingfrom='".$rsuserInfo['id']."' and accepted = '1')  OR (sendingto='".$_SESSION['member_id']."'  and  sendingfrom='".$rsuserInfo['id']."') ");
/*
echo mysqli_num_rows($requested);
echo 'sendingto'.$rsuserInfo['id'];
echo 'sendingto'.$_SESSION['member_id'];
*/
if (mysqli_num_rows($requested)>=1)  {
	 echo "You are now Friends";
}
else
{
			if($_SESSION['member_id']!=$rsuserInfo['id'] and mysqli_num_rows($requested)== 0){
		?>
		<div>
			<input type="button" name="" value="SEND FRIEND REQUEST" id="requestBtn" class="btn btn-warning form-control" onclick="SendAction(1,'<?=$name?>')" />
			
		</div><br>
		
<?php

}}

?>
</div>
<h1>
	
	<?php 

	$sendmess = mysqli_query($connection,"SELECT * FROM members where id='".$_SESSION['member_id']."'");
	$sendmessage = mysqli_fetch_array($sendmess);
	/*echo $sendmessage['name'];
	echo $_REQUEST['name'];*/
	if($_REQUEST['name'] != $sendmessage['name']){?>

<?php 

$cansendmessage = '';
if ($rsuserSettings['sendmessage'] == 2) {
	if ($friend) {
		$cansendmessage = 1;
	}
}
elseif ($rsuserSettings['sendmessage'] == 1) {
		$cansendmessage = 1;
}
if ($_SESSION['member_id'] == $rsuserInfo['id']) {
	$cansendmessage = 1;
}






if($cansendmessage == 1){  ?>



			<input type="button" name="" value="SEND PRIVATE MESSAGE" id="requestBtn" class="btn btn-warning form-control" onclick="SendMessageButton('<?=$name?>')" />



<?php
	}	}
?>

</h1>
</div>

	

	</div>
		<div class="col col-sm-8" >
		<?php if ($rsuserSettings['postwall'] == 2) {
			if ($friend == 1) {
				?>

		<form id="statusFrm"  method="post"  action="">
	    <div class="form-group">
        <textarea class="required form-control" rows="5" name="status" id="comment"></textarea>
        </div>
        <div class="form-group">
        <input type="submit" value="Send Post" class="btn btn-primary   form-control" />
        </div>
		</form>
				<?php
			}
		}

		elseif ($rsuserSettings['postwall'] == 1) { ?>
		 <form id="statusFrm"  method="post"  action="">
	    <div class="form-group">
        <textarea class="required form-control" rows="5" name="status" id="comment"></textarea>
        </div>
        <div class="form-group">
        <input type="submit" value="Send Post" class="btn btn-primary   form-control" />
        </div>
		</form>
	    <?php	 }




	    if($_SESSION['member_id'] == $rsuserInfo['id']) { 	
	   $rsuserSettings['postwall'] = 2;
	     } ?>
			

				<?php if ($rsuserSettings['seeposts'] == 2) {
						if ($friend == 1) { ?>
							<div id="allPosts">
			              Loading...
		                  </div>
					<?php 	} }
				elseif ($rsuserSettings['seeposts'] == 1) { ?>
					<div id="allPosts">
			Loading...
		</div>
			<?php 	}

			if($_SESSION['member_id'] == $rsuserInfo['id']) { ?>
				<div id="allPosts">
		
		</div>	
	<?php	}?>
		
		
		</div>
		</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="includes/validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
LoadPosts();
});
	function SendAction(Action,name){
		$.post('handler/actions.php?action=SendFriendRequest&name='+name,function(response){
		
			
			response;
			if(response == 1)
			{
				$('#requestBtn').hide();
				$('#requestBtn').parent().html("FRIEND REQUEST SENT");
				a = '';
			}

		}); 
	}

	$('#statusFrm').validate({

		submitHandler: function(form){
			$.post('handler/actions.php?action=SavePost&user_id='+<?=$rsuserInfo['id']?>,$('#statusFrm').serialize(),
				function showInfo(responseData){
					if (responseData == 1) {
						document.getElementById('statusFrm').reset();

						LoadPosts();

					}
 
				});
		}

	});


	function LoadPosts(){
		$.post('handler/actions.php?action=FetchPosts&user_id='+<?=$rsuserInfo['id']?>,function(responseData){
				
				$('#allPosts').html(responseData);
				});
 
	}


	function LoadComment(postid){
		$('#commentsLoading_'+postid).show();
		$.post('handler/actions.php?action=LoadAllComments&post_id='+postid,function(responseData){
			$('#allcomments_'+postid).html(responseData);
			$('#commentsLoading_'+postid).hide();
			$('#viewcomment_'+postid).hide();


	});
		
}




function DeletePost(postid){

		$.post('handler/actions.php?action=DeletePost&post_id='+postid,function(responseData){
			
			if(responseData ==1) {
				LoadPosts();
				DeleteComments(postid);
			}
});
		
}

function DeleteComments(postid){
		$.post('handler/actions.php?action=DeletePostComments&post_id='+postid);
}


function DeleteComment(commentid,postid)
{
		$.post('handler/actions.php?action=DeleteAComment&comment_id='+commentid,function(responseData){
			
			if(responseData ==1) {
				//alert(responseData);
				
				LoadComment(postid);

				location.assign("user.php");

				
			}
});
}


function SendMessageButton(username){
window.location = 'messages.php?user='+username;
}

</script>



<?php  }
 ?>

 <?php include('footer.php');	 ?>

