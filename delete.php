<?php 
session_start();
    $delete_id = $_GET['delete_id'];
    include_once("database.php");
    $query = "DELETE FROM animals WHERE animal_id=$delete_id;";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message']="Record Deleted";
        echo "<script>location.href='index.php';</script>";
      } else {
        $_SESSION['message']="Error deleting record ! Try again";
      }
          
?>

