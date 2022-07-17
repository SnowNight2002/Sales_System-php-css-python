<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
extract($_POST);
include "conn.php";
$conn = getDBconnection();
$sql = "SELECT * FROM itemOrders WHERE itemID = {$_POST['itemID']}"; //get item order information from itemOrders table and itemID = post itemID
$rs = mysqli_query($conn, $sql)
or die(mysqli_error($conn));
$num = mysqli_affected_rows($conn);

if($num==0){
    $sql = "DELETE FROM item WHERE itemID = {$_POST['itemID']}"; //if select num=0, delete item
    $rs = mysqli_query($conn, $sql)
    or die(mysqli_error($conn));
    $num = mysqli_affected_rows($conn);
    header("Location:EditItem.php");
}
else{
    echo "<h2>You cannot delete this item because the item is included in the item order!</h2>"; //if select num!=0, display message
    echo "<meta http-equiv=refresh content=4;url=EditItem.php>";
}
mysqli_free_result($rs);
mysqli_close($conn);
?>
</body>
</html>