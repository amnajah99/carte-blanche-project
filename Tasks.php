<?php
include_once('config.php');
session_start();

if (isset($_SESSION['isSignedIn'])) {
    $username = $_SESSION['username'];

    $greeting =  "Hello $username";
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tasks</title>
    <!-- BootStrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">

</head>

<body class="bodyColor">
    <!-- NAVBAR -->
    <nav class="navbar navbarStyles">
        <div class=""><?php echo " $greeting " ?></div>
        <a href="signOut.php">Sign Out</a>
    </nav>

    <!-- DISPLAY TASKS -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <h4>Welcome to your to-do list!</h4>
            </div>
            <div class="offset-4 col-2">
                <button onclick="window.location.href='AddTask.php'">CREATE NEW TASK</button>
            </div>
        </div>

        <?php
        $res = mysqli_query($mysqlconn, "SELECT id FROM customer WHERE username = '$username'");
        $res1 = $res->fetch_assoc();
        $userid = $res1['id'];
        $res2 = mysqli_query($mysqlconn, "SELECT * FROM task WHERE user_id='$userid'");

        // FETCHING TASK RECORDS AND DISPLAYING THEM
        while ($result = mysqli_fetch_array($res2)) {
            $taskid = $result['id'];
            $res3 = mysqli_query($mysqlconn, "SELECT * FROM label WHERE task_id='$taskid'");
            echo '<div class="row mt-4 py-3" style="background-color: white;">';
            echo '<div class="col-2">' . $result['title'] . '</div>
            <div class="col-6 labels">';
            while ($res4 = mysqli_fetch_array($res3)) {
                echo '<span class = "mr-2">' . $res4['name'] . '</span>';
            }
            echo '</div>

            <div class="offset-2 col-2">
                <span class="pr-2">' . $result['priority'] . '</span>
                <form action="editTask.php?task_id='.$result['id'].'" method="GET" class="d-inline">
                    <input type="hidden" name="task_id" value="'.$result['id'].'">
                    <button type="submit" class="btn btn-secondary" name="edit" value="Edit"><i class="fa fa-edit"></i></button>
                </form>
                <form action="deleteTask.php" method="POST" class="d-inline">
                    <input type="hidden" name="task_id" value="'.$result['id'].'">
                    <button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="fa fa-trash"></i></button>
                </form>
            </div>
        </div>';
        }

        ?>
    </div>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>