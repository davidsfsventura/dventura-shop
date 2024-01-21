<?php
require_once 'dbConfig.php';
$email = $_POST['email'];
$senha = $_POST['password'];
echo $email;
echo $senha;

$sql = "SELECT email, password FROM users where email='$email' AND password='$senha';";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 1) {
    session_start();
    $_SESSION["user"] = $email;
    header('Location:../accountinfo.php');
    exit();
} else {
    echo "<script>alert('Crendeciais Inválidas!')</script>";
}
