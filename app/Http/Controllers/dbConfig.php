<?php
$con = mysqli_connect("127.0.0.1", "root", "", "login");
mysqli_set_charset($con, "utf8");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
