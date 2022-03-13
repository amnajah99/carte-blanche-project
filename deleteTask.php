<?php
include_once('config.php');
session_start();

// DELETE TASK FROM DB
if(isset($_POST['task_id'])) {
    $id = $_POST['task_id'];
    $sql = "DELETE FROM task WHERE id=$id";
	$result = mysqli_query($mysqlconn, $sql);

	$mysqlconn->close();
    header("location: Tasks.php");
}

?>