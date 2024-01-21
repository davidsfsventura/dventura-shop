<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once 'dbConfig.php';
if (isset($_FILES['fileInput'])) {
    session_start();
    $user = $_SESSION['user'];
    $img_name = $_FILES['fileInput']['name'];
    $img_size = $_FILES['fileInput']['size'];
    $tmp_name = $_FILES['fileInput']['tmp_name'];
    $error = $_FILES['fileInput']['error'];

    if ($error === 0) {
        if ($img_size > 500000) {
            $em = "Sorry, your file is too large.";
            header("Location: ../accountinfo.php?error=$em");
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png", "gif");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../uploads/' . $new_img_name;
                move_uploaded_file($tmp_name, '../uploads/' . $img_ex_lc);
                $sql = "UPDATE users SET image='" . $new_img_name . "' WHERE email='" . $user . "';";
                mysqli_query($con, $sql);
                header("Location: ../accountinfo.php");
            } else {
                $em = "You can't upload files of this type";
                header("Location: ../accountinfo.php?error=$em");
            }
        }
    } else {
        $em = "unknown error occurred!";
        header("Location: ../accountinfo.php?error=$em");
    }
} else if (isset($_POST['removepicture'])) {
    echo "remove";
} else {
    echo "none";
}
