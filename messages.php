<?php include('header.php');if(!isset($_SESSION["login"])) header("Location:login.php");?>
<?php
	
if (isset($_REQUEST['user']) and $_REQUEST['user'] != '') {

			$name = $_REQUEST['user'];
			$userInfo = mysqli_query($connection,"SELECT * FROM members where name='$name'");
			$rsuserInfo = mysqli_fetch_array($userInfo);

		}

	
 ?>
<?php include("nav.php"); ?>

<br/><br/><br/><br/><br/><br/><div class="container" id="con">
<div class="allusers col col-sm-4 col-sm-12">
	<h1>make some friends</h1>
	<div id="alluser">
		
	</div>
</div>

<div class="messages col col-sm-push-1 col-sm-7 col-sm-12">

	<div id="message">
		
	</div>
	


  <?php if (isset($_REQUEST['user']) and $_REQUEST['user'] != '') { ?>
       <div class="text-center">
		<form id="MessageFrm_<?=$rsuserInfo['id']?>" class="form-inline" method="POST">
		 <div class="input-group">
			<input  type="text" size="70" style="padding:20px" name="message_<?=$rsuserInfo['id']?>" class="form-control required">
		<div class="input-group-btn">
			<input type="submit" value="send" style="padding:10px" class="btn btn-danger"  size="50" />
		</div>
		</div>
		</form>
		</div>
		
<?php } ?> 

</div>
</div> 

<script>
	LoadInboxUsers();
	<?php if (isset($_REQUEST['user']) and $_REQUEST['user'] != '') { ?>
				$("#MessageFrm_<?=$rsuserInfo['id']?>").validate({
					submitHandler: function(form){
						$.post('handler/actions.php?action=sendMessage&user_id=<?=$rsuserInfo['id']?>',$('#MessageFrm_<?=$rsuserInfo['id']?>').serialize(),function showInfo(responseData){
							if (responseData == 1) {

								document.getElementById("MessageFrm_<?=$rsuserInfo['id']?>").reset();
								/*LoadMessages(<?=$rsuserInfo['id']?>);*/
								LoadInboxUsers();
			}
						});
					}
				});

	<?php } ?>
/*
function LoadMessages(userid){
	
			$.post('handler/actions.php?action=GetMessages&user_id='+userid,function showInfo(responseData){
				$('#message').html(responseData);
				
			document.getElementById('message').scrollTop = document.getElementById('message').scrollHeight;

});
	}
	*/
    <?php if (isset($_REQUEST['user']) and $_REQUEST['user'] != '') { ?>
			/*LoadMessages(<?=$rsuserInfo['id']?>);*/
	
    setInterval(function(){

			$.post('handler/actions.php?action=GetMessages&user_id='+<?=$rsuserInfo['id']?>,function showInfo(responseData){
				$('#message').html(responseData);
				
			document.getElementById('message').scrollTop = document.getElementById('message').scrollHeight;

});
    	},500,<?=$rsuserInfo['id']?>);

<?php  } ?>







function LoadInboxUsers(){

			$.post('handler/actions.php?action=GetInboxUsers',function(responseData){
				$('#alluser').html(responseData);
					
});
	}

</script>

<?php include('footer.php'); ?>