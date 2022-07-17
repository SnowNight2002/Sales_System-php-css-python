<?php
session_start();
include "conn.php";
$conn = getDBconnection();
date_default_timezone_set('Asia/Hong_Kong');//時區設定
if(isset($_POST['add_to_cart'])){//取得item內容放入購物車
    if(isset($_SESSION['cart'])){
      $session_array_id = array_column($_SESSION['cart'],"id");
        if(!in_array($_GET['id'],$session_array_id)){
            $session_array=array(
                'id' => $_GET['id'],
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity']
            );
            
            $_SESSION['cart'][]=$session_array;
        }

    }else{//保持現有購物車item內容
        $session_array=array(
            'id' => $_GET['id'],
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity']
        );

        $_SESSION['cart'][]=$session_array;
    }

}



if(isset($_POST['create'])){//生成訂單
    foreach($_SESSION['cart'] as $key => $value){
        $total = $total + $value['quantity'] * $value['price'];
    }//計total price用
    $discount = $total;
    $url = "http://127.0.0.1:8080/api/$total/$discount";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);//api 計算折扣用

    $Address = $_POST['DeliveryAddress'];
    $DeliveryDate = $_POST['DeliveryDate'];
    $Staff=$_SESSION['staffID'];
    $email=$_POST['email']; //取得放進database元素
    
    $time=date('Y-m-d H:i');//取得create當下時間
    
    $orderID = "SELECT IFNULL (max(orderID),0)+1 as nextID From orders";
    $rs = mysqli_query($conn,$orderID) or die(mysqli_error($conn));
    $rc = mysqli_fetch_assoc($rs);//取得目前最大訂單id然後加1

    if($data['discount']!=null && $_POST['DeliveryDate']!=null){
        $total = $data['discount'];
        $sql = "INSERT INTO orders(orderID,customerEmail,staffID,dateTime,deliveryAddress,deliveryDate,orderAmount) 
            VALUES ('$rc[nextID]','$email','$Staff','$time','$Address','$DeliveryDate','$total')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }//取得api +送貨日期

    else if($data['discount']!=null && $_POST['DeliveryDate']==null){
        $total = $data['discount'];
        $sql = "INSERT INTO orders(orderID,customerEmail,staffID,dateTime,deliveryAddress,deliveryDate,orderAmount) 
            VALUES ('$rc[nextID]','$email','$Staff','$time','$Address',null,'$total')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }//取得api

    else if($_POST['DeliveryDate']!=null && $data['discount']==null) {
        echo "<script type='text/javascript'>alert('Because of you are not open python discount api, so you do not get any discount!');</script>";
        $sql = "INSERT INTO orders(orderID,customerEmail,staffID,dateTime,deliveryAddress,deliveryDate,orderAmount) 
            VALUES ('$rc[nextID]','$email','$Staff','$time','$Address','$DeliveryDate','$total')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }//沒有取得api+有送貨日期

    else if($_POST['DeliveryDate']==null && $data['discount']==null){
        echo "<script type='text/javascript'>alert('Because of you are not open python discount api, so you do not get any discount!');</script>";
        $sql = "INSERT INTO orders(orderID,customerEmail,staffID,dateTime,deliveryAddress,deliveryDate,orderAmount) 
            VALUES ('$rc[nextID]','$email','$Staff','$time','$Address',null,'$total')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }//沒有取得api+沒有送貨日期

    if(!empty($_SESSION['cart'])){//itemorders
        foreach($_SESSION['cart'] as $key => $value){
        $itemid=$value['id'];
        $itemQuantity=$value['quantity'];
        $soldPrice=$value['price'] * $value['quantity'];
        
        $sql = "INSERT INTO itemorders(orderID,itemID,orderQuantity,soldPrice) 
        VALUES ('$rc[nextID]','$itemid','$itemQuantity','$soldPrice')";
        mysqli_query($conn,$sql)or die(mysqli_error($conn));
        }
    }
    $output = "";
    unset($_SESSION['cart']);//reset購物車
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
    
    <title>Place orders</title> 
</head>
<body>
<?php


