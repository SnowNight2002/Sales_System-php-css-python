<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/Manager.css" type="text/css"/>
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
$sql = "SELECT * FROM item"; //get item information from item table
$rs = mysqli_query($conn, $sql)
or die(mysqli_error($conn));
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
            <div class="header">Item List</div>
            <table class="item-list">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Item Description</th>
                        <th>Stock Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                <?php //display item information
                while ($rc = mysqli_fetch_assoc($rs)){?>
                    <tr>
                        <td><?php echo $rc['itemID'];?></td>
                        <td class="td2"><?php echo $rc['itemName'];?></td>
                        <td><?php echo $rc['itemDescription'];?></td>
                        <td><?php echo $rc['stockQuantity'];?></td>
                        <td><?php echo $rc['price'];?></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
                <?php
                mysqli_free_result($rs);
                mysqli_close($conn);
                ?>
        </div>
    </div>
</body>
</html>
