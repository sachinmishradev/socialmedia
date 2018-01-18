<?php 
session_start();
include("../includes/config.php");
if($_REQUEST['action']=='SendFriendRequest')
{
 $sendingTo = $_REQUEST['name']; 
 $userInfo = mysqli_query($connection,"SELECT * FROM members WHERE name='$sendingTo' ");
 $rsuserInfo = mysqli_fetch_array($userInfo);
 $sendingTo = $rsuserInfo['id'];
 $sendingby = $_SESSION['member_id'];
 $Requests  = mysqli_query($connection,"INSERT INTO requests SET id='',sendingto='$sendingTo',sendingfrom='$sendingby',date_added=NOW()");
 $message = $_SESSION['name']."  sent you friend request. 
<input type='button' value='Accept' class='actionBtn accept btn btn-success'  data-type='1' data-user='".$_SESSION['member_id']."' />
<input type='button' value='Reject' class='actionBtn reject btn btn-danger' data-type='2' data-user='".$_SESSION['member_id']."' />
";
 $Notifications  = mysqli_query($connection,"INSERT INTO notifications SET id='',noti_from='".$_SESSION['member_id']."',noti_to='".$sendingTo."',
 	message = '".addslashes($message)."',
 	date_added=NOW()");

 echo  1;


}
else if ($_REQUEST['action'] == 'RequestHandling') {

	if ($_REQUEST['type'] == 1) {
		
	$requestUpdate = mysqli_query($connection,"UPDATE  requests SET accepted='1' WHERE sendingto='".$_SESSION['member_id']."' and  sendingfrom='".$_REQUEST['from']."' ");
	$friends = mysqli_query($connection,"INSERT INTO friends SET id='',user1='".$_SESSION['member_id']."',user2='".$_REQUEST['from']."',date_added=NOW()");
 if ($requestUpdate and $friends) {
 	echo 1;
 }
	} 
	else{
		
	$requestUpdate = mysqli_query($connection,"UPDATE  requests SET accepted='2' WHERE sendingto='".$_SESSION['member_id']."' and  sendingfrom='".$_REQUEST['from']."' ");
	
	 if ($requestUpdate) {
 	echo 2;
      }
	}

}


else if($_REQUEST['action']=='SavePost')
{ $query = "INSERT INTO posts SET id='',user_id='".$_SESSION['member_id']."',post_to='".$_REQUEST['user_id']."',
							status='".$_REQUEST['status']."',date_added=NOW()";
 				 			$posts = mysqli_query($connection,$query);
  echo 1;
}  


else if($_REQUEST['action']=='FetchPosts'){

	if ($_SESSION['member_id']==$_REQUEST['user_id']) {
		$quer = "SELECT * FROM posts where  user_id='".$_SESSION['member_id']."' or  post_to='".$_SESSION['member_id']."' order by id desc";
	
	}
else{
		$quer = "SELECT * FROM posts where  user_id='".$_REQUEST['user_id']."' or  post_to='".$_REQUEST['user_id']."' order by id desc";
	
}
	$posts = mysqli_query($connection,$quer);
	
	$post = '';
	
	while($post = mysqli_fetch_array($posts))
{
	$userInfo = mysqli_query($connection,"select * from members where id='".$post['user_id']."'");
	$rsuserInfo = mysqli_fetch_array($userInfo);




 

        
		
		$commentsno = mysqli_query($connection,"SELECT * FROM comments where  post_id='".$post['id']."' order by id desc");
		$count_comment = mysqli_num_rows($commentsno);
		
		



	$profile = mysqli_query($connection,"select * from profile where user_id='".$post['user_id']."'");
	$rsprofile = mysqli_fetch_array($profile);

if (isset($rsprofile['ppicture']) and  $rsprofile['ppicture'] != '') {
	$img  = '<img src="images/'.$rsprofile['ppicture'].'" height="30px" width="30px"/>';
}
else{

	$img  = '<img src="images/defaultpic.jpg" height="30px" width="30px"/>';

}
	$postingTo = '';
   
   if ($post['post_to'] != 0 and $post['user_id'] != $post['post_to']) {
  	$userToInfo = mysqli_query($connection,"select * from members where id='".$post['post_to']."'");
	$rsuserToInfo = mysqli_fetch_array($userToInfo);
	$postingTo = ' > <a href="user.php?name='.$rsuserToInfo['name'].'">'.$rsuserToInfo['name'].'</a>';

   }
	

	if ($_SESSION['member_id'] == $post['user_id']) {
		$deleteIcon = '<a href="javascript:void(0)" onclick="DeletePost('.$post['id'].')">
					&#x2716

					</a>';
	}
	else{
		$deleteIcon = '';
	}
echo	$post = '<div class="single-message">

				<table width="100%">
				<tr>
					<td width="5%">'.$img.'</td>
					<td width="90%"><b><a href="user.php?name='.$rsuserInfo['name'].'">'.$rsuserInfo['name'].'</a>'.$postingTo.'</b></td>
					<td width="5%">

					'.$deleteIcon.'
					</td>
				

				<tr>
				<tr>
				<td colspan="3" ><br><div style="border-left:3px solid red;text-align:justify;padding-left:10px;">'.$post['status'].'</div></td>
				</tr>
				<tr>
					<td colspan="3" align="right"> <b>Posted on: </b>'.date('d-m-y h:i a',strtotime($post['date_added'])).'</td>
					</tr>

					<tr>
						<td colspan="3" align="right">
						<form class="form-inline"  id="CommentFrm_'.$post['id'].'" method="POST">
						<input type="text"  class="form-control " style="width:100%;" id="s" name="comment_'.$post['id'].'" required/><br/><br/>
						<input type="submit"   value="Submit" />
						
						</form>
						</td>

					</tr>
					<tr>
						<td colspan="3" align="left">

						<a href="javascript:void(0)" id="viewcomment_'.$post['id'].'"  onclick="LoadComment('.$post['id'].')">View comments</a>&nbsp;<span style="background-color:#8e44ad;color:#fff;border-radius:70%;padding:4px;text-align:center;">'

				.$count_comment.	'</span>	</td>
					</tr>

					<tr>
						<td colspan="3" align="left">
						<div id="allcomments_'.$post['id'].'" class="allcomments ">

						<img  src="images/loading.gif" class="a" id="commentsLoading_'.$post['id'].'"/>

						</div>
						</td>

					</tr>
					</table>
				<hr/>
					</div><br><br>
					</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="includes/validate.js"></script>
<script>
	$("#CommentFrm_'.$post['id'].'").validate({

		submitHandler: function(form){
			$.post("handler/actions.php?action=CommentPost&post_id='.$post['id'].'",$("#CommentFrm_'.$post['id'].'").serialize(),
				function showInfo(responseData){

						if(responseData == 1) {
							document.getElementById("CommentFrm_'.$post['id'].'").reset();
						LoadComment('.$post['id'].');
						
						}
						
				});
		}

	});
</script>';

}

}


else if($_REQUEST['action'] == 'CommentPost'){
	$post_id = $_REQUEST['post_id'];
	$comment = "INSERT INTO comments SET id='', user_id='".$_SESSION['member_id']."',post_id='".$post_id."',comment='".$_REQUEST["comment_$post_id"]."',date_added=NOW()";
	mysqli_query($connection,$comment);

	echo 1; 
}

else if($_REQUEST['action'] == 'LoadAllComments' ){

		$comments = mysqli_query($connection,"SELECT * FROM comments where  post_id='".$_REQUEST['post_id']."' order by id desc");
$Strcomments = '';
	while($comment = mysqli_fetch_array($comments))

{


	echo "<div  style='overflow:auto;width:100px;height:auto;max-height:200px;width:700px;float:right;'>";
	$userInfo = mysqli_query($connection,"select * from members where id='".$comment['user_id']."'");
	$rsuserInfo = mysqli_fetch_array($userInfo);



	$profile = mysqli_query($connection,"select * from profile where user_id='".$comment['user_id']."'");
	$rsprofile = mysqli_fetch_array($profile);

		if (isset($rsprofile['ppicture']) and  $rsprofile['ppicture'] != '') {
			$img  = '<img src="images/'.$rsprofile['ppicture'].'" class="img img-circle" height="30px" width="30px"/>';
		}
		else{

			$img  = '<img src="images/defaultpic.jpg" height="30px" class="img img-circle" width="30px"/>';

		}
		  
		 if ($_SESSION['member_id'] == $comment['user_id']) {
			$deleteIcon = '<a href="javascript:void(0)" onclick="DeleteComment('.$comment['id'].','.$comment['post_id'].')">
						&#x2716;</a>';
		}
		else{
			$deleteIcon = '';	
			}



	$Strcomments .= '

					<table width="80%" style="margin-left:6%">
				<tr>

					<td width="8%">'.$img.'</td>
					<td width="92%">
					<a href="user.php?name='.$rsuserInfo['name'].'">'
					.$rsuserInfo['name'].'</a>
					<td width="5%" align="left">
					'.$deleteIcon.'
				</td>

				<tr>
				<td colspan="3" >
				<br><div style="border-left:3px solid #bdc3c7;text-align:justify;padding-left:10px;">'
				.$comment['comment'].
				'</td>
				</div>
				

				</tr>
				<tr>
					<td colspan="2" align="right"> <b>Posted on: </b>'.date('d-m-y h:i a',strtotime($comment['date_added'])).'</td>
					</tr>

					
					</table>
			<hr>
		'
			;
}
echo "</div>";
echo $Strcomments;
exit;
}

elseif ($_REQUEST['action']=='DeletePost') {
	$deletepost = mysqli_query($connection,"DELETE FROM posts where id='".$_REQUEST['post_id']."'");
	if ($deletepost) {
		echo 1;
		exit;
	}
}
elseif ($_REQUEST['action']=='DeletePostComments') {
	$deletepost = mysqli_query($connection,"DELETE FROM comments where post_id='".$_REQUEST['post_id']."'");
	if ($deletepost) {
		echo 1;
		exit;
	}
}
elseif ($_REQUEST['action']=='DeleteAComment') {
	$deleteComment = mysqli_query($connection,"DELETE FROM comments where id='".$_REQUEST['comment_id']."'");
	if ($deleteComment) {
		echo 1;
		exit;
	}
}


elseif ($_REQUEST['action']=='sendMessage') {
	$inboxUsers = mysqli_query($connection,"SELECT * FROM inbox_user WHERE 

		(user1='".$_SESSION['member_id']."' and user2='".$_REQUEST['user_id']."')  

		OR
		(user2='".$_SESSION['member_id']."' and user1='".$_REQUEST['user_id']."') 

		");
	if(mysqli_num_rows($inboxUsers)== 0){

		$insertInbox = mysqli_query($connection,"INSERT INTO inbox_user SET id='',

			user1 = '".$_SESSION['member_id']."', user2 = '".$_REQUEST['user_id']."',date_added=NOW();
			");

	}

$user_id= $_REQUEST['user_id'];
		$message = mysqli_query($connection,"INSERT INTO messages SET id='',

			sendingfrom = '".$_SESSION['member_id']."', sendingto= '".$_REQUEST['user_id']."',message='".$_REQUEST["message_$user_id"]."',date_added=NOW();
			");
	echo 1;
}


elseif($_REQUEST['action'] == 'GetMessages') {
	


			$messages = mysqli_query($connection,"SELECT * FROM messages where (sendingfrom='".$_SESSION['member_id']."' and  sendingto='".$_REQUEST['user_id']."') OR  (sendingto='".$_SESSION['member_id']."' and sendingfrom='".$_REQUEST['user_id']."') ");
			$messageList = '';
					while($message = mysqli_fetch_array($messages))

					{

	$userInfo = mysqli_query($connection,"select * from members where id='".$message['sendingfrom']."'");
	$rsuserInfo = mysqli_fetch_array($userInfo);







	$profile = mysqli_query($connection,"select * from profile where user_id='".$message['sendingfrom']."'");
	$rsprofile = mysqli_fetch_array($profile);

	if (isset($rsprofile['ppicture']) and  $rsprofile['ppicture'] != '') {
		$img  = '<img src="images/'.$rsprofile['ppicture'].'" class="img img-circle" height="30px" width="30px"/>';
	}
	else{

		$img  = '<img src="images/defaultpic.jpg" height="30px" class="img img-circle" width="30px"/>';

	}
						$messageList .= 
					'<table width="80%" style="margin-left:6%">
					<tr>
						<td width="5%">'.$img.'</td>

						<td width="98%">
						<br><br>
						&nbsp;&nbsp;&nbsp;<b>'.$rsuserInfo['name'].'</b><br>
						<div class="comment-message" style="border-left:3px solid #bdc3c7;text-align:justify;padding-left:10px;">'
						.$message['message'].
					'</td>
					</div>
					

					</tr>
					<tr>
						<td colspan="2" align="right">'.date('d-m-y h:i a',strtotime($message['date_added'])).'</td>
						</tr>

						
						</table>
					<hr>

					</div>';	
		}

		echo $messageList;
		exit;
		}
		elseif ($_REQUEST['action'] == 'GetInboxUsers') {
			$inboxUsers = mysqli_query($connection,"SELECT * FROM inbox_user WHERE 

			user1='".$_SESSION['member_id']."' 
			or 
			user2='".$_SESSION['member_id']."'");

			while($result = mysqli_fetch_array($inboxUsers))
			{
				
				if ($result['user1']  != $_SESSION['member_id']) {
					$userName = $result['user1'];
				}

				if ($result['user2']  != $_SESSION['member_id']) {
					$userName = $result['user2'];
				}

					$userInfo = mysqli_query($connection,"select * from members where id='".$userName."'");
					$rsuserInfo = mysqli_fetch_array($userInfo);

			echo '<a style="text-decoration:none;" id="inboxu" href="messages.php?user='.$rsuserInfo['name'].'">'.$rsuserInfo['name'].'</a><br/><hr/>'; 
			}

				
				
		}



	?>