if(!isset($_SESSION['staffName'])){//要先login
    header("Location: index.php");
}
$sql = "SELECT * FROM item";
$rs = mysqli_query($conn, $sql)
or die(mysqli_error($conn));// get item
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
            </div> <!--公司logo -->

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
        <div class="title-text">Place orders</div>
        <div>
        <div class="row">


        <?php
        $query ="SELECT * FROM item";
        $result = mysqli_query($conn,$query);// get sql item
        while($row = mysqli_fetch_array($result)){?>
            <div class='seeItem'>
            <form method="post" action="SalessystemPlaceorders.php?id=<?=$row['itemID']?> ">

            <h5 class="text-center">Name:<?=$row['itemName'];?></h5>
            <h5 class="text-center">Price:$<?=number_format($row['price'],2);?></h5>
            <input type="hidden"name="name" value="<?=$row['itemName'];?>">
            <input type="hidden"name="price" value="<?=$row['price'];?>">
            <input type="number" name="quantity"value="1"class="form-control">
            <input type="submit" name="add_to_cart" class="btn" value="Add to cart">
            </form>
            </div>
        <?php   }//item列表
        
        

        ?>
        </div>
        </div> 
        </div> 
        <div class="getitem"> 
        <div class="title-text">Item Selected</div>

            <?php
            $output = "";//購物車表格
            $output .= "
            <table  border='1' cellpadding='0'>
            <tr>
            <th>ID</th>
            <th>item name</th>
            <th>item price</th>
            <th>item quantity</th>
            <th>total price</th>
            <th>Action</th>
            </tr>
            ";
            $total = 0;
            if(!empty($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $key => $value){
                    $output .= "
                    
                    <tr>
                    <td>".$value['id']."</td>
                    <td>".$value['name']."</td>
                    <td>".$value['price']."</td>
                    <td>".$value['quantity']."</td>
                    <td>$".number_format($value['price'] * $value['quantity'],2)."</td>
                    <td>
                        <a href='SalessystemPlaceorders.php?action=remove&id=".$value['id']."'>
                        <button class='btn'>remove</button>
                        </a>
                    </td>
                    
                    ";

                    
                    $total = $total + $value['quantity'] * $value['price'];
                }
                $query2 ="SELECT customerEmail FROM customer";
                $result2 = mysqli_query($conn,$query2);
                ?>

                <?php
                $output .="
                <tr>
                <td colspan='3'></td>
                <td></b>Total Price</b></td>
                <td>".number_format($total,2)."</td>
                <td>
                    <a href='SalessystemPlaceorders.php?action=clearall'>
                    <button class='btn'>Clear All </button>
                    </a>
                </td>
                </tr>
               
                ";
                $discount=0;//顯示折扣
                if($total>=10000){
                    $discount=$total*(1-0.12);
                    $output .="
                    <tr>
                    <td colspan='3'></td>
                    <td></b>Discount Price</b></td>
                    
                    <td>".number_format($discount,2)."</td>
    
                    </tr>
                   
                    ";
                }elseif($total>=5000){
                    $discount=$total*(1-0.08);
                    $output .="
                    <tr>
                    <td colspan='3'></td>
                    <td></b>Discount Price</b></td>
                    
                    <td>".number_format($discount,2)."</td>
    
                    </tr>
                   
                    ";
                }elseif($total>=3000){
                    $discount=$total*(1-0.03);
                    $output .="
                    <tr>
                    <td colspan='3'></td>
                    <td></b>Discount Price</b></td>
                    
                    <td>".number_format($discount,2)."</td>
    
                    </tr>
                   
                    ";
                }
                $output .="</table>";
                $Amount=number_format($total,2);
                ?>
                <form name='form'  method='post'>
                
                Delivery Address:(optional)<input type='text' name='DeliveryAddress'><br>
                Delivery Date: (optional)<input type='date' name='DeliveryDate'><br>
                customer email:<select name='email' id='email'>
                    <!-- 顧客信息-->
                <?php
                while($row2 = mysqli_fetch_array($result2)){
                echo '<option value="' , $row2['customerEmail'] ,'">', $row2['customerEmail'], '</option>';
                }
                ?>
                </select></br>
                <input type='submit' name='create' class='btn' value='create order'>
                </form><!-- 送出顧客信息-->
                <?php
            }
            echo $output;//購物車表格內容
            ?>

        </div> 





    </section>

<?php
if(isset($_GET['action'])){
    if($_GET['action']=="clearall"){//清空車內容
        unset($_SESSION['cart']);
       
    }

    if($_GET['action']=="remove"){
        foreach($_SESSION['cart'] as $key => $value){
            if($value['id']== $_GET['id']){
                unset($_SESSION['cart'][$key]);//清 item
                
            }
        }
    }

}






mysqli_free_result($rs);
mysqli_close($conn);//關閉sql
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