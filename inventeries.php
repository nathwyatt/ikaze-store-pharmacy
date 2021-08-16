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
<link rel="stylesheet" href="js/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <title><?php echo siteTitle(); ?></title>
  <?php require "assets/autoloader.php" ?>
  <style type="text/css">
  <?php include 'css/customStyle.css'; ?>

  </style>

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
<?php 
if (isset($_GET['catId']))
{
  $catId = $_GET['catId'];
  $array = $con->query("select * from categories where id='$catId'");
  $catArray =$array->fetch_assoc();
  $catName = $catArray['name'];
  $stockArray = $con->query("select * from inventeries where catId='$catArray[id]'");
 
}
else
{
  $catName = "All Inventeries";
  $stockArray = $con->query("select * from inventeries");
}
  include 'assets/bill.php';
 ?>
  <div class="content">
   <ol class="breadcrumb ">
        <li><a href="index.php"><i > Dashboard</a></li>
        <li class="active"><?php echo $catName ?></li>
    </ol>
  <div class="tableBox" >
    <table id="dataTable" class="table table-bordered table-striped" style="z-index: -1">
      <thead>
        <th>no</th>
        <th>Name</th>
        <th>Unit</th>
        <th>Price Per Unit</th>
        <th>Supplier Name</th>
        <th>Company</th>
        <th>date</th>
        <th></th>
      </thead>
     <tbody>
      <?php $i=0;
        while ($row = $stockArray->fetch_assoc()) 
        { 
          $i=$i+1;
          $id = $row['id'];
        ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['unit']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['supplier']; ?></td>
            <td><?php echo $row['company']; ?></td>
			   <td><?php echo $row['date']; ?></td>
            <?php 
            if (!empty($_SESSION['bill'])) 
            {
             
            foreach ($_SESSION['bill'] as $key => $value) 
            {
              if (in_array($row['id'], $_SESSION['bill'][$key])) 
              {
                echo "<td>Selected</td>";break;
              }            
               else
               {
              ?>
            <td id='selection<?php echo $i; ?>'><button  onclick="addInBill('<?php echo $id ?>','<?php echo $i; ?>')">Select</button></td>
              <?php break;} } } else {?>
              <td id='selection<?php echo $i; ?>'><button  onclick="addInBill('<?php echo $id ?>','<?php echo $i; ?>')">Select</button></td>
              <?php } ?>
              <td colspan="center"><a href="delete.php?item=<?php echo $row['id'] ?>&url=<?php echo $_SERVER['QUERY_STRING'] ?>"><button >Delete Item</button></a></td>
          </tr>
      <?php
        }
       ?>
     </tbody>
    </table>
  </div>                      

  </div>  <!-- ending tag for content -->

</div> <!-- ending tag for margin left -->



</body>
</html>

<script type="text/javascript">
  function addInBill(id,place)
  { 
    var value = $("#counter").val();
    value ++;
    var selection = 'selection'+place;
    $("#bill").fadeIn();
    $("#counter").val(value);
    $("#"+selection).html("selected");
    $.post('called.php?q=addtobill',
               {
                   id:id
               }
        );

  }
  $(document).ready(function()
  {
    $(".rightAccount").click(function(){$(".account").fadeToggle();});
    $("#dataTable").DataTable();
   
  });
</script>

  <script src="js/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="js/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>