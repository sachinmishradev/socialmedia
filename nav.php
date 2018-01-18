
<nav class="navbar  navbar-fixed-top" style="background-color:#fff;">
  <div class="container">
    <div class="navbar-header">
    <button class="navbar-toggle" data-target="#mynavbar" id="toggle" data-toggle="collapse" type="button">
      <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
    </button>

    <a href="#" class="navbar-brand">Social network</a>
     </div>

     <div id="mynavbar" class="collapse navbar-collapse">
     
      <ul class="nav navbar-nav navbar-left">
      <li><a href="index.php">Home</a></li>
      <li><a href="user.php?name=<?php echo $_SESSION['name']; ?>">Timeline</a></li>
      <li><a href="profile.php">Profile</a></li>
        <li><a href="messages.php">Messages</a></li>
          <li><a href="settings.php">Settings</a></li>
      <li><a href="notifications.php">Notifications</a></li>
    </ul>
    

    <ul class="nav navbar-nav navbar-right">
      <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
     </div>
  </div>
</nav>
