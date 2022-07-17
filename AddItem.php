<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/AddItem.css" type="text/css"/>
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
            <div class="header">Add Item Information</div>
        <form action="AddItem.php" name="addItem" method="post">
            <div class="item-info">
                <div class="inputBox">
                    <span class="info">Item Name: </span>
                    <input type="text" placeholder="Enter an item name" name="itemName" required>
                </div>
                <div class="inputBox">
                    <span class="info">Item Description: </span>
                    <input type="text" placeholder="Enter item's description" name="itemDes">
                </div>
                <div class="inputBox">
                    <span class="info">Stock Quantity: </span>
                    <input type="text" placeholder="Enter item's stock quantity" pattern="[0-9]*" title="support number only" name="itemQty" required>
                </div>
                <div class="inputBox">
                    <span class="info">Price: </span>
                    <input type="text" placeholder="Enter item's price" pattern="[0-9]*" title="support number only" name="itemPrice" required>
                </div>
            </div>
            <input type="submit" name="btnAdd" value="Submit">
            <input type="reset" name="reset" value="Reset">
        </form>
            <?php
            if (isset($_POST['itemQty'])){//insert a new record to item table
                $conn = getDBconnection();
                extract($_POST);
                $itemID = "SELECT IFNULL (max(itemID), 0) +1 as nextID FROM item";
                $rs = mysqli_query($conn, $itemID)or die(mysqli_error($conn));
                $rc = mysqli_fetch_assoc($rs);

                $sql = "INSERT INTO item(itemID, itemName, itemDescription, stockQuantity, price) VALUES ('$rc[nextID]','$itemName','$itemDes','$itemQty', '$itemPrice')";
                mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $num = mysqli_affected_rows($conn);
                 if($num == 1){
                    //header("Location:Manager.php");
                    echo "<h2>Add item successful</h2>";
                }
                else {
                    echo "<h2>Add item failure, Please try again!</h2>";
                }
                mysqli_free_result($rs);
                mysqli_close($conn);
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
