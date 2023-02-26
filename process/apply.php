<?php
// establish a database connection
$host = '';
$user = '';
$pass = '';
$database = '';
$conn = mysqli_connect($host, $user, $pass, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
// check if user is logged in
if (!isset($_SESSION['username'])) {
  header('Location: ../signin'); // redirect to login page if user is not logged in
  exit();
}

// get username from session
$username = $_SESSION['username'];

$aadhar = $_POST['aadhar'];
$license = $_POST['license'];
$pan = $_POST['pan'];
$passport = $_POST['passport'];

$count=0;

  if(isset($_POST['aadhar'])) {
    $query = "UPDATE verification SET aadhar='YES' WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $count=1;
  }
  
  if(isset($_POST['license'])) {
    $query = "UPDATE verification SET license='YES' WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $count=1;
 }
  
  if(isset($_POST['pan'])) {
    $query = "UPDATE verification SET pan='YES' WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $count=1;
  }
  
  if(isset($_POST['passport'])) {
    $query = "UPDATE verification SET passport='YES' WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $count=1;
  }

  if($count=1) {
    $query = "UPDATE verification SET status='ONQUEUE' WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $count=1;
  }


  // redirect the user to the dashboard page
header('Location: ../verification/');
exit();

// close the database connection
mysqli_close($conn);

?>
