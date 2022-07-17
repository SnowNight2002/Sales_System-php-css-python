<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/UpdateItem.css" type="text/css"/>
    <title>Sales Manager Page</title>
</head>
<body>
<?php
include "conn.php";
$conn = getDBconnection();
session_start();
if(!isset($_SESSION['staffName'])){
    header("Location: index.php");
}
mysqli_close($conn);
?>
<div class="manager">
    <div class="left-border">
        <div class="left-content">
            <ul class="actions-list">
                <li class="item">
                    <img src="img\logo.png" alt="" class="logo">
                    <span class="companyName">&nbsp;&nbsp;Better Limited</span>
                    <span class="systemName">&nbsp;Manager System</span>
                </li>
                <li class="item">
                    <img src="img\Home.png" alt="Home" class="home">
                    <span><a href="Manager.php">Home</a></span>
                </li>
                <li class="item">
                    <img src="img\Add.png" alt="Add" class="add">
                    <span><a href="AddItem.php">Add Item</a></span>
                </li>
                <li class="item">
                    <img src="img\Edit.png" alt="Edit" class="edit">
                    <span><a href="EditItem.php">Edit Item</a></span>
                </li>
                <li class="item">
                    <img src="img\Delete.png" alt="Delete" class="delete">
                    <span><a href="DeleteCustomer.php">Delete Customer</a></span>
                </li>
                <li class="item">
                    <img src="img\Report.png" alt="Report" class="report">
                    <span><a href="EmployeeReport.php">Employee Report</a></span>
                </li>
                <span class="staffName"><?php echo $_SESSION['staffName']?></span>
                <li class="item">
                    <span><a href="logOut.php">Log out</a></span>
                </li>
            </ul>
        </div>
    </div>
    <div class="right-content">
        <div class="container">
            <div class="header">Update Item Information</div>
            <?php
            if(isset($_POST['itemID'])){ //display select item information from item table
                $conn = getDBconnection();
                extract($_POST);
                $sql = "SELECT * FROM item WHERE itemID= {$_POST['itemID']}";
                $rs = mysqli_query($conn, $sql)
                or die(mysqli_error($conn));
                $num = mysqli_num_rows($rs);

                if($num==0){
                    echo "Record not found<br>";
                }
                else{
                $rec = mysqli_fetch_assoc($rs);
                extract($rec);
                mysqli_close($conn);
            ?>
            <form action="UpdateItem.php" name="updateItem" method="post">
                <input type="hidden" name="UpdateItemID" id="UpdateItemID" value="<?php echo $itemID;?>">
                <div class="item-info">
                    <div class="inputBox">
                        <span class="info">Item Name: </span>
                        <input type="text" placeholder="sql item name" name="itemName" value="<?php echo $itemName;?>" required>
                    </div>
                    <div class="inputBox">
                        <span class="info">Item Description: </span>
                        <input type="text" placeholder="sql item description" name="itemDes" value="<?php echo $itemDescription;?>">
                    </div>
                    <div class="inputBox">
                        <span class="info">Stock Quantity: </span>
                        <input type="text" placeholder="sql item quantity" pattern="[0-9]*" title="support number only" name="itemQty" value="<?php echo $stockQuantity;?>"  required>
                    </div>
                    <div class="inputBox">
                        <span class="info">Price: </span>
                        <input type="text" placeholder="sql item price" pattern="[0-9]*" title="support number only" name="itemPrice" value="<?php echo $price;?>" required>
                    </div>
                </div>
                <input type="submit" name="btnUpdate" value="Submit">
                <input type="reset" name="reset" value="Reset">
            </form>
            <?php
            }}
            if(isset($_POST['UpdateItemID'])) {//update item information to item table
                //var_dump($_POST);
                extract($_POST);
                $conn = getDBconnection();
                $sql = "SELECT * FROM item WHERE itemID= {$_POST['UpdateItemID']}";
                $rs = mysqli_query($conn, $sql)
                or die(mysqli_error($conn));
                $num = mysqli_affected_rows($conn);
                if ($num == 0) {
                    echo "<br>Record no found";
                } else {
                    $sql = "UPDATE item SET itemID = {$_POST['UpdateItemID']}, itemName = '$itemName', itemDescription = '$itemDes', stockQuantity = '$itemQty', price = '$itemPrice' WHERE itemID = {$_POST['UpdateItemID']}";
                    mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $num = mysqli_affected_rows($conn);
                    if ($num == 1) {
                        echo "<h2>Update item successful!</h2>";
                        echo "<meta http-equiv=refresh content=2;url=EditItem.php>";
                    } else {
                        echo "<h2>Update item failure, Please update again!</h2>";
                        echo "<meta http-equiv=refresh content=2;url=EditItem.php>";
                    }
                    mysqli_close($conn);
                }
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
