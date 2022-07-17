<?php
include "conn.php";
$conn = getDBconnection();
session_start();

if(isset($_POST['View'])){//View order 表格的內容
    $output = "";
    $output .= "
    <table  border='1' cellpadding='0'>
    <tr>
    <th>orderID	</th>
    <th>itemID</th>
    <th>itemname</th>
    <th>orderQuantity</th>
    <th>soldPrice</th>

    </tr>
    ";
    $orderID=$_GET['id'];
    $query2 ="SELECT O.orderID,O.itemID,I.itemName,O.orderQuantity,O.soldPrice FROM itemorders O ,item I where orderID = '$orderID' and O.itemID = I.itemID ORDER BY I.itemName DESC;
     ";
    $result2 = mysqli_query($conn,$query2);


    while($row2 = mysqli_fetch_array($result2)){
        $output .= "   
        <tr>
        <td>".$row2['orderID']."</td>
        <td>".$row2['itemID']."</td>
        <td>".$row2['itemName']."</td>
        <td>".$row2['orderQuantity']."</td>
        <td>".$row2['soldPrice']."</td>

        ";

    }
    $output .= "</table>";
        


    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/Salessystemstyle.css">
    
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>View orders</title> 
</head>
<body>
<?php

if(!isset($_SESSION['staffName'])){
    header("Location: index.php");
}//要先login
?>

    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="img/logo.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Sales system</span>
                    <span class="profession">Better Limited</span>
                </div>
            </div><!--公司logo -->

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar"><!--menu選項 -->
            <div class="menu">

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="Salessystemhome.php">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="SalessystemPlaceorders.php">
                            <i class='bx bx-message-square-add icon' ></i>
                            <span class="text nav-text">Place orders</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="SalessystemVieworders.php">
                            <i class='bx bx-book-reader icon'></i>
                            <span class="text nav-text">View orders</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="SalessystemUpdateorder.php">
                            <i class='bx bx-upload icon' ></i>
                            <span class="text nav-text">Update order </span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="SalessystemDeleteorder.php">
                            <i class='bx bx-message-square-x icon' ></i>
                            <span class="text nav-text">Delete order</span>
                        </a>
                    </li>


                </ul>
            </div>

            <div class="bottom-content">
                <li class=""><!--logout選項 -->
                    <a href="logOut.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>


                
            </div>
        </div>

    </nav>

    <section class="home">
        <div class="title-text">View orders</div>

        <table  border='1' cellpadding='0'><!--表格 -->
            <tr>
            <th>orderID</th>
            <th>customer Email</th>
            <th>Customer Name</th>
            <th>customer Phone Number</th>
            <th>staffID</th>
            <th>staffName</th>
            <th>dateTime</th>
            <th>deliveryAddress</th>
            <th>deliveryDate</th>
            <th>orderAmount</th>
            <th>Action</th>
            </tr>
            
            <?php
            $Staff=$_SESSION['staffID'];
            $query ="select O.orderID, O.customerEmail, C.customerName, C.phoneNumber ,O.staffID,O.dateTime,O.dateTime,O.deliveryAddress ,O.deliveryDate,O.orderAmount from orders O,customer C WHERE O.customerEmail = C.customerEmail and O.staffID = '$Staff' ORDER BY `C`.`customerName` DESC, `O`.`orderID` DESC;";
            $result = mysqli_query($conn,$query);
            while($row = mysqli_fetch_array($result)){?>
            <div>
            <form method="post" action="SalessystemVieworders.php?id=<?=$row['orderID']?>"><!--找出database所有與員工相關的order -->
            <tr>
            <td><?=$row['orderID'];?></td>
            <td><?=$row['customerEmail'];?></td>
            <td><?=$row['customerName'];?></td>
            <td><?=$row['phoneNumber'];?></td>
            <td><?=$row['staffID'];?></td>
            <td><?=$_SESSION['staffName'];?></td>
            <td><?=$row['dateTime'];?></td>
            <td><?=$row['deliveryAddress'];?></td>
            <td><?=$row['deliveryDate'];?></td>
            <td><?=$row['orderAmount'];?></td>
            <td><input type="submit" name="View" class="btn" value="View"></td>
            </tr>
            </form>
            
            </div>
            <?php   }
            ?>
        </table>
            <div> 
            <div class="title-text">Orders Selected</div>
            
            <?php   
            if(isset($_POST['View'])){
            echo $output;//顯示View表格內容
            }
            ?>
            </div>
    </section>

<script>
    const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle");//取menu的元素


toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
})//按下menu的開關,就會關閉


</script>

</body>
</html>