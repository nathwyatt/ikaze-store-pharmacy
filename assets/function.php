<?php 


function siteTitle()
{	
	global $con;
	$array = $con->query("select * from site where id='1'");
	$row = $array->fetch_assoc();
	return $row['title'];
}
function siteName()
{	
	global $con;
	
	$array = $con->query("select * from site where id='1'");
	$row = $array->fetch_assoc();
	return $row['name'];
}
function adminName()
{	
	global $con;
	
	$array = $con->query("select * from users where id='$_SESSION[userId]'");
	$row = $array->fetch_assoc();
	return $row['name'];
}
function getAdminName($id)
{	
	global $con;
	
	$array = $con->query("select * from users where id='$id'");
	$row = $array->fetch_assoc();
	return $row['name'];
}
function getAllCat()
{	
	global $con;
	
	$array = $con->query("select * from categories");
	while($row = $array->fetch_assoc())
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
	
}
function getAllsup()
{	
	global $con;
	
	$array = $con->query("select * from supplier");
	while($row = $array->fetch_assoc())
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
	
}
function getAllcamp()
{	
	global $con;
	
	$array = $con->query("select * from campany");
	while($row = $array->fetch_assoc())
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
	
}
 ?>