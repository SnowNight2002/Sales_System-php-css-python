
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/Salessystemstyle.css">
    
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Sales system Menu</title> 
</head>
<body>
<?php
include "conn.php";
$conn = getDBconnection();
session_start();//get DB

if(!isset($_SESSION['staffName'])){
    header("Location: index.php");
}//要先login
$sql = "SELECT * FROM item";
$rs = mysqli_query($conn, $sql)
or die(mysqli_error($conn));
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
        <div class="title-text">Welcome home,<?php echo $_SESSION['staffName']?></div>
        <img src="img/w.gif" alt="welcome " style="width: 700px;height:480px;">
    </section>
    
    <script src="Salesscript.js"></script>
    <?php
                mysqli_free_result($rs);
                mysqli_close($conn);
    ?>

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