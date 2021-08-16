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
  if (isset($_POST['safeIn'])) 
  {
    $filename = $_FILES['inPic']['name'];
    move_uploaded_file($_FILES["inPic"]["tmp_name"], "photo/".$_FILES["inPic"]["name"]);
    if ($con->query("insert into categories (name,pic) value ('$_POST[name]','$filename')")) {
      $notice ="<div class='alert alert-success'>Successfully Saved</div>";
    }
    else
      $notice ="<div class='alert alert-danger'>Not saved Error:".$con->error."</div>";
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
       <a href="addsupplier.php"><li><i>add new supplier</li></a>
<!--         <a href="newsell"><li><i class="fa fa-circle-o fa-fw"></i> New Sell</li></a> -->
       
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
    <?php echo $notice; ?>
    <div>
      
   <center>
      <a href="manageCat.php"><button  data-toggle="modal" data-target="#addIn"><i > </i> Manage Categories</button></a>
</center>
    </div>

  <?php 
    $array = $con->query("select * from categories");
    while ($row = $array->fetch_assoc()) 
    {
      $array2 = $con->query("select count(*) from inventeries where catId = '$row[id]'");
      $row2 = $array2->fetch_assoc();
  ?>
    <a href="inventeries.php?catId=<?php echo $row['id'] ?>"><div class="box2 col-md-3">
     <div class="center"> <img src="photo/<?php echo $row['pic'] ?>" style="width: 155px;height: 122px;" class='img-thumbnail'></div>
      <hr style="margin: 7px;">
      <span style="padding: 11px"><strong style="font-size: 10pt">Name</strong><span class="pull-right" style="color:blue;margin-right: 11px;"><?php echo $row['name'] ?></span></span>
      <hr style="margin: 7px;">
      <span style="padding: 11px"><strong style="font-size: 10pt">Available Qty</strong><span class="pull-right" style="color:blue;margin-right: 11px"><?php echo $row2['count(*)']; ?></span></span>
    </div></a>
  <?php
    }
   ?>
  </div>
</div>

<div id="addIn" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Inventory</h4>
      </div>
      <div class="modal-body"> <form method="POST" enctype="multipart/form-data">
        <div style="width: 77%;margin: auto;">
         
          <div class="form-group">
            <label for="some" class="col-form-label">Name</label>
            <input type="text" name="inName" class="form-control" id="some" required>
          </div>
          <div class="form-group">
            <label for="2" class="col-form-label">Picture</label>
            <input type="file" name="inPic" class="form-control" id="2" required>
          </div>
          
       
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="safeIn">Save Inventory</button>
      </div>
    </form>
    </div>

  </div>
</div>

</body>
</html>

<script type="text/javascript">
  $(document).ready(function(){$(".rightAccount").click(function(){$(".account").fadeToggle();});});
</script>

