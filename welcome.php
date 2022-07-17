<?php
include "conn.php";
$conn = getDBconnection();
extract($_POST);
session_start();

if (!isset($_POST['submit'])){ //check login account and password

    $id = $_POST['ID'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM staff WHERE staffID='$id' AND password='$password'";
    $rs = mysqli_query($conn, $sql)
    or die(mysqli_error($conn));;

    if(mysqli_num_rows($rs)>0){
        $row = mysqli_fetch_assoc($rs);
        $_SESSION['staffName'] = $row['staffName'];
        $_SESSION['staffID'] = $row['staffID'];
        if($row['position']=="Manager"){
            header("Location:Manager.php");
        }
        else{
            header("Location:Salessystemhome.php");
        }
    }
    else{
        echo "<script>
                alert('Your staff ID or password is incorrect!');
                window.location.href = 'index.php';
                </script>";
    }
    mysqli_free_result($rs); ; // free the memory of the result set
    mysqli_close($conn);
}
?>
