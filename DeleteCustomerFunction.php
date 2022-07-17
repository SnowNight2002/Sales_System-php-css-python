<?php
if(isset($_POST['removeCustomer'])){
    include "conn.php";
    $conn = getDBconnection();
    var_dump($_POST['removeCustomer']);
    $email = $_POST['removeCustomer'];
    $sql = "SELECT * FROM orders WHERE customerEmail = '$email'"; //get order information from orders and customer email = post email
    $rs = mysqli_query($conn, $sql)
    or die(mysqli_error($conn));
    $num = mysqli_affected_rows($conn);
    if($num>0) {
        while ($rc = mysqli_fetch_assoc($rs)) {
            extract($rc);
            $sql = "DELETE FROM itemorders WHERE orderID = '$orderID'"; //Delete item order from itemorders table and order ID = post orderID
            $rs1 = mysqli_query($conn, $sql)
            or die(mysqli_error($conn));
            $itemOrderNum = mysqli_affected_rows($conn);
            if($itemOrderNum>0) {
                $sql = "DELETE FROM orders WHERE orderID = '$orderID'"; //Delete order from orders table and order ID = post orderID
                $rs2 = mysqli_query($conn, $sql)
                or die(mysqli_error($conn));
                $orderNum = mysqli_affected_rows($conn);
                var_dump($orderNum);
            }
        }
            $sql = "DELETE FROM customer WHERE customerEmail = '$email'"; //Delete customer from customer table and customer email = post email
            $rs3 = mysqli_query($conn, $sql)
            or die(mysqli_error($conn));
            header("Location:DeleteCustomer.php");
    }
    else{
        $sql = "DELETE FROM customer WHERE customerEmail = '$email'";  //Delete customer from customer table and customer email = post email
        $rs = mysqli_query($conn, $sql)
        or die(mysqli_error($conn));
        header("Location:DeleteCustomer.php");
    }
    mysqli_free_result($rs);
    mysqli_close($conn);
}
?>
