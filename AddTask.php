<?php
include_once('config.php');
session_start();


// CHECK IF USER IS SIGNED IN
if (isset($_SESSION['isSignedIn'])) {
    $username = $_SESSION['username'];
    $res = mysqli_query($mysqlconn, "SELECT id FROM customer WHERE username='$username'");
    $result = $res->fetch_assoc();
    $userid = $result['id'];
    $greeting =  "Hello $username";
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Task List</title>

    <!-- BootStrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbarStyles">
        <div class=""><?php echo " $greeting " ?></div>
        <a href="signOut.php">Sign Out</a>
    </nav>

    <!-- ADD TASK FORM -->
    <div class="outDiv bodyColor p-4 d-flex align-items-center justify-content-center">
        <div class="formDiv p-4">
            <span class="formHeading">CREATE TASK</span>
            <form action="" method="POST" name="addTaskForm">
                <div class="form-group">
                    <label>Task Title</label>
                    <input class="form-control" type="text" name="title" placeholder="Add Title"></input>
                </div>

                <br />

                <div class="form-group">
                    <label>Priority</label>
                    <div class="btn-group" role="group">

                        <button type="button" class="btn bgColor" name="high" onclick="setPriority('high')">High</button>
                        <button type="button" class="btn bgColor" name="medium" onclick="setPriority('medium')">Medium</button>
                        <button type="button" class="btn bgColor" name="low" onclick="setPriority('low')">Low</button>
                        <input id="priority" type="text" name="priority" hidden></input>
                    </div>
                </div>

                <br />

                <div class="form-group">
                    <label>Label</label>
                    <input id="labelInput" class="form-control" type="text" name="labelInput" placeholder="Add Label"></input>
                </div>
                <button class="btn bgColor" type="button" name="addLabel" onclick="addLabels()">Add</button>
                <div id="labelDiv"></div>
                <input id="allLabels" type="text" name="allLabels" hidden></input>

                <div class="p-3 d-flex justify-content-center">
                    <button class=" btn bgColor" type="submit" name="addTask">Create Task</button>
                </div>
            </form>
            <span>Go back to <a href="Tasks.php">Tasks</a></span>

            <!-- CHECK AND ADD DATA TO DB  -->
            <?php
            if (isset($_POST['addTask'])) {
                $title = mysqli_real_escape_string($mysqlconn, $_POST['title']);
                $priority = mysqli_real_escape_string($mysqlconn, $_POST['priority']);

                $labels = mysqli_real_escape_string($mysqlconn, $_POST['allLabels']);
                $labelArray = explode(" ", $labels);

                if (empty($title) || empty($priority)) {
                    if (empty($title)) {
                        echo "<font color='red'>*Enter Task Title</font>";
                    }
                    if (empty($priority)) {
                        echo "<font color='red'>*Enter Priority</font>";
                    }
                } else {
                    $result = mysqli_query($mysqlconn, "INSERT INTO task(user_id,title,priority) VALUES ('$userid','$title','$priority')");
                    echo "Task Created";

                    $res = mysqli_query($mysqlconn, "SELECT id FROM task WHERE title='$title'");
                    $result = $res->fetch_assoc();
                    $task_id = $result['id'];

                    array_pop($labelArray);
                    foreach ($labelArray as $values) {
                        $res = mysqli_query($mysqlconn, "INSERT INTO label(task_id,name) VALUES ('$task_id','$values')");
                    }
                    header("Location: Tasks.php");
                }
                $mysqlconn->close();
            }
            ?>
        </div>
    </div>


    <!-- Script -->
    <script>
        // FUNCTION FOR SETTING PRIORITY
        function setPriority(name) {
            console.log(name);
            document.getElementById("priority").setAttribute("value", name);
        }

        //FUNCTION FOR DISPLAYING LABELS AND ADDING TO DB
        function addLabels() {
            var label = document.getElementById("labelInput").value;
            document.getElementById('labelDiv').innerHTML += label + " ";
            document.getElementById('allLabels').value += label + " ";
        }
    </script>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>


</html>