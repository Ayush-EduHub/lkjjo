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

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- meta tags required for responsiveness and scalability -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- main Cascading Style Sheet file -->
    <link rel="stylesheet" href="css/registration/style.css">

    <!-- web page title meta tag -->
    <title>Document</title>

</head>

<body>

    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" method="post" class="sign-in-form">
                    <h2 class="title">Sign In</h2>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="text" placeholder="Email" name="signin_user_email" value="<?php echo $_POST['signin_user_email']; ?>" require>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="password" placeholder="Password" name="signin_user_pswrd" value="<?php echo $_POST['signin_user_pswrd']; ?>" require>
                    </div>
                    <input type="submit" value="Login" name="signin" class="btn solid">

                    <p class="social-text">Or Sign In with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icons">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icons">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icons">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icons">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>

                <form action="" class="sign-up-form" method="post">
                    <h2 class="title">Sign Up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username" name="signup_user_name" value="<?php echo $_POST["signup_user_name"]; ?>" require>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="text" placeholder="Email" name="signup_user_email" value="<?php echo $_POST["signup_user_email"]; ?>" require>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="password" placeholder="Password" name="signup_user_pswrd" value="<?php echo $_POST["signup_user_pswrd"]; ?>" require>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="password" placeholder="Confirm Password" name="signup_user_cpswrd" value="<?php echo $_POST["signup_user_cpswrd"]; ?>" require>
                    </div>
                    <input type="submit" value="Sign up" class="btn solid" name="signup">

                    <p class="social-text">Or Sign Up with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icons">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icons">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icons">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icons">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New Here?</h3>
                    <p>Lorem, ipsum dolor sit amet consectetui</p>
                    <button class="btn transparent" id="sign-up-btn">Sign up</button>
                </div>

                <img src="images/1.svg" class="image" alt="">
            </div>

            <div class="panel right-panel">
                <div class="content">
                    <h3>One of Us?</h3>
                    <p>Lorem, ipsum dolor sit amet consectetui</p>
                    <button class="btn transparent" id="sign-in-btn">Sign In</button>
                </div>

                <img src="images/2.svg" class="image" alt="">
            </div>
        </div>
    </div>

    <!-- FontAwesome JavaScript CDN link -->
    <script src="https://kit.fontawesome.com/3263aa9bae.js" crossorigin="anonymous"></script>

    <!-- main JavaScript file -reference -->
    <script src="js/registration/main.js"></script>

</body>

</html>