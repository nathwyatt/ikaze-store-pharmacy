<?php
session_start();

if(!isset($_SESSION['userId']))
{
  header('location:login.php');
}
 ?>
<?php require "assets/function.php" ?>
<?php require 'assets/db.php';?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo siteTitle(); ?></title>
  <?php require "assets/autoloader.php" ?>
  <style type="text/css">
  <?php include 'css/customStyle.css'; ?>

  </style>
 <?php 
 $notice="";
if (isset($_POST['saveSetting'])) {
if ($con->query("update users SET email='$_POST[email]',password='$_POST[password]' where id='$_SESSION[userId]'")) {

  $notice ="<div class='alert alert-success'>Successfully Saved</div>";
  header("location:accountSetting.php?notice=Successfully saved");
}
else{
  $notice ="<div class='alert alert-danger'>Error is:".$con->error."</div>";
}

}
if (isset($_GET['notice'])) {
  $notice = "<div class='alert alert-success'>Successfully Saved</div>";
}
 ?>
</head>
<body style="background: linear-gradient(135deg, #71b7e6, #9b59b6);padding:0;margin:0">
<div class="dashboard" style="position: fixed;width: 18%;height: 100%;background:linear-gradient(135deg, #71b7e6, #9b59b6)">
 
 <center> <div class="flex" style="padding: 3px 7px;margin:5px 2px;">
  
    <div style="color:lightgreen;font-size: 13pt;padding: 14px 7px;margin-left: 11px;"><?php echo ucfirst($user['name']); ?></div>
  </div></center>
  <div style="background: linear-gradient(135deg, #71b7e6, #9b59b6);font-size: 10pt;padding: 11px;color: white">MAIN NAVIGATION</div>
  <div>
    <div style="background:linear-gradient(135deg, #71b7e6, #9b59b6);color: white;padding: 13px 17px;border-left: 3px solid #3C8DBC;"><span></i> Dashboard</span></div>
    <div class="item">
      <ul class="nostyle zero">
        <a href="index.php"><li style="color: white"></i> Home</li></a>
        <a href="inventeries.php"><li></i> checklist</li></a>
       <a href="addnew.php"><li></i> insert new product</li></a>
<!--         <a href="newsell"><li><i class="fa fa-circle-o fa-fw"></i> New Sell</li></a> -->
        <a href="reports.php"><li></i> Report</li></a>
      </ul><
    </div>
  </div>
  <div style="background:linear-gradient(135deg, #71b7e6, #9b59b6);color: white;padding: 13px 17px;border-left: 3px solid #3C8DBC;"><span></i> SETTINGS</span></div>
  <div class="item">
      <ul class="nostyle zero">
        <a href="sitesetting.php"><li></i> page</li></a>
       <a href="profile.php"><li></i> Profile </li></a>
        <a href="accountSetting.php"><li></i> Account </li></a>
        <a href="logout.php"><li></i> Sign Out</li></a>
      </ul><
    </div>
</div>
<div class="marginLeft" >
  <div style="color:white;background:#3C8DBC" >
    <div class="pull-right flex rightAccount" style="padding-right: 11px;padding: 7px;">
     
      <div style="padding: 8px"><center><?php echo ucfirst($user['name']) ?></center></div>
    </div>
    <div class="clear"></div>
  </div>
<div class="account" style="display: none;">
  <div style="background: #3C8DBC;padding: 22px;" class="center">
    <img src="photo/<?php echo $user['pic'] ?>" style='width: 100px;height: 100px; margin:auto;' class='img-circle img-thumbnail'>
    <br><br>
    <span style="font-size: 13pt;color:#CEE6F0"><?php echo $user['name'] ?></span><br>
    <span style="color: #CEE6F0;font-size: 10pt">Member Since:<?php echo $user['date']; ?></span>
  </div>
  <div style="padding: 11px;">
    <a href="profile.php"><button class="btn btn-default" style="border-radius:0">Profile</button>
    <a href="logout.php"><button class="btn btn-default pull-right" style="border-radius: 0">Sign Out</button></a>
  </div>
</div>

  <div class="content2">
<ol class="breadcrumb ">
        <li><a href="index.php"></i> Dashboard</a></li>
        <li >Account Setting</li>
    </ol>
    <?php echo $notice ?>
    <div style="width: 55%;margin: auto;padding: 22px;" class="well well-sm center">

      <h4>Login Setting</h4><hr>
      <form method="POST">
         <div class="form-group">
            <label for="some" class="col-form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $user['email'] ?>" id="some" required>
          </div>
          <div class="form-group">
            <label for="some" class="col-form-label">Password</label>
            <input type="password" name="password" value="<?php echo $user['password'] ?>" class="form-control" id="some"  required>
          </div>
          <div class="center">
            <button class="btn btn-primary btn-sm btn-block" name="saveSetting">Save Setting</button>
          </div>   
        </form>
    </div>
</div>

</body>
</html>

<script type="text/javascript">
  $(document).ready(function(){$(".rightAccount").click(function(){$(".account").fadeToggle();});});
</script>

