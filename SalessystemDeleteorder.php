<?php
include "conn.php";
$conn = getDBconnection();
session_start();

if(isset($_POST['View'])){
    $output = "";
    $output .= "
    <table  border='1' cellpadding='0'>
    <tr>
    <th>orderID	</th>
    <th>itemID</th>
    <th>orderQuantity</th>
    <th>soldPrice</th>
    </tr>
    ";
    $orderID=$_GET['id'];
    $query2 ="SELECT * FROM itemorders where orderID = '$orderID' ";
    $result2 = mysqli_query($conn,$query2);
    while($row2 = mysqli_fetch_array($result2)){
        $output .= "   
        <tr>
        <td>".$row2['orderID']."</td>
        <td>".$row2['itemID']."</td>
        <td>".$row2['orderQuantity']."</td>
        <td>".$row2['soldPrice']."</td>
        </tr>
        ";
    }//當使用者按View 就會loop所有 $orderID細節
    }
if(isset($_POST['Delete'])){
    $orderID=$_GET['id'];
    $sql="DELETE FROM itemorders WHERE orderID = '$orderID'";
    mysqli_query($conn,$sql)or die(mysqli_error($conn));
    $sql="DELETE FROM orders WHERE orderID = '$orderID'";
    mysqli_query($conn,$sql)or die(mysqli_error($conn));
}//當使用者按Delete根據$orderID使用sql去Delete itemorders and orders
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/Salessystemstyle.css">
    
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Delete order</title> 
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
            </div>    <!--公司logo -->

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu"><!--menu選項 -->

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
                <li><!--logout選項 -->

                    <a href="logOut.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>


                
            </div>
        </div>

    </nav>

    <section class="home">
        <div class="title-text">Delete order</div>
        <table  border='1' cellpadding='0'><!--表格 -->
            <tr>
            <th>orderID</th>
            <th>customerEmail</th>
            <th>staffID</th>
            <th>dateTime</th>
            <th>deliveryAddress</th>
            <th>deliveryDate</th>
            <th>orderAmount</th>
            <th>Action</th>
            <th>Delete</th>
            </tr>
            
            <?php
            $Staff=$_SESSION['staffID'];
            $query ="SELECT * FROM orders where staffID = '$Staff' ";
            $result = mysqli_query($conn,$query);
            while($row = mysqli_fetch_array($result)){?><!--找出database所有與員工相關的order -->
            <div class='col-md-4'>
            <form method="post" action="SalessystemDeleteorder.php?id=<?=$row['orderID']?> ">
            <tr>
            <td><?=$row['orderID'];?></td>
            <td><?=$row['customerEmail'];?></td>
            <td><?=$row['staffID'];?></td>
            <td><?=$row['dateTime'];?></td>
            <td><?=$row['deliveryAddress'];?></td>
            <td><?=$row['deliveryDate'];?></td>
            <td><?=$row['orderAmount'];?></td>
            <td><input type="submit" name="View" class="btn" value="View"></td>
            <td><input type="submit" name="Delete" class="btn" value="Delete"></td>
            </tr>
            </form><!--order表格 -->
            
            </div>
            <?php   }
            ?>
        </table>
            <div> 
            <div class="title-text">View orders</div>
            
            <?php   
            if(isset($_POST['View'])){
            echo $output;//根據上方的if(isset($_POST['View'])) + while($row2 = mysqli_fetch_array($result2)) loop出所有關於order的item
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