<?php 

    include './php/registration/config.php';

    session_start();

    error_reporting(0);

    if (isset($_SESSION["user_id"])) {
        header("Location: ./php/welcome.php");
    }

    if (isset($_POST["signup"])) {
    $signup_username = mysqli_real_escape_string($conn, $_POST["signup_user_name"]);
    $signup_email = mysqli_real_escape_string($conn, $_POST["signup_user_email"]);
    $signup_pswrd = mysqli_real_escape_string($conn, md5($_POST["signup_user_pswrd"]));
    $signup_cpswrd = mysqli_real_escape_string($conn, md5($_POST["signup_user_cpswrd"]));

    $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT user_email FROM user_data WHERE user_email='$signup_email'"));

    if ($signup_pswrd !== $signup_cpswrd) {
        echo "<script>alert('Password did not match.');</script>";
    } elseif ($check_email > 0) {
        echo "<script>alert('Email already exists in out database.');</script>";
    } else {
        $sql = "INSERT INTO user_data (user_name, user_email, user_pswrd) VALUES ('$signup_username', '$signup_email', '$signup_pswrd')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_POST["signup_user_name"] = "";
            $_POST["signup_user_email"] = "";
            $_POST["signup_user_pswrd"] = "";
            $_POST["signup_user_cpswrd"] = "";
            echo "<script>alert('Successful.');</script>";
        }   else {
            echo "<script>alert('Fu*ked of');</script>";
        }
    }
}

if (isset($_POST["signin"])) {
    $signin_email = mysqli_real_escape_string($conn, $_POST["signin_user_email"]);
    $signin_pswrd = mysqli_real_escape_string($conn, md5($_POST["signin_user_pswrd"]));
  
    $check_email = mysqli_query($conn, "SELECT id FROM user_data WHERE user_email='$signin_email' AND user_pswrd='$signin_pswrd'");
  
    if (mysqli_num_rows($check_email) > 0) {
      $row = mysqli_fetch_assoc($check_email);
      $_SESSION["user_id"] = $row['id'];
      header("Location: php/welcome.php");
    } else {
      echo "<script>alert('Login details is incorrect. Please try again.');</script>";
    }
  }

?>