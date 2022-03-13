<?php
include_once("config.php");

// CHECK AND ADD DATA OF NEW USER TO DB 
if (isset($_POST['signUp'])) {
    $username = mysqli_real_escape_string($mysqlconn, $_POST['username']);
    $email = mysqli_real_escape_string($mysqlconn, $_POST['email']);
    $password = mysqli_real_escape_string($mysqlconn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($mysqlconn, $_POST['confirmpassword']);

    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || $password != $confirmPassword) {
        if (empty($username)) {
            echo "<font color='red'>*Enter Username</font>";
        }
        if (empty($email)) {
            echo "<font color='red'>*Enter Email</font>";
        }
        if (empty($password)) {
            echo "<font color='red'>*Enter Password</font>";
        }
        if (empty($confirmPassword)) {
            echo "<font color='red'>*Confirm Password</font>";
        }
        if ($password != $confirmPassword) {
            echo "<font color='red'>*Password is not the same</font>";
        }
    }

    $select = mysqli_query($mysqlconn, "SELECT * FROM customer WHERE username = '$username'");
    if (mysqli_num_rows($select)) {
        echo "<font color='red'>This username already exists</font>";
    } else {
        $result = mysqli_query($mysqlconn, "INSERT INTO customer(username,email,password) VALUES ('$username','$email','$password')");
        if ($result) {
            echo "<font color='green'>You're Signed Up!</font>";
        }
    }
    $mysqlconn->close();
    header("Location: index.php"); // Redirecting To Home Page
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>

    <!-- BootStrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="outDiv bodyColor p-4 d-flex align-items-center justify-content-center">

        <!-- SIGN UP FORM -->
        <div class="formDiv p-4">
            <span class="formHeading">SIGN UP</span>
            <form action="" method="POST" name="signUpForm">
                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control" type="text" name="username" placeholder="Username"></input>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" placeholder="Email"></input>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="text" name="password" placeholder="Password"></input>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input class="form-control" type="text" name="confirmpassword" placeholder="Confirm Password"></input>
                </div>

                <div class="p-3 d-flex justify-content-center">
                    <button class=" btn bgColor" type="submit" name="signUp">Sign Up</button>
                </div>
            </form>
            <span>Already have an Account? <a href="index.php">Sign In</a></span>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>