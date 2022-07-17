<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/EmployeeReport.css" type="text/css"/>
    <title>Sales Manager Page</title>
</head>
<body>
<?php
include "conn.php";
$conn = getDBconnection();
session_start();
if(!isset($_SESSION['staffName'])){
    header("Location: index.php");
}?>
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
        <div class="header">Employee Report</div>
        <div class="month">
            <form action="EmployeeReport.php" method="post" name="getMonth" id="getMonth">
            <select name="month" id="month">
                <option selected>Choose a month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
                <button type="submit">Select</button>
        </div>
        </form>
        <table class="item-list">
            <thead>
            <tr>
                <th>Staff ID</th>
                <th>Staff Name</th>
                <th>Order Record</th>
                <th>Total Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!isset($_POST['month']) || $_POST['month']=="Choose a month"){ //check post month, if post is "choose a month" or no post, display all sales information
                $sql = "SELECT * FROM staff";
                $rs = mysqli_query($conn, $sql)
                or die(mysqli_error($conn));
                while ($rc = mysqli_fetch_assoc($rs)){
                    $sql1 = "SELECT * FROM orders";
                    $res = mysqli_query($conn,$sql1)or die(mysqli_error($conn));
                    $count = 0;
                    $totalAmount=0;
                    while ($rec = mysqli_fetch_assoc($res)){
                        if($rc['staffID']==$rec['staffID']){
                            $count += 1;
                            $totalAmount += $rec['orderAmount'];
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo $rc['staffID'];?></td>
                        <td><?php echo $rc['staffName'];?></td>
                        <td><?php echo $count;?></td>
                        <td><?php echo $totalAmount;?></td>
                    </tr>
            <?php
                }
            }
            else{
                $sql = "SELECT * FROM staff";
                $rs = mysqli_query($conn, $sql)
                or die(mysqli_error($conn));
                while ($rc = mysqli_fetch_assoc($rs)){
                $sql1 = "SELECT * FROM orders";
                $res = mysqli_query($conn,$sql1)or die(mysqli_error($conn));
                $count = 0;
                $totalAmount=0;
                while ($rec = mysqli_fetch_assoc($res)){
                    $datetime = strtotime($rec['dateTime']);
                    $time = date("m",$datetime);
                    if($rc['staffID']==$rec['staffID'] && $time == $_POST['month']){  //check post month, if post is equal month in order table, display relative information
                        $count += 1;
                        $totalAmount += $rec['orderAmount'];
                    }
                }
            ?>
                <tr>
                    <td><?php echo $rc['staffID'];?></td>
                    <td><?php echo $rc['staffName'];?></td>
                    <td><?php echo $count;?></td>
                    <td><?php echo $totalAmount;?></td>
                </tr>
            <?php
                }
            }
            mysqli_free_result($rs);
            mysqli_close($conn);
            ?>
            </tbody>
    </div>
</body>
</html>
