<?php
include ("db.php");

$id=$_POST["id"];
$value=array();

$query1=" SELECT sender FROM inbox WHERE id='$id' ";
$result1=mysqli_query($connection,$query1);
$value[0]=mysqli_fetch_row($result1);

$query2="SELECT time_sent FROM inbox WHERE id='$id' ";
$result2=mysqli_query($connection,$query2);
$value[1]=mysqli_fetch_row($result2);

$query3="SELECT subject FROM inbox WHERE id='$id' ";
$result3=mysqli_query($connection,$query3);
$value[2]=mysqli_fetch_row($result3);

$query4="SELECT message FROM inbox WHERE id='$id' ";
$result4=mysqli_query($connection,$query4);
$value[3]=mysqli_fetch_row($result4);

$query="UPDATE inbox SET read_msg=0 where id='$id' ";
$result=mysqli_query($connection,$query);

$query5="SELECT * FROM inbox where read_msg=1";
$result5=mysqli_query($connection,$query5);
$new_msg=mysqli_num_rows($result4);
$value[4]=$new_msg;

$rvalue=json_encode($value);
echo "$rvalue";

?>