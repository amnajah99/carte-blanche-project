<?php
include_once('config.php');
session_start(); //START OR CONTNUE SESSION

// FETCH TASK AND ITS LABELS
if (isset($_GET['task_id'])) {
    $taskid = $_GET['task_id'];
    $res = mysqli_query($mysqlconn, "SELECT * FROM label WHERE task_id='$taskid'");
    $res2 = mysqli_query($mysqlconn, "SELECT * FROM task WHERE id='$taskid'");

    $res3 = $res2->fetch_assoc();
    $priority = $res3['priority'];
    $title = $res3['title'];
}

//CHECK IF USER IS SIGNED IN
if (isset($_SESSION['isSignedIn'])) {
    $username = $_SESSION['username'];
    $greeting = "Hello $username";
}

// STORING LABELS IN A STRING
$labels2 = "";
while ($res4 = mysqli_fetch_array($res)) {

    $labels2 = $labels2 . $res4['name'] . " ";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Task List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbarStyles">
        <div class=""><?php echo " $greeting " ?></div>
        <a href="signOut.php">Sign Out</a>
    </nav>

    <!-- UPDATE TASK FORM -->
    <div class="outDiv bodyColor p-4 d-flex align-items-center justify-content-center">
        <div class="formDiv p-4">
            <span class="formHeading">UPDATE TASK</span>
            <form action="" method="POST" name="addTaskForm">
                <div class="form-group">
                    <label>Task Title</label>
                    <input class="form-control" type="text" name="title" value="<?php echo "$title"; ?>"></input>
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
                    <input id="labelInput" class="form-control" type="text" name="labelInput" value="<?php echo "$labels2"; ?>"></input>
                </div>
                <button class="btn bgColor" type="button" name="addLabel" onclick="addLabels()">Add</button>
                <div id="labelDiv">
                </div>
                <input id="allLabels" type="text" name="allLabels" hidden></input>

                <div class="p-3 d-flex justify-content-center">
                    <button class=" btn bgColor" type="submit" name="editTask">Update Task</button>
                </div>
            </form>
            <span>Go back to <a href="Tasks.php">Tasks</a></span>
        </div>
    </div>

    <!-- UPDATING FIELDS IN DB -->
    <?php
    if (isset($_POST['editTask'])) {
        $titleNew = mysqli_real_escape_string($mysqlconn, $_POST['title']);
        $priorityNew = mysqli_real_escape_string($mysqlconn, $_POST['priority']);
        $labelsNew = mysqli_real_escape_string($mysqlconn, $_POST['allLabels']);
        $labelArrayNew = explode(" ", $labelsNew);


        if (empty($titleNew) || empty($priorityNew)) {
            if (empty($titleNew)) {
                echo "<font color='red'>*Enter Task Title</font>";
            }
            if (empty($priorityNew)) {
                echo "<font color='red'>*Enter Priority</font>";
            }
        } else {
            $result = mysqli_query($mysqlconn, "UPDATE task SET title='$titleNew' , priority='$priorityNew' WHERE id='$taskid'");
            if ($result) {
                echo "Task Updated";
            }


            $deleteLabel = mysqli_query($mysqlconn, "DELETE FROM label WHERE task_id = '$taskid'");

            array_pop($labelArrayNew);
            foreach ($labelArrayNew as $values) {
                $res = mysqli_query($mysqlconn, "INSERT INTO label(task_id,name) VALUES ('$taskid','$values')");
            }
            header("Location: Tasks.php");
        }
        $mysqlconn->close();
    }
    ?>

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
            console.log(label);
            document.getElementById('allLabels').value += label + " ";
        }
    </script>
</body>


</html>