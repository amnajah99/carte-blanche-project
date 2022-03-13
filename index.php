<?php
include_once('config.php');
session_start(); //START OR CONTINUE SESSION
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign In</title>

    <!-- BootStrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="outDiv bodyColor p-4 d-flex align-items-center justify-content-center">

        <!-- SIGN IN FORM -->
        <div class="formDiv p-4">
            <span class="formHeading">SIGN IN</span>
            <form action="" method="POST" name="signInForm">
                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control" type="text" name="username" placeholder="Username"></input>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="text" name="password" placeholder="Password"></input>
                </div>

                <div class="p-3 d-flex justify-content-center">
                    <button class=" btn bgColor" type="submit" name="signIn">Sign In</button>
                </div>
            </form>

            <!-- CHECK AND SEND DATA TO DB -->
            <?php
            if (isset($_POST['signIn'])) {
                $username = mysqli_real_escape_string($mysqlconn, $_POST['username']);
                $password = mysqli_real_escape_string($mysqlconn, $_POST['password']);

                if (empty($username) || empty($password)) {
                    if (empty($username)) {
                        echo "<font color='red'>*Enter Username</font>";
                    }
                    if (empty($password)) {
                        echo "<font color='red'>*Enter Password</font>";
                    }
                } else {
                    $result = mysqli_query($mysqlconn, "SELECT * FROM customer WHERE username='$username' AND password='$password'");
                    if (!$result) {
                        echo "<font color='red'>Invalid credentials</font>";
                    } else {
                        $rows = mysqli_num_rows($result);
                        if ($rows == 1) {
                            $_SESSION['isSignedIn'] = true;
                            $_SESSION['username'] = $username;
                            header("location: Tasks.php");
                        } else {
                            echo "<font color='red'>Invalid credentials</font>";
                        }
                    }
                }
                $mysqlconn->close();
            }
            ?>
            <span>Don't have an Account? <a href="signUp.php">Sign Up</a></span>
        </div>
    </div>


    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>