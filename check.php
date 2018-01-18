		<!DOCTYPE html>
		<html>
		<head>
			<title></title>
		</head>
		<body>
		<form id="statusFrm" method="post"  action="">
	    <div class="form-group">
        <textarea class="required form-control" rows="5" id="comment"></textarea>
        </div>
        <div class="form-group">
        <input type="submit" value="Send Post" class="btn btn-primary   form-control" />
        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript" src="includes/validate.js"></script>
		<script type="text/javascript"> 
		$('#statusFrm').validate();
		</script>
		</form>
		</body>
		</html>