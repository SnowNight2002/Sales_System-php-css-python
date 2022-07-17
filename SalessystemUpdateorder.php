<?php
include "conn.php";
$conn = getDBconnection();
session_start();

if(isset($_POST['Update'])){//Update sql
                $id = $_GET['id'];
                $deliveryAddresstxt = $_POST['deliveryAddresstxt'];
                $deliveryDatetxt = $_POST['deliveryDatetxt'];
                $sql = "UPDATE orders SET deliveryAddress = '$deliveryAddresstxt', deliveryDate = '$deliveryDatetxt' WHERE orderID = $id";
                mysqli_query($conn,$sql)or die(mysqli_error($conn));

          }
  
    
    
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/Salessystemstyle.css">
    
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Update order</title> 
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

            <div class="bottom-content"><!--logout選項 -->
                <li class="">
                    <a href="logOut.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>


                
            </div>
        </div>

    </nav>

    <section class="home">
        <div class="title-text">Update order</div>
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
            </tr>
            
            <?php
            $Staff=$_SESSION['staffID'];
            $query ="SELECT * FROM orders where staffID = '$Staff' ";
            $result = mysqli_query($conn,$query);
            while($row = mysqli_fetch_array($result)){?>
            <div>
            <form method="post" action="SalessystemUpdateorder.php?id=<?=$row['orderID']?> "><!--找出database所有與員工相關的order -->
            <tr>
            <td><?=$row['orderID'];?></td>
            <td><?=$row['customerEmail'];?></td>
            <td><?=$row['staffID'];?></td>
            <td><?=$row['dateTime'];?></td>
            <td><input type='text' name='deliveryAddresstxt' id='deliveryAddresstxt' value=<?=$row['deliveryAddress'];?>></td>
            <td><input type='date' name='deliveryDatetxt' id='deliveryDatetxt' value=<?=$row['deliveryDate'];?>></td>
            <td><?=$row['orderAmount'];?></td>
            <td><input type="submit" name="Update" class="btn" value="Update"></td>
            </tr>
            </form><!--order表格 -->
            
            </div>
            <?php   }
            ?>
        </table>

    </section>
    
    <script src="Salesscript.js"></script>

<script>
    const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle");//取menu的元素


toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");//按下menu的開關,就會關閉
})



</script>

</body>
</html>