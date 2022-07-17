<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/DeleteCustomer.css" type="text/css"/>
    <title>Sales Manager Page</title>
</head>
<body>
<?php
include "conn.php";
$conn = getDBconnection();
session_start();
if (!isset($_SESSION['staffName'])) {
    header("Location: index.php");
}
$sql = "SELECT * FROM customer"; //get customer information from customer table
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
        <div class="header">Customer Information</div>
            <table class="item-list">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while($rc = mysqli_fetch_assoc($rs)){ //display customer information
                    extract($rc)?>
                    <tr>
                        <td><?php echo $customerEmail;?></td>
                        <td><?php echo $customerName;?></td>
                        <td><?php echo $phoneNumber;?></td>
                        <td> <form action="DeleteCustomerFunction.php" method="post" name="customerInfo" id="customerInfo">
                                <input type="hidden" name="removeCustomer" id="removeCustomer" value="<?=$customerEmail?>">
                                <input type="submit" value="Delete" name="Delete" class="Delete" onclick="return confirm('Are you sure you want to delete all record about this customer?')">
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        <?php
        mysqli_free_result($rs);
        mysqli_close($conn);
        ?>
        </div>
    </div>
</div>
</body>
</html>